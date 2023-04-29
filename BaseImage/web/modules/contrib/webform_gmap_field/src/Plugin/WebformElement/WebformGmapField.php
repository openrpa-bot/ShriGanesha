<?php

namespace Drupal\webform_gmap_field\Plugin\WebformElement;

use Drupal\Core\Form\FormStateInterface;
use Drupal\webform\Plugin\WebformElementBase;

/**
 * Provides a 'webform_gmap_field' element.
 *
 * @WebformElement(
 *   id = "webform_gmap_field",
 *   label = @Translation("Webform Gmap Field"),
 *   description = @Translation("Provides a webform Google map field
 *     allowing to select user location and collect location coordinates."),
 *   category = @Translation("Google Map"),
 * )
 *
 * @see \Drupal\webform_gmap_field\Element\WebformExampleElement
 * @see \Drupal\webform\Plugin\WebformElementBase
 * @see \Drupal\webform\Plugin\WebformElementInterface
 * @see \Drupal\webform\Annotation\WebformElement
 */
class WebformGmapField extends WebformElementBase {

  /**
   * {@inheritdoc}
   */
  protected function defineDefaultProperties() {
    // Here you define your webform element's default properties,
    // which can be inherited.
    //
    // @see \Drupal\webform\Plugin\WebformElementBase::defaultProperties
    // @see \Drupal\webform\Plugin\WebformElementBase::defaultBaseProperties
    return [
      'multiple' => '',
      'size' => '',
      'minlength' => '',
      'maxlength' => '',
      'placeholder' => '',
    ] + parent::defineDefaultProperties();
  }

  /**
   * {@inheritdoc}
   */
  /*
  public function prepare(array &$element,
  WebformSubmissionInterface $webform_submission = NULL) {
  parent::prepare($element, $webform_submission);

  // Here you can customize the webform element's properties.
  // You can also customize the form/render element's properties via the
  // FormElement.
  //
  // @see \Drupal\webform_gmap_field\Element\WebformExampleElement::processWebformElementExample
  }
   */

  /**
   * {@inheritdoc}
   */
  public function form(array $form, FormStateInterface $form_state) {
    $form = parent::form($form, $form_state);
    // Here you can define and alter a webform element's properties UI.
    // Form element property visibility and default values are defined via
    // ::defaultProperties.
    //
    // @see \Drupal\webform\Plugin\WebformElementBase::form
    // @see \Drupal\webform\Plugin\WebformElement\TextBase::form
    return $form;
  }

}
