<?php

namespace Drupal\Tests\direct_checkout_by_url\Functional;

use Drupal\commerce_order\Entity\Order;
use Drupal\Tests\commerce\Functional\CommerceBrowserTestBase;

/**
 * Test description.
 *
 * @group direct_checkout_by_url
 */
class RedirectTest extends CommerceBrowserTestBase {

  /**
   * {@inheritdoc}
   */
  public static $modules = ['direct_checkout_by_url'];

  /**
   * {@inheritdoc}
   */
  protected $defaultTheme = 'stark';

  /**
   * Variation.
   *
   * @var \Drupal\commerce_product\Entity\ProductVariationInterface
   */
  protected $variation;

  /**
   * Product.
   *
   * @var \Drupal\Core\Entity\EntityInterface
   */
  protected $product;

  /**
   * {@inheritdoc}
   */
  protected function setUp() {
    parent::setUp();
    $this->variation = $this->createEntity('commerce_product_variation', [
      'type' => 'default',
      'sku' => strtolower($this->randomMachineName()),
      'price' => [
        'number' => 9.99,
        'currency_code' => 'USD',
      ],
    ]);

    /** @var \Drupal\commerce_product\Entity\ProductInterface $product */
    $this->product = $this->createEntity('commerce_product', [
      'type' => 'default',
      'title' => 'My product',
      'variations' => [$this->variation],
      'stores' => [$this->store],
    ]);
  }

  /**
   * {@inheritdoc}
   */
  protected function getAdministratorPermissions() {
    return array_merge([
      'use direct checkout',
    ], parent::getAdministratorPermissions());
  }

  /**
   * Test callback.
   */
  public function testSimpleUrl() {
    $this->drupalGet('/direct-checkout-by-url', [
      'query' => [
        'products' => $this->variation->getSku(),
      ],
    ]);
    $this->assertSession()->addressMatches('/\/checkout\/\d+\/order_information$/');

    $this->assertOrderTotalEquals('9.99');
  }

  /**
   * Test callback.
   */
  public function testArrayUrl() {
    $this->drupalGet('/direct-checkout-by-url', [
      'query' => [
        'products' => [
          [
            'quantity' => 2,
            'sku' => $this->variation->getSku(),
          ],
        ],
      ],
    ]);
    $this->assertSession()->addressMatches('/\/checkout\/\d+\/order_information$/');
    $this->assertOrderTotalEquals('19.98');
  }

  /**
   * Test callback.
   */
  public function testDestinationUrl() {
    $this->drupalGet('/direct-checkout-by-url', [
      'query' => [
        'products' => [
          [
            'quantity' => 2,
            'sku' => $this->variation->getSku(),
          ],
        ],
        'destination' => 'cart',
      ],
    ]);
    $this->assertSession()->addressMatches('/\/cart$/');
    $this->assertOrderTotalEquals('19.98');
  }

  /**
   * Helper.
   */
  protected function assertOrderTotalEquals($total) {
    /** @var \Drupal\commerce_order\Entity\Order $order */
    $order = Order::load(1);
    $this->assertEqual($order->getTotalPrice()->getNumber(), $total);
  }

}
