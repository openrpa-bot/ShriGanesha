<?php

namespace Drupal\commerce_license;

use Drupal\commerce_order\Entity\OrderItemInterface;
use Drupal\commerce_product\Entity\ProductVariationInterface;
use Drupal\Core\Entity\ContentEntityStorageInterface;

/**
 * Defines the storage handler class for License entities.
 *
 * This extends the base storage class, adding required special handling for
 * License entities.
 *
 * @ingroup commerce_license
 */
interface LicenseStorageInterface extends ContentEntityStorageInterface {

  /**
   * Get existing active license given a product variation and a user ID.
   *
   * @param \Drupal\commerce_product\Entity\ProductVariationInterface $variation
   *   The product variation.
   * @param int $uid
   *   The uid for whom the license will be retrieved.
   *
   * @return \Drupal\commerce_license\Entity\LicenseInterface|false
   *   An existing license entity. FALSE otherwise.
   */
  public function getExistingLicense(ProductVariationInterface $variation, int $uid);

  /**
   * Creates a new license from an order item.
   *
   * @param \Drupal\commerce_order\Entity\OrderItemInterface $order_item
   *   The order item. Values for the license will be taken from the order
   *   item's customer and the purchased entity's license_type and
   *   license_expiration fields.
   *
   * @return \Drupal\commerce_license\Entity\LicenseInterface
   *   A new, unsaved license entity, whose state is 'new'.
   */
  public function createFromOrderItem(OrderItemInterface $order_item);

  /**
   * Creates a new license from a product variation.
   *
   * @param \Drupal\commerce_product\Entity\ProductVariationInterface $variation
   *   The product variation. Values for the license will be taken from the
   *   license_type and license_expiration fields.
   * @param int $uid
   *   The uid for whom the license will be created.
   *
   * @return \Drupal\commerce_license\Entity\LicenseInterface
   *   A new, unsaved license entity, whose state is 'new'.
   */
  public function createFromProductVariation(ProductVariationInterface $variation, int $uid);

}
