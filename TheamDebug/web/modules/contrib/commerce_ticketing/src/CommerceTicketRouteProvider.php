<?php

namespace Drupal\commerce_ticketing;

use Drupal\commerce_ticketing\Controller\TicketController;
use Drupal\Component\Uuid\Uuid;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\entity\Routing\AdminHtmlRouteProvider;
use Symfony\Component\Routing\Route;

/**
 * Provides routes for the Ticket entity.
 */
class CommerceTicketRouteProvider extends AdminHtmlRouteProvider {

  /**
   * {@inheritdoc}
   */
  protected function getAddFormRoute(EntityTypeInterface $entity_type) {
    $route = parent::getAddFormRoute($entity_type);
    if ($route) {
      $route->setOption(
        'parameters',
        [
          'commerce_order' => [
            'type' => 'entity:commerce_order',
          ],
          'commerce_ticket_type' => [
            'type' => 'entity:commerce_ticket_type',
          ],
        ]
      );
    }
    return $route;
  }

  /**
   * {@inheritdoc}
   */
  protected function getAddPageRoute(EntityTypeInterface $entity_type) {
    $route = parent::getAddPageRoute($entity_type);
    if ($route) {
      $route->setDefault('_controller', TicketController::class . '::addTicketPage');
      $route->setOption(
        'parameters',
        [
          'commerce_order' => [
            'type' => 'entity:commerce_order',
          ],
        ]
      );
    }
    return $route;
  }

  /**
   * {@inheritdoc}
   */
  protected function getCanonicalRoute(EntityTypeInterface $entity_type) {
    $route = parent::getCanonicalRoute($entity_type);
    if ($route) {
      $route->setRequirement('commerce_ticket', Uuid::VALID_PATTERN);
      $route->setOption(
        'parameters',
        [
          'commerce_ticket' => [
            'type' => 'entity:commerce_ticket',
            'converter' => 'commerce_ticketing.uuid_param_converter',
          ],
        ]
      );
    }
    return $route;
  }

  /**
   * {@inheritdoc}
   */
  protected function getCollectionRoute(EntityTypeInterface $entity_type) {
    $route = parent::getCollectionRoute($entity_type);
    if ($route) {
      $route->setOption(
        'parameters',
        [
          'commerce_order' => [
            'type' => 'entity:commerce_order',
          ],
        ]
      );
    }
    return $route;
  }

  /**
   * {@inheritdoc}
   */
  public function getRoutes(EntityTypeInterface $entity_type) {
    $collection = parent::getRoutes($entity_type);

    if ($resend_ticket_form_route = $this->getResendTicketFormRoute($entity_type)) {
      $collection->add('entity.commerce_ticket.resend_ticket_form', $resend_ticket_form_route);
    }

    if ($admin_collection_route = $this->getAdminCollectionRoute($entity_type)) {
      $collection->add('entity.commerce_ticket.admin-collection', $admin_collection_route);
    }

    return $collection;
  }

  /**
   * Gets the admin-collection route.
   *
   * @param \Drupal\Core\Entity\EntityTypeInterface $entity_type
   *   The entity type.
   *
   * @return \Symfony\Component\Routing\Route|null
   *   The generated route, if available.
   */
  protected function getAdminCollectionRoute(EntityTypeInterface $entity_type) {
    $route = new Route($entity_type->getLinkTemplate('admin-collection'));
    $route
      ->addDefaults([
        '_entity_list' => 'commerce_ticket',
        '_title_callback' => TicketController::class . '::collectionTitle',
      ])
      ->setRequirement('_permission', 'administer commerce_ticketing')
      ->setOption('_admin_route', TRUE);
    return $route;
  }

  /**
   * Gets the resend-receipt-form route.
   *
   * @param \Drupal\Core\Entity\EntityTypeInterface $entity_type
   *   The entity type.
   *
   * @return \Symfony\Component\Routing\Route|null
   *   The generated route, if available.
   */
  protected function getResendTicketFormRoute(EntityTypeInterface $entity_type) {
    $route = new Route($entity_type->getLinkTemplate('resend-ticket-form'));
    $route
      ->addDefaults([
        '_entity_form' => 'commerce_ticket.resend-ticket',
        '_title_callback' => '\Drupal\Core\Entity\Controller\EntityController::title',
      ])
      ->setRequirement('_permission', 'administer commerce_ticketing')
      ->setRequirement('commerce_order', '\d+')
      ->setRequirement('commerce_ticket', '\d+')
      ->setOption('parameters', [
        'commerce_order' => [
          'type' => 'entity:commerce_order',
        ],
        'commerce_ticket' => [
          'type' => 'entity:commerce_ticket',
        ],
      ])
      ->setOption('_admin_route', TRUE);

    return $route;
  }

}
