<?php

namespace Drupal\edit_uuid;

use Drupal\Core\Entity\BundleEntityFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Entity\ContentEntityType;
use Drupal\Core\Ajax\HtmlCommand;
use Drupal\Core\Ajax\AjaxResponse;

/**
 * Form handler for the EditUuid config entity edit forms.
 */
class EditUuidConfigForm extends BundleEntityFormBase {

  /**
   * {@inheritdoc}
   */
  public function form(array $form, FormStateInterface $form_state) {
    $form = parent::form($form, $form_state);

    /** @var \Drupal\edit_uuid\Entity\EditUuidConfig $entity */
    $entity = $this->entity;
    $form['label'] = [
      '#type' => 'textfield',
      '#title' => t('Settings Name'),
      '#description' => t('Enter the name for this settings'),
      '#required' => TRUE,
      '#default_value' => $entity->label(),
    ];
    $form['id'] = [
      '#type' => 'machine_name',
      '#machine_name' => [
        'exists' => '\Drupal\edit_uuid\Entity\EditUuidConfig::load',
        'source' => ['label'],
        'replace_pattern' => '[^a-z0-9-]+',
        'replace' => '-',
      ],
      '#default_value' => $entity->id(),
      // This id could be used for menu name.
      '#maxlength' => 23,
    ];

    $all = \Drupal::entityTypeManager()->getDefinitions();
    foreach ($all as $key => $value) {
      if ($value instanceof ContentEntityType) {
        $entity_types[$key] = $value->getLabel();
      }
    }
    $form['config_key'] = [
      '#type' => 'select',
      '#title' => t('Entity Type'),
      '#description' => t('Entity type'),
      '#required' => TRUE,
      '#options' => $entity_types,
      '#default_value' => $entity->ConfigKey(),
      '#ajax' => [
        'callback' => [$this, 'getBundles'],
        'event' => 'change',
        'method' => 'html',
        'wrapper' => 'bundle-to-update',
        'progress' => [
          'type' => 'throbber',
          'message' => NULL,
        ],
      ],
    ];
    $options = [];
    if ($entity->ConfigKey() != "") {
      $bundlesObj = \Drupal::service('entity_type.bundle.info')->getBundleInfo($entity->ConfigKey());
      foreach ($bundlesObj as $key => $value) {
        $options[$key] = $value['label'];
      }
    }

    $form['config_value'] = [
      '#title' => t('Bundle'),
      '#type' => 'select',
      '#description' => t('Select the bundles that you wish to show UUID in edit form'),
      '#options' => $options,
      '#default_value' => $entity->ConfigValue(),
      '#attributes' => ["id" => 'bundle-to-update'],
      '#multiple' => TRUE,
      '#validated' => TRUE,
    ];

    $form['config_type'] = [
      '#type' => 'checkbox',
      '#title' => t('Just show UUID & disable editing'),
      '#description' => t('Selecting this option will just show the UUID and it can be edited'),
      '#default_value' => $entity->ConfigType(),
    ];

    $form['actions']['submit']['#value'] = t('Create new configuration');
    $form['actions']['submit']['#limit_validation_errors'] = [];
    return $this->protectBundleIdElement($form);
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    $entity = $this->entity;
    $is_new = !$entity->getOriginalId();
    $entity->save();

    if ($is_new) {
      $this->messenger()->addMessage($this->t('The %set_name EditUuid configuration has been created.', ['%set_name' => $entity->label()]));
    }
    else {
      $this->messenger()->addMessage($this->t('Updated EditUuid configuration name to %set-name.', ['%set-name' => $entity->label()]));
    }
    $form_state->setRedirectUrl($this->entity->toUrl('collection'));
  }

  /**
   * {@inheritdoc}
   */
  public function getBundles(array &$element, FormStateInterface $form_state) {
    $triggeringElement = $form_state->getTriggeringElement();
    $value = $triggeringElement['#value'];
    $bundlesObj = \Drupal::service('entity_type.bundle.info')->getBundleInfo($value);
    foreach ($bundlesObj as $key => $value) {
      $options[$key] = $value['label'];
    }
    $wrapper_id = $triggeringElement["#ajax"]["wrapper"];
    $renderedField = '';
    foreach ($options as $key => $value) {
      $renderedField .= "<option value='" . $key . "'>" . $value . "</option>";
    }
    $response = new AjaxResponse();
    $response->addCommand(new HtmlCommand("#" . $wrapper_id, $renderedField));
    return $response;
  }

}
