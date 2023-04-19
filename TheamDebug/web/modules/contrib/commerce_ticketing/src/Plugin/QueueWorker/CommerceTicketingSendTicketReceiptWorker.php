<?php

namespace Drupal\commerce_ticketing\Plugin\QueueWorker;

use Drupal\commerce_ticketing\Mail\TicketReceiptMail;
use Drupal\Core\Queue\QueueWorkerBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Core\StringTranslation\StringTranslationTrait;
use Psr\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\commerce_ticketing\CommerceTicketInterface;

/**
 * Processes send mail tasks for commerce_ticketing receipt.
 *
 * @QueueWorker(
 *   id = "commerce_ticketing_send_ticket_receipt_worker",
 *   title = @Translation("Commerce Ticketing send ticket receipt worker"),
 *   cron = {"time" = 60}
 * )
 */
class CommerceTicketingSendTicketReceiptWorker extends QueueWorkerBase implements ContainerFactoryPluginInterface {

  use StringTranslationTrait;

  /**
   * The ticket receipt mail.
   *
   * @var \Drupal\commerce_ticketing\Mail\TicketReceiptMail
   */
  protected $ticketReceiptMail;

  /**
   * A logger instance.
   *
   * @var \Psr\Log\LoggerInterface
   */
  protected $logger;

  /**
   * Constructs a new CommerceTicketingSendTicketReceiptWorker.
   *
   * @param array $configuration
   *   A configuration array containing information about the plugin instance.
   * @param string $plugin_id
   *   The plugin_id for the plugin instance.
   * @param mixed $plugin_definition
   *   The plugin implementation definition.
   * @param \Drupal\commerce_ticketing\Mail\TicketReceiptMail $ticket_receipt_mail
   *   The receipt mail service.
   * @param \Psr\Log\LoggerInterface $logger
   *   A logger instance.
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, TicketReceiptMail $ticket_receipt_mail, LoggerInterface $logger) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->ticketReceiptMail = $ticket_receipt_mail;
    $this->logger = $logger;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('commerce_ticketing.ticket_receipt_mail'),
      $container->get('logger.factory')->get('commerce_ticketing')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function processItem($data) {
    if ($data instanceof CommerceTicketInterface) {
      $result = $this->ticketReceiptMail->send($data);
      if ($result) {
        $order_item = $data->getOrderItem();
        $ticket_mail_sent_order_item_data = $order_item->getData('ticket_mail_sent');
        $ticket_mail_sent_order_item_data[$data->id()] = TRUE;
        $order_item->setData('ticket_mail_sent', $ticket_mail_sent_order_item_data);
        $order_item->save();
        $this->logger->info('Mail sent for ticket @number.', ['@number' => $data->getTicketNumber()]);
      }
      else {
        // This will ensure that the item stays in the queue and gets
        // processed later again.
        throw new \Exception($this->t('Ticket email could not be sent.'));
      }
    }
  }

}
