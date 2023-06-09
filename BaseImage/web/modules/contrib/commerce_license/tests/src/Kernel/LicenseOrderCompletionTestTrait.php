<?php

namespace Drupal\Tests\commerce_license\Kernel;

use Drupal\commerce_order\Entity\OrderInterface;

/**
 * Provides a helper method to take a license order to completion.
 */
trait LicenseOrderCompletionTestTrait {

  /**
   * Takes a cart order through to the end of checkout.
   *
   * This uses the states appropriate to the order's workflow to ensure that
   * the license will be created.
   *
   * @param \Drupal\commerce_order\Entity\OrderInterface $cart_order
   *   The order.
   *
   * @throws \Drupal\Core\Entity\EntityStorageException
   */
  protected function completeLicenseOrderCheckout(OrderInterface $cart_order): void {
    $workflow = $cart_order->getState()->getWorkflow();

    // In all cases, place the order.
    $cart_order->getState()->applyTransition($workflow->getTransition('place'));
    $cart_order->save();

    // The order is now either in state:
    // - 'complete', if its workflow is 'order_default'
    // - 'fulfillment', if its workflow is 'order_fulfillment'
    // Fulfill the order if it has that transition.
    $fulfil_transition = $workflow->getTransition('fulfill');
    if ($fulfil_transition) {
      $cart_order->getState()->applyTransition($fulfil_transition);
      $cart_order->save();
    }
  }

}
