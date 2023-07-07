<?php

namespace Drupal\edit_uuid\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBase;
use Drupal\Core\Config\Entity\ConfigEntityInterface;

/**
 * Defines the Shortcut set configuration entity.
 *
 * @ConfigEntityType(
 *   id = "edit_uuid_config",
 *   label = @Translation("Edit UUID configuration"),
 *   handlers = {
 *     "storage" = "Drupal\edit_uuid\EditUuidConfigStorage",
 *     "access" = "Drupal\edit_uuid\EditUuidConfigAccessControlHandler",
 *     "list_builder" = "Drupal\edit_uuid\EditUuidConfigListBuilder",
 *     "form" = {
 *       "default" = "Drupal\edit_uuid\EditUuidConfigForm",
 *       "add" = "Drupal\edit_uuid\EditUuidConfigForm",
 *       "edit" = "Drupal\edit_uuid\EditUuidConfigForm",
 *       "delete" = "Drupal\edit_uuid\Form\EditUuidConfigDeleteForm"
 *     }
 *   },
 *   config_prefix = "form",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label",
 *     "config_type" = "config_type",
 *     "config_key" = "config_key",
 *     "config_value" = "config_value"
 *   },
 *   links = {
 *     "delete-form" = "/admin/config/development/edit-uuid-config/manage/{edit_uuid_config}/delete",
 *     "edit-form" = "/admin/config/development/edit-uuid-config/manage/{edit_uuid_config}",
 *     "collection" = "/admin/config/development/edit-uuid-config",
 *   },
 *   config_export = {
 *     "id",
 *     "label",
 *     "config_type",
 *     "config_key",
 *     "config_value",
 *   }
 * )
 */
class EditUuidConfig extends ConfigEntityBase implements ConfigEntityInterface {

  /**
   * The machine name for the configuration entity.
   *
   * @var string
   */
  protected $id;

  /**
   * The human-readable name of the configuration entity.
   *
   * @var string
   */
  protected $label;

  /**
   * Provides configuration key of config.
   */
  public function configKey() {
    return $this->get('config_key');
  }

  /**
   * Provides configuration value of config.
   */
  public function configValue() {
    return $this->get('config_value');
  }

  /**
   * Provides configuration type of config.
   */
  public function configType() {
    return $this->get('config_type');
  }

}
