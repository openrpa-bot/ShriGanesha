<?php

namespace Drupal\commerce_ticketing;

use Drupal\commerce\CommerceEntityViewsData;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\views\EntityViewsDataInterface;

/**
 * Provides Views data for Ticket entities.
 */
class CommerceTicketViewsData extends CommerceEntityViewsData implements EntityViewsDataInterface {

  /**
   * {@inheritdoc}
   */
  public function getViewsData() {
    $data = parent::getViewsData();
    // Add state dropwdown filter.
    $data['commerce_ticket']['state']['filter']['id'] = 'state_machine_state';
    return $data;
  }

  /**
   * {@inheritdoc}
   */
  public function getViewsTableForEntityType(EntityTypeInterface $entity_type) {
    return $entity_type->getDataTable() ?: $entity_type->getBaseTable();
  }

}
