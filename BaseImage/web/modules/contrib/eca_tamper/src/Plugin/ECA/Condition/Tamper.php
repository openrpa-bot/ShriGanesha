<?php

namespace Drupal\eca_tamper\Plugin\ECA\Condition;

use Drupal\Component\Plugin\Exception\PluginException;
use Drupal\Core\Form\FormStateInterface;
use Drupal\eca\Plugin\ECA\Condition\ConditionBase;
use Drupal\eca\Plugin\ECA\Condition\StringComparisonBase;
use Drupal\eca_tamper\Plugin\TamperTrait;
use Drupal\tamper\Exception\SkipTamperDataException;
use Drupal\tamper\Exception\SkipTamperItemException;
use Drupal\tamper\Exception\TamperException;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provide all tamper plugins as ECA conditions.
 *
 * @EcaCondition(
 *   id = "eca_tamper_condition",
 *   deriver = "Drupal\eca_tamper\Plugin\ECA\Condition\TamperDeriver"
 * )
 */
class Tamper extends StringComparisonBase {

  use TamperTrait;

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition): ConditionBase {
    $instance = parent::create($container, $configuration, $plugin_id, $plugin_definition);
    $instance->tamperManager = $container->get('plugin.manager.tamper');
    $instance->setConfiguration($configuration);
    return $instance;
  }

  /**
   * {@inheritdoc}
   */
  protected function getLeftValue(): string {
    $data = $this->tokenServices->replaceClear($this->configuration['left']);
    try {
      $value = $this->tamperPlugin()->tamper($data);
    }
    catch (PluginException | SkipTamperDataException | TamperException | SkipTamperItemException $e) {
      $value = $data;
    }
    return $value ?? '';
  }

  /**
   * {@inheritdoc}
   */
  protected function getRightValue(): string {
    return $this->configuration['right'] ?? '';
  }

  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration(): array {
    return [
      'left' => '',
      'right' => '',
    ] + $this->tamperDefaultConfiguration();
  }

  /**
   * {@inheritdoc}
   */
  public function buildConfigurationForm(array $form, FormStateInterface $form_state): array {
    $form['left'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Data to be tampered'),
      '#default_value' => $this->configuration['left'] ?? '',
      '#weight' => -10,
    ];
    $form['right'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Data to compare with'),
      '#default_value' => $this->getRightValue(),
      '#weight' => -8,
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
    $this->configuration['left'] = $form_state->getValue('left');
    $this->configuration['right'] = $form_state->getValue('right');
    $this->submitTamperConfigurationForm($form, $form_state);
  }

}
