<?php

namespace Drupal\commerce_ticketing\Mail;

use Drupal\commerce_ticketing\CommerceTicketInterface;
use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Language\LanguageManagerInterface;
use Drupal\Core\Logger\LoggerChannelInterface;
use Drupal\Core\Mail\MailManagerInterface;
use Drupal\Core\Render\RendererInterface;
use Drupal\Core\Session\AccountSwitcherInterface;
use Drupal\Core\StringTranslation\StringTranslationTrait;
use Drupal\entity_print\Plugin\EntityPrintPluginManagerInterface;
use Drupal\entity_print\PrintBuilderInterface;
use Symfony\Component\HttpFoundation\StreamedResponse;

class TicketReceiptMail {

  use StringTranslationTrait;

  /**
   * Logger.
   *
   * @var \Drupal\Core\Logger\LoggerChannelInterface
   */
  protected $logger;

  /**
   * The entity type manager.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * Mail manager service.
   *
   * @var \Drupal\Core\Mail\MailManagerInterface
   */
  protected $mailManager;

  /**
   * The plugin manager for our Print engines.
   *
   * @var \Drupal\entity_print\Plugin\EntityPrintPluginManagerInterface
   */
  protected $pluginManager;

  /**
   * The Print builder.
   *
   * @var \Drupal\entity_print\PrintBuilderInterface
   */
  protected $printBuilder;

  /**
   * The object renderer.
   *
   * @var \Drupal\Core\Render\RendererInterface
   */
  protected $renderer;

  /**
   * The account switcher service.
   *
   * @var \Drupal\Core\Session\AccountSwitcherInterface
   */
  protected $accountSwitcher;

  /**
   * The configuration factory.
   *
   * @var \Drupal\Core\Config\ConfigFactoryInterface
   */
  protected $configFactory;

  /**
   * The language manager.
   *
   * @var \Drupal\Core\Language\LanguageManagerInterface
   */
  protected $languageManager;

  /**
   * TicketReceiptMail constructor.
   *
   * @param \Drupal\Core\Logger\LoggerChannelInterface $logger
   *   Logger.
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entity_type_manager
   *   The entity type manager.
   * @param \Drupal\Core\Mail\MailManagerInterface $mail_manager
   *   Mail manager service.
   * @param \Drupal\entity_print\Plugin\EntityPrintPluginManagerInterface $plugin_manager
   *   Entity Print plugin manager.
   * @param \Drupal\entity_print\PrintBuilderInterface $print_builder
   *   Entity Print builder.
   * @param \Drupal\Core\Render\RendererInterface $renderer
   *   The object renderer.
   * @param \Drupal\Core\Session\AccountSwitcherInterface $account_switcher
   *   The account switcher service.
   * @param \Drupal\Core\Config\ConfigFactoryInterface $config_factory
   *   The configuration factory.
   * @param \Drupal\Core\Language\LanguageManagerInterface $language_manager
   *   The language manager.
   */
  public function __construct(LoggerChannelInterface $logger, EntityTypeManagerInterface $entity_type_manager, MailManagerInterface $mail_manager, EntityPrintPluginManagerInterface $plugin_manager, PrintBuilderInterface $print_builder, RendererInterface $renderer, AccountSwitcherInterface $account_switcher, ConfigFactoryInterface $config_factory, LanguageManagerInterface $language_manager) {
    $this->logger = $logger;
    $this->entityTypeManager = $entity_type_manager;
    $this->mailManager = $mail_manager;
    $this->pluginManager = $plugin_manager;
    $this->printBuilder = $print_builder;
    $this->renderer = $renderer;
    $this->accountSwitcher = $account_switcher;
    $this->configFactory = $config_factory;
    $this->languageManager = $language_manager;
  }

  /**
   * Sends ticket receipt by email and attaches the PDF if available.
   */
  public function send(CommerceTicketInterface $ticket, $to = NULL, $bcc = NULL) {
    try {
      $order = $ticket->getOrder();
      $customer = $ticket->getOwner() ?? $order->getCustomer();
      $to = $to ?? $order->getEmail() ?? $customer->getEmail();
      if (!$to) {
        return FALSE;
      }
      // Default site langcode, if the ticket owner is not anonymous, use that
      // instead.
      $langcode = $this->languageManager->getCurrentLanguage()->getId();
      if ($customer->isAuthenticated()) {
        $langcode = $customer->getPreferredLangcode();
      }
      if ($ticket->hasTranslation($langcode)) {
        $ticket = $ticket->getTranslation($langcode);
      }

      $subject = $this->t('Ticket for your order #@number', ['@number' => $order->getOrderNumber()]);
      $body = $this->entityTypeManager->getViewBuilder('commerce_ticket')->view($ticket, 'receipt');
      $params = [
        'subject' => $subject,
        'from' => $order->getStore()->getEmail(),
        'bcc' => $bcc,
        'order' => $order,
        'ticket' => $ticket,
        'body' => $this->renderer->renderRoot($body),
      ];

      $print_engine = $this->pluginManager->createSelectedInstance('pdf');
      $config = $this->configFactory->get('entity_print.settings');

      // We need to switch accounts to the customer, so we can print the ticket
      // as if we were the user, otherwise it might try to print as anonymous
      // and show blank tickets.
      $this->accountSwitcher->switchTo($customer);

      // PDF generation inline so we don't have to deal with files.
      $contents = $this->printBuilder->deliverPrintableForMail([$ticket], $print_engine, $config->get('default_css'));

      $this->accountSwitcher->switchBack();

      $params['attachment'] = [
        'filename' => $ticket->uuid() . '.pdf',
        'filecontent' => $contents,
        'filemime' => 'application/pdf',
      ];

      $result = $this->mailManager->mail('commerce_ticketing', 'ticket_receipt', $to, $langcode, $params);
      if ($result['result']) {
        return TRUE;
      }
      else {
        $this->logger->warning('Email for ticket %ticket was not sent to: %to', ['%ticket' => $ticket->uuid(), '%to' => $to]);
        return FALSE;
      }
    }
    catch (\Exception $e) {
      watchdog_exception('commerce_ticketing', $e);
      return FALSE;
    }
  }

}
