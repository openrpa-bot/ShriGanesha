<?php

namespace Drupal\commerce_ticketing\Plugin\Field\FieldFormatter;

use Drupal\commerce_ticketing\CommerceTicketInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Field\FieldDefinitionInterface;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Core\Render\RendererInterface;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Color\Color;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelHigh;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelLow;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelMedium;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelQuartile;
use Endroid\QrCode\Label\Alignment\LabelAlignmentCenter;
use Endroid\QrCode\Label\Alignment\LabelAlignmentLeft;
use Endroid\QrCode\Label\Alignment\LabelAlignmentRight;
use Endroid\QrCode\Label\Font\NotoSans;
use Endroid\QrCode\RoundBlockSizeMode\RoundBlockSizeModeMargin;
use Endroid\QrCode\Writer\PngWriter;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Extension\ModuleHandler;

/**
 * QR Code formatter for tickets.
 *
 * @FieldFormatter(
 *   id = "commerce_ticketing_qr_code",
 *   label = @Translation("Ticket QR Code"),
 *   field_types = {
 *     "image"
 *   },
 * )
 */
class CommerceTicketingQrCodeFormatter extends FormatterBase implements ContainerFactoryPluginInterface {

  /**
   * The entity type manager.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * The renderer.
   *
   * @var \Drupal\Core\Render\RendererInterface
   */
  protected $renderer;

  /**
   * The ModuleHandler.
   *
   * @var Drupal\Core\Extension\ModuleHandler
   */
  protected $moduleHandler;

