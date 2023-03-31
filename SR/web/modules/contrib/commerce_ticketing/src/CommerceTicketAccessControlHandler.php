<?php

namespace Drupal\commerce_ticketing;

use Drupal\commerce_cart\CartSessionInterface;
use Drupal\Core\Access\AccessResult;
use Drupal\Core\Entity\EntityHandlerInterface;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\entity\UncacheableEntityAccessControlHandler;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Defines the access control handler for the commerce ticket entity type.
 */
class CommerceTicketAccessControlHandler extends UncacheableEntityAccessControlHandler implements EntityHandlerInterface {

  /**
   * The cart session.
   *
   * @var \Drupal\commerce_cart\CartSessionInterface
   */
  protected $cartSession;

  /**
   * {@inheritdoc}
   */
  public static function createInstance(ContainerInterface $container, EntityTypeInterface $entity_type) {
    $instance = new static($entity_type);
    $instance->cartSession = $container->get('commerce_cart.cart_session');
    return $instance;
  }

  /**
   * {@inheritdoc}
   */
  protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account) {
    /** @var \Drupal\commerce_ticketing\CommerceTicketInterface $ticket */
    $ticket = $entity;
    if (!$account->hasPermission('administer commerce_ticketing') && $ticket->getState()->getId() != 'active') {
      return AccessResult::forbidden();
    }


    // For anonymous users trying to check their ticket, we look at the cart
    // session to grant them access.
    if ($account->isAnonymous() && $operation == 'view') {
      $order = $ticket->getOrder();
      $active_cart = $this->cartSession->hasCartId($order->id(), CartSessionInterface::ACTIVE);
      $completed_cart = $this->cartSession->hasCartId($order->id(), CartSessionInterface::COMPLETED);
      $customer_check = $active_cart || $completed_cart;
      $access_result = AccessResult::allowedIf($customer_check && $account->hasPermission('view own commerce_ticket'));
      return $access_result
        ->addCacheableDependency($order)
        ->cachePerUser();
    }

    return parent::checkAccess($entity, $operation, $account);
  }

}
