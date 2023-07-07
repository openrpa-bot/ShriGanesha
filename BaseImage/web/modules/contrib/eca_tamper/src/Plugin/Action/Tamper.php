<?php

namespace Drupal\eca_tamper\Plugin\Action;

use Drupal\Component\Plugin\Exception\PluginException;
use Drupal\Core\Form\FormStateInterface;
use Drupal\eca\Plugin\Action\ConfigurableActionBase;
use Drupal\eca_tamper\Plugin\TamperTrait;
use Drupal\tamper\Exception\SkipTamperDataException;
use Drupal\tamper\Exception\SkipTamperItemException;
use Drupal\tamper\Exception\TamperException;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provide all tamper plugins as ECA actions.
 *
 * @Action(
 *   id = "eca_tamper",
 *   deriver = "Drupal\eca_tamper\Plugin\Action\TamperDeriver"
 * )
 */
class Tamper extends ConfigurableActionBase {

  use TamperTrait;

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition): ConfigurableActionBase {
    $instance = parent::create($container, $configuration, $plugin_id, $plugin_definition);
    $instance->tamperManager = $container->get('plugin.manager.tamper');
    return $instance;
  }

  /**
   * {@inheritdoc}
   */
  public function execute(): void {
    $data = $this->tokenServices->replaceClear($this->configuration['eca_data']);
    try {
      $value = $this->tamperPlugin()->tamper($data);
    }
    catch (PluginException | SkipTamperDataException | TamperException | SkipTamperItemException $e) {
      $value = $data;
    }

    $this->tokenServices->addTokenData($this->configuration['eca_token_name'], $value);
  }

  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration(): array {
    return [
      'eca_data' => '',
      'eca_token_name' => '',
    ] + $this->tamperDefaultConfiguration();
  }

  /**
   * {@inheritdoc}
   */
  public function buildConfigurationForm(array $form, FormStateInterface $form_state): array {
    $form['eca_data'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Data'),
      '#default_value' => $this->configuration['eca_data'],
      '#weight' => -10,
    ];
    $form['eca_token_name'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Token name'),
      '#default_value' => $this->configuration['eca_token_name'],
      '#weight' => -9,
    ];
    return $this->buildTamperConfigurationForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function validateConfigurationForm(array &$form, FormStateInterface $form_state): void {
    $this->validateTamperConfigurationForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitConfigurationForm(array &$form, FormStateInterface $form_state): void {
    $this->configuration['eca_data'] = $form_state->getValue('eca_data');
    $this->configuration['eca_token_name'] = $form_state->getValue('eca_token_name');
    $this->submitTamperConfigurationForm($form, $form_state);
  }

}