  /**
   * Constructs a new CommerceTicketingQrCodeFormatter object.
   *
   * @param string $plugin_id
   *   The plugin_id for the formatter.
   * @param mixed $plugin_definition
   *   The plugin implementation definition.
   * @param \Drupal\Core\Field\FieldDefinitionInterface $field_definition
   *   The definition of the field to which the formatter is associated.
   * @param array $settings
   *   The formatter settings.
   * @param string $label
   *   The formatter label display setting.
   * @param string $view_mode
   *   The view mode.
   * @param array $third_party_settings
   *   Any third party settings.
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entity_type_manager
   *   The entity type manager.
   * @param \Drupal\Core\Render\RendererInterface $renderer
   *   The renderer.
   * @param Drupal\Core\Extension\ModuleHandler $module_handler
   *   The module handler.
   */
  public function __construct($plugin_id, $plugin_definition, FieldDefinitionInterface $field_definition, array $settings, $label, $view_mode, array $third_party_settings, EntityTypeManagerInterface $entity_type_manager, RendererInterface $renderer, ModuleHandler $module_handler) {
    parent::__construct($plugin_id, $plugin_definition, $field_definition, $settings, $label, $view_mode, $third_party_settings);

    $this->entityTypeManager = $entity_type_manager;
    $this->renderer = $renderer;
    $this->moduleHandler = $module_handler;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $plugin_id,
      $plugin_definition,
      $configuration['field_definition'],
      $configuration['settings'],
      $configuration['label'],
      $configuration['view_mode'],
      $configuration['third_party_settings'],
      $container->get('entity_type.manager'),
      $container->get('renderer'),
      $container->get('module_handler')

    );
  }

  /**
   * {@inheritdoc}
   */
  public static function defaultSettings() {
    return [
      'size' => 250,
      'margin' => 10,
      'font_size' => 20,
      'error_correction_level' => 'high',
      'background_color' => '#FFFFFF',
      'foreground_color' => '#000000',
      'label_text_color' => '#000000',
      'label_alignment' => 'center',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function settingsForm(array $form, FormStateInterface $form_state) {
    $form = parent::settingsForm($form, $form_state);

    $form['size'] = [
      '#title' => $this->t('Size'),
      '#type' => 'number',
      '#min' => 1,
      '#default_value' => $this->getSetting('size'),
    ];
    $form['margin'] = [
      '#title' => $this->t('Margin'),
      '#type' => 'number',
      '#min' => 1,
      '#default_value' => $this->getSetting('margin'),
    ];
    $form['font_size'] = [
      '#title' => $this->t('font_size'),
      '#type' => 'number',
      '#min' => 1,
      '#default_value' => $this->getSetting('font_size'),
    ];
    $form['error_correction_level'] = [
      '#title' => $this->t('Error correction level'),
      '#type' => 'options',
      '#options' => [
        'low' => $this->t('Low'),
        'medium' => $this->t('Medium'),
        'high' => $this->t('High'),
        'quartile' => $this->t('Quartile'),
      ],
      '#default_value' => $this->getSetting('error_correction_level'),
    ];
    $form['background_color'] = [
      '#title' => $this->t('Background color'),
      '#type' => 'color',
      '#default_value' => $this->getSetting('background_color'),
    ];
    $form['foreground_color'] = [
      '#title' => $this->t('Foreground color'),
      '#type' => 'color',
      '#default_value' => $this->getSetting('foreground_color'),
    ];
    $form['label_text_color'] = [
      '#title' => $this->t('Label text color'),
      '#type' => 'color',
      '#default_value' => $this->getSetting('label_text_color'),
    ];
    $form['label_alignment'] = [
      '#title' => $this->t('Label alignment'),
      '#type' => 'options',
      '#options' => [
        'left' => $this->t('Left'),
        'right' => $this->t('Right'),
        'center' => $this->t('Center'),
      ],
      '#default_value' => $this->getSetting('label_alignment'),
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $element = [];

    $ticket = $items->getEntity();
    if (!$ticket instanceof CommerceTicketInterface) {
      return $element;
    }

    $view_builder = $this->entityTypeManager->getViewBuilder('commerce_ticket');
    $label_text = $view_builder->view($ticket, 'qr_code_label');
    $label_text = trim(preg_replace("/(BSR_ANYCRLF)\R/", '', strip_tags($this->renderer->renderPlain($label_text))));
    $default_data = $ticket->uuid();

    // Allow modules to alter the QR code data.
    $this->moduleHandler->alter('commerce_ticketing_qr_code_value', $default_data, $ticket);

    $result = Builder::create()
      ->writer(new PngWriter())
      ->writerOptions([])
      ->data($default_data)
      ->encoding(new Encoding('UTF-8'))
      ->errorCorrectionLevel($this->getErrorCorrectionLevel())
      ->size($this->getSetting('size'))
      ->margin($this->getSetting('margin'))
      ->roundBlockSizeMode(new RoundBlockSizeModeMargin())
      ->labelText($label_text)
      ->labelFont(new NotoSans($this->getSetting('font_size')))
      ->labelAlignment($this->getLabelAlignment())
      ->backgroundColor($this->hextoColor($this->getSetting('background_color')))
      ->foregroundColor($this->hextoColor($this->getSetting('foreground_color')))
      ->labelTextColor($this->hextoColor($this->getSetting('label_text_color')))
      ->build();

    $element[] = [
      '#theme' => 'image',
      '#uri' => $result->getDataUri(),
    ];

    return $element;
  }

  /**
   * {@inheritdoc}
   */
  public static function isApplicable(FieldDefinitionInterface $field_definition) {
    return $field_definition->getTargetEntityTypeId() == 'commerce_ticket';
  }

  /**
   * Gets the error correction level for the QR Code.
   *
   * @return \Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelInterface
   *   Correction level.
   */
  protected function getErrorCorrectionLevel() {
    switch ($this->getSetting('error_correction_level')) {
      case 'low':
        return new ErrorCorrectionLevelLow();

      case 'medium':
        return new ErrorCorrectionLevelMedium();

      case 'quartile':
        return new ErrorCorrectionLevelQuartile();

      case 'high':
      default:
        return new ErrorCorrectionLevelHigh();
    }
  }

  /**
   * Gets the label alignment for the QR Code.
   *
   * @return \Endroid\QrCode\Label\Alignment\LabelAlignmentInterface
   *   The label alignment.
   */
  protected function getLabelAlignment() {
    switch ($this->getSetting('label_alignment')) {
      case 'left':
        return new LabelAlignmentLeft();

      case 'right':
        return new LabelAlignmentRight();

      case 'center':
      default:
        return new LabelAlignmentCenter();
    }
  }

  /**
   * Converts hexadecimal to a QR code color object.
   *
   * @param string $hex
   *   Hex code.
   *
   * @return \Endroid\QrCode\Color\ColorInterface
   *   Color object.
   */
  protected function hextoColor($hex) {
    [$r, $g, $b] = _color_unpack($hex);
    return new Color($r, $g, $b);
  }

}
