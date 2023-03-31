<?php

namespace Drupal\bat_event\Form;

use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\State\StateInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Drupal\Core\Form\FormStateInterface;

/**
 * Defines a form that configures forms module settings.
 */
class BatEventConfigurationForm extends ConfigFormBase {

  /**
   * State Manager.
   *
   * @var \Drupal\Core\State\StateInterface
   */
  protected $stateManager;

  /**
   * {@inheritdoc}
   */
  public function __construct(ConfigFactoryInterface $config_factory, StateInterface $stateManager) {
    parent::__construct($config_factory);
    $this->stateManager = $stateManager;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('config.factory'),
      $container->get('state')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'bat_event_admin_settings';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'bat_event.settings',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state, Request $request = NULL) {

    $config = $this->config('bat_event.settings');

    $form['remove_old_events'] = [
      '#type' => 'fieldset',
      '#title' => $this->t('Remove old events'),
      '#collapsible' => FALSE,
    ];

    $form['remove_old_events']['enable_remove_old_events'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Enable old events removal'),
      '#default_value' => $config->get('enable_remove_old_events'),
      '#description' => $this->t("Enable to remove old events. Be careful. Data will not be recoverable. This is usually enabled when data integrity won\'t change and a rubust Backup policy is setup."),
    ];

    $form['remove_old_events']['daysago'] = [
      '#default_value' => $config->get('daysago'),
      '#type' => 'number',
      '#title' => 'Day ago',
      '#description' => 'Remove events expired before this number of days',
      '#required' => TRUE,
    ];

    $form['remove_old_events']['howmany'] = [
      '#default_value' => $config->get('howmany'),
      '#description' => 'Number of events to remove at every cron',
      '#type' => 'number',
      '#title' => 'How many',
      '#required' => TRUE,
    ];

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $values = $form_state->getValues();
    $this->config('bat_event.settings')
      ->set('enable_remove_old_events', $values['enable_remove_old_events'])
      ->set('daysago', $values['daysago'])
      ->set('howmany', $values['howmany'])
      ->save();
  }

}
