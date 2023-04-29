<?php

namespace Drupal\edit_uuid\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FormatterBase;

/**
 * Plugin implementation of the 'uuid' formatter.
 *
 * @FieldFormatter(
 *   id = "edit_uuid",
 *   label = @Translation("UUID"),
 *   field_types = {
 *     "uuid",
 *   },
 * )
 */
class EditUuidFieldFormatter extends FormatterBase {

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $elements = [];
    $user = \Drupal::currentUser();
    if ($user->hasPermission('show edit_uuid')) {
      foreach ($items as $delta => $item) {
        $elements[$delta] = [
          '#markup' => $item->value,
        ];
      }
    }
    return $elements;
  }

}
