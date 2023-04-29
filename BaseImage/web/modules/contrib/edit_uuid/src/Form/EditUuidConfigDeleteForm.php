<?php

namespace Drupal\edit_uuid\Form;

use Drupal\Core\Entity\EntityDeleteForm;
use Drupal\edit_uuid\EditUuidConfigStorage;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Database\Connection;

/**
 * Builds the  config deletion form.
 */
class EditUuidConfigDeleteForm extends EntityDeleteForm {

  /**
   * The database connection.
   *
   * @var \Drupal\Core\Database\Connection
   */
  protected $database;

  /**
   * The  config storage.
   *
   * @var \Drupal\edit_uuid\EditUuidConfigStorage
   */
  protected $storage;

  /**
   * Constructs a EditUuidConfigDeleteForm object.
   */
  public function __construct(Connection $database, EditUuidConfigStorage $storage) {
    $this->database = $database;
    $this->storage = $storage;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('database'),
      $container->get('entity.manager')->getStorage('edit_uuid_config')
    );
  }

}
