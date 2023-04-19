<?php

namespace Drupal\tooltip_ckeditor\Plugin\CKEditorPlugin;

use Drupal\ckeditor\CKEditorPluginBase;
use Drupal\ckeditor\CKEditorPluginConfigurableInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\editor\Entity\Editor;

/**
 * Defines the "tooltip_ckeditor" plugin.
 *
 * @CKEditorPlugin(
 *   id = "tooltip_ckeditor",
 *   label = @Translation("Tooltip Ckeditor"),
 *   module = "Tooltip_ckeditor"
 * )
 */
class Tooltip extends CKEditorPluginBase implements CKEditorPluginConfigurableInterface {

  /**
   * Implements \Drupal\ckeditor\Plugin\CKEditorPluginInterface::isInternal().
   */
  public function isInternal() {
    return FALSE;
  }

  /**
   * {@inheritdoc}
   */
  public function getFile() {
    return drupal_get_path('module', 'tooltip_ckeditor') . '/js/plugins/tooltip/plugin.js';
  }

  /**
   * {@inheritdoc}
   */
  public function getConfig(Editor $editor) {
    return [
      'tooltipCkeditor_dialogTitleAdd' => t('Add Text'),
      'tooltipCkeditor_dialogTitleEdit' => t('Edit Text'),
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getLibraries(Editor $editor) {
    return [
      'core/drupal.ajax',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getButtons() {
    return [
      'Tooltip' => [
        'label' => t('Tooltip'),
        'image' => drupal_get_path('module', 'tooltip_ckeditor') . '/js/plugins/tooltip/icons/tooltip.png',
      ],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function settingsForm(array $form, FormStateInterface $form_state, Editor $editor) {
    $form['tooltip_text'] = [
      '#type' => 'checkbox',
      '#title' => t('Plugin to add tooltip'),
      '#attributes' => ['checked' => 'checked'],
      '#element_validate' => [
        [$this, 'validateTooltipTextSelection'],
      ],
    ];
    return $form;
  }

  /**
   * Element_validate handler for the "linkit_profile" element settingsForm().
   */
  public function validateTooltipTextSelection(array $element, FormStateInterface $form_state) {
    $toolbar_buttons = $form_state->getValue([
      'editor',
      'settings',
      'toolbar',
      'button_groups',
    ]);
    if (strpos($toolbar_buttons, '"Tooltip"') !== FALSE && empty($element['#value'])) {
      $form_state->setError($element, t('Please select the dropcap text you wish to use.'));
    }
  }

}
