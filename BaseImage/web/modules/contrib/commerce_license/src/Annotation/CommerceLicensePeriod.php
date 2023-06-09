<?php

namespace Drupal\commerce_license\Annotation;

use Drupal\Component\Annotation\Plugin;

/**
 * Defines the license period plugin annotation object.
 *
 * Plugin namespace: Plugin/Commerce/LicensePeriod.
 *
 * @see plugin_api
 *
 * @Annotation
 */
class CommerceLicensePeriod extends Plugin {

  /**
   * The plugin ID.
   *
   * @var string
   */
  public $id;

  /**
   * The label of the plugin.
   *
   * @var \Drupal\Core\Annotation\Translation
   *
   * @ingroup plugin_translatable
   */
  public $label;

  /**
   * The description of the plugin.
   *
   * @var \Drupal\Core\Annotation\Translation
   *
   * @ingroup plugin_translatable
   */
  public $description;

}
