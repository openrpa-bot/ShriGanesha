<?php

namespace Drupal\commerce_ticketing\Form;

use Drupal\Core\Entity\Form\DeleteMultipleForm as CoreDeleteMultipleForm;
use Drupal\Core\Url;

/**
 * Provides an entities deletion confirmation form.
 */
class DeleteMultipleForm extends CoreDeleteMultipleForm {

  /**
   * {@inheritdoc}
   */
  public function getCancelUrl() {
    if ($this->entityType->hasLinkTemplate('admin-collection')) {
      return new Url('entity.' . $this->entityTypeId . '.admin-collection');
    }
    else {
      return parent::getCancelUrl();
    }
  }
}
