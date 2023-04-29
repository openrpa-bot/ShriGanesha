<?php

namespace Drupal\tooltip_ckeditor\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\filter\Entity\FilterFormat;
use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\HtmlCommand;
use Drupal\editor\Ajax\EditorDialogSave;
use Drupal\Core\Ajax\CloseModalDialogCommand;

/**
 * Provides an image dialog for text editors.
 */
class EditorTooltipDialog extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'editor_tooltip_dialog';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state, FilterFormat $filter_format = NULL) {
    $form['#tree'] = TRUE;
    $form['#attached']['library'][] = 'editor/drupal.editor.dialog';
    $form['#prefix'] = '<div id="editor-tooltip-dialog-form">';
    $form['#suffix'] = '</div>';
    $form['attributes']['title'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Enter Text:'),
      '#required' => TRUE,
    ];
    $form['attributes']['href'] = [
      '#type' => 'hidden',
      '#value' => '#',
    ];
    $form['attributes']['class'] = [
      '#type' => 'hidden',
      '#value' => 'tooltip',
    ];
    $form['actions']['save_modal'] = [
      '#type' => 'submit',
      '#value' => $this->t('Save'),
      '#submit' => [],
      '#ajax' => [
        'callback' => '::submitForm',
        'event' => 'click',
      ],
    ];
    // get value user entered before.
    if (isset($form_state->getUserInput()['editor_object']['title'])) {
      $form['attributes']['title']['#default_value'] = $form_state->getUserInput()['editor_object']['title'];
    }
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $response = new AjaxResponse();
    if (trim($form_state->getValue(['attributes', 'title'])) === '""') {
      $form_state->setValue(['attributes', 'title'], '');
      $form_state->setValue(['attributes', 'href'], '#');
      $form_state->setValue(['attributes', 'class'], 'tooltip');
    }
    if ($form_state->getErrors()) {
      unset($form['#prefix'], $form['#suffix']);
      $form['status_messages'] = [
        '#type' => 'status_messages',
        '#weight' => -10,
      ];
      $response->addCommand(new HtmlCommand('#editor-tooltip-dialog-form', $form));
    }
    else {
      $response->addCommand(new EditorDialogSave($form_state->getValues()));
      $response->addCommand(new CloseModalDialogCommand());
    }
    return $response;
  }

}
