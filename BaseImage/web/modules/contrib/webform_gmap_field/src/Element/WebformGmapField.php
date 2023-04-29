<?php

namespace Drupal\webform_gmap_field\Element;

use Drupal\Core\Render\Element;
use Drupal\Core\Render\Element\FormElement;
use Drupal\Core\Form\FormStateInterface;

/**
 * Provides a 'webform_gmap_field'.
 *
 * Webform elements are just wrappers around form elements, therefore every
 * webform element must have correspond FormElement.
 *
 * Below is the definition for a custom 'webform_gmap_field' which just
 * renders a simple text field.
 *
 * @FormElement("webform_gmap_field")
 *
 * @see \Drupal\Core\Render\Element\FormElement
 * @see https://api.drupal.org/api/drupal/core%21lib%21Drupal%21Core%21Render%21Element%21FormElement.php/class/FormElement
 * @see \Drupal\Core\Render\Element\RenderElement
 * @see https://api.drupal.org/api/drupal/namespace/Drupal%21Core%21Render%21Element
 * @see \Drupal\webform_gmap_field\Element\WebformGmapElement
 */
class WebformGmapField extends FormElement {

  /**
   * {@inheritdoc}
   */
  public function getInfo() {
    $class = get_class($this);
    return [
      '#input' => TRUE,
      '#size' => 60,
      '#process' => [
        [$class, 'processWebformGmapElement'],
        [$class, 'processAjaxForm'],
      ],
      '#element_validate' => [
        [$class, 'validateWebformGmapElement'],
      ],
      '#pre_render' => [
        [$class, 'preRenderWebformGmapElement'],
      ],
      '#theme' => 'input__webform_gmap_field',
      '#theme_wrappers' => ['form_element'],
    ];
  }

  /**
   * Processes a 'webform_gmap_field' element.
   */
  public static function processWebformGmapElement(&$element, FormStateInterface $form_state, &$complete_form) {
    // Here you can add and manipulate your element's properties and callbacks.
    if ($element['#webform_plugin_id'] == 'webform_gmap_field') {
      $element['#attached']['library'][] = 'webform_gmap_field/global';

      /*$element['#suffix'] = '<div id="map" style="height:400px; border:1px solid green; width:100%; float:left;">map loading...</div>';*/
      $description = "";
      if (!empty($element['#description']['#markup'])) {
        $description = $element['#description']['#markup'];
      }
      $element['#description']['#markup'] = $description . '<div id="map" style="height:400px; border:1px solid green; width:100%; float:left;">map loading...</div>';

      // Added an unique id use selector in js code.
      $element['#attributes']['id'] = 'webform_gmap_field';
      if (!empty($element['#value'])) {
        $element['#attached']['drupalSettings']['user_location'] = $element['#value'];
      }
    }

    return $element;
  }

  /**
   * Webform element validation handler for #type 'webform_gmap_field'.
   */
  public static function validateWebformGmapElement(&$element, FormStateInterface $form_state, &$complete_form) {
    // Here you can add custom validation logic.
  }

  /**
   * Prepares a #type 'email_multiple' render element for theme_element().
   *
   * @param array $element
   *   An associative array containing the properties of the element.
   *   Properties used: #title, #value, #description, #size, #maxlength,
   *   #placeholder, #required, #attributes.
   *
   * @return array
   *   The $element with prepared variables ready for theme_element().
   */
  public static function preRenderWebformGmapElement(array $element) {
    $element['#attributes']['type'] = 'text';
    Element::setAttributes($element, [
      'id',
      'name',
      'value',
      'size',
      'maxlength',
      'placeholder',
    ]
    );
    static::setAttributes($element, ['form-text', 'webform-gmap-element']);
    return $element;
  }

}
