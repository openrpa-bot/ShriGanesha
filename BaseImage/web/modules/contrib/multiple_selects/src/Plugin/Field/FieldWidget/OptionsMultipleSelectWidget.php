<?php

namespace Drupal\multiple_selects\Plugin\Field\FieldWidget;

use Drupal\Core\Extension\ModuleHandlerInterface;
use Drupal\Core\Field\FieldDefinitionInterface;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\Plugin\Field\FieldWidget\OptionsSelectWidget;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Render\Element;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Plugin implementation of the 'options_select' widget.
 *
 * @FieldWidget(
 *   id = "multiple_options_select",
 *   label = @Translation("Multiple select list(s)"),
 *   field_types = {
 *     "entity_reference",
 *     "list_integer",
 *     "list_float",
 *     "list_string"
 *   },
 * )
 */
class OptionsMultipleSelectWidget extends OptionsSelectWidget {

  /**
   * The module handler.
   *
   * @var \Drupal\Core\Extension\ModuleHandlerInterface
   */
  protected $moduleHandler;

  /**
   * {@inheritdoc}
   */
  public function __construct($plugin_id, $plugin_definition, FieldDefinitionInterface $field_definition, array $settings, array $third_party_settings, ModuleHandlerInterface $module_handler) {
    parent::__construct($plugin_id, $plugin_definition, $field_definition, $settings, $third_party_settings);

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
      $configuration['third_party_settings'],
      $container->get('module_handler'),
    );
  }

  /**
   * {@inheritdoc}
   */
  public function form(FieldItemListInterface $items, array &$form, FormStateInterface $form_state, $get_delta = NULL) {
    $element = parent::form($items, $form, $form_state, $get_delta);
    $element['widget']['#element_validate'][] = [get_class($this), 'validateMultipleElements'];
    $element['widget']['#column'] = $this->column;
    return $element;
  }

  /**
   * {@inheritdoc}
   */
  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state) {
    $element['#required'] = FALSE;
    $option_element = parent::formElement($items, $delta, $element, $form, $form_state);
    $option_element['#type'] = $this->getSetting('element_type');
    $option_element['#multiple'] = FALSE;

    $element[$this->column] = $option_element;
    $element[$this->column]['#default_value'] = empty($items[$delta]->{$this->column}) ? '_none' : $items[$delta]->{$this->column};
    $element[$this->column]['#multiple'] = FALSE;
    unset($element['#type']);

    return $element;
  }

  /**
   * {@inheritdoc}
   */
  public static function defaultSettings() {
    return [
      'element_type' => 'select',
    ] + parent::defaultSettings();
  }

  /**
   * {@inheritdoc}
   */
  public function settingsForm(array $form, FormStateInterface $form_state) {
    $options = [
      'select' => t('Select'),
    ];
    if ($this->moduleHandler->moduleExists('select2')) {
      $options['select2'] = t('Select2');
    }
    $element['element_type'] = [
      '#type' => 'select',
      '#title' => t('Element type'),
      '#options' => $options,
      '#default_value' => $this->getSetting('element_type'),
      '#description' => t('Form element to use.'),
    ];
    return $element;
  }

  /**
   * {@inheritdoc}
   */
  public function settingsSummary() {
    $summary = [];

    $element_type = $this->getSetting('element_type');
    if (!empty($element_type)) {
      $summary[] = t('Element: @element_type', ['@element_type' => $element_type]);
    }
    else {
      $summary[] = t('Element: select');
    }

    return $summary;
  }

  /**
   * {@inheritdoc}
   */
  public static function validateMultipleElements(array $element, FormStateInterface $form_state) {
    if ($element['#required'] == TRUE) {
      foreach (Element::children($element) as $key) {
        if (is_int($key) && $element[$key][$element['#column']]['#value'] != '_none') {
          return;
        }
      }
      $form_state->setError($element[0], t('@name field is required.', ['@name' => $element['#title']]));
    }
  }

  /**
   * {@inheritdoc}
   */
  public static function validateElement(array $element, FormStateInterface $form_state) {
    if (isset($element['#value']) && $element['#value'] === '_none') {
      $form_state->setValueForElement($element, NULL);
    }
  }

}
