<?php

namespace Drupal\commerce_ticketing\Routing;

use Drupal\Core\Entity\EntityTypeInterface;
use Symfony\Component\Routing\Route;
use Drupal\entity\Routing\DeleteMultipleRouteProvider as EntityDeleteMultipleRouteProvider;

/**
 * Provides the HTML route for deleting multiple entities.
 */
class DeleteMultipleRouteProvider extends EntityDeleteMultipleRouteProvider {

  /**
   * {@inheritdoc}
   */
  protected function deleteMultipleFormRoute(EntityTypeInterface $entity_type) {
    if ($entity_type->hasLinkTemplate('delete-multiple-form') && !$entity_type->hasHandlerClass('form', 'delete-multiple-confirm')) {
      $route = new Route($entity_type->getLinkTemplate('delete-multiple-form'));
      $route->setDefault('_form', '\Drupal\commerce_ticketing\Form\DeleteMultipleForm');
      $route->setDefault('entity_type_id', $entity_type->id());
      $route->setRequirement('_entity_delete_multiple_access', $entity_type->id());

      return $route;
    }
  }

}
