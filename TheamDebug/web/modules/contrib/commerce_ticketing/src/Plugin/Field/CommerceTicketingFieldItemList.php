<?php

namespace Drupal\commerce_ticketing\Plugin\Field;

use Drupal\Core\TypedData\ComputedItemListTrait;
use Drupal\file\Plugin\Field\FieldType\FileFieldItemList;

/**
 * Provides a fake Item list to generate the computed field.
 */
class CommerceTicketingFieldItemList extends FileFieldItemList {

  use ComputedItemListTrait;

  /**
   * {@inheritdoc}
   */
  protected function computeValue() {
    $this->list[0] = $this->createItem(0, []);
  }

  /**
   * {@inheritdoc}
   */
  public function isEmpty() {
    return FALSE;
  }

}
