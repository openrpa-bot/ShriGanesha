<?php

namespace Drupal\tooltip_ckeditor\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Defines a form that configures forms module settings.
 */
class TooltipCkeditorAdminSettingsForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'tooltip_ckeditor_admin_settings';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'tooltip_ckeditor.settings',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('tooltip_ckeditor.settings');
    $form['tooltip_ckeditor_selector'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Apply tooltip on those CSS selectors.'),
      '#maxlength' => NULL,
      '#default_value' => $config->get('tooltip_ckeditor_selector'),
      '#description' => $this->t('Use jQuery selectors to define which link would trigger the tooltip function.'),
    ];
    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $values = $form_state->getValues();
    \Drupal::configFactory()->getEditable('tooltip_ckeditor.settings')
      ->set('tooltip_ckeditor_selector', $values['tooltip_ckeditor_selector'])
      ->save();
    parent::submitForm($form, $form_state);
  }




}
