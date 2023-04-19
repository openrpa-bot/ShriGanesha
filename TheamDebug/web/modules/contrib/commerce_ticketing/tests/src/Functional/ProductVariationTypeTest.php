<?php

namespace Drupal\Tests\commerce_ticketing\Functional;

use Drupal\commerce_product\Entity\ProductVariationType;
use Drupal\Tests\commerce_product\Functional\ProductBrowserTestBase;

/**
 * Tests the product variation form.
 *
 * @group commerce_ticketing
 */
class ProductVariationTypeTest extends ProductBrowserTestBase {

  /**
   * {@inheritdoc}
   */
  protected static $modules = ['commerce_ticketing'];

  /**
   * Test product variation add.
   */
  public function testProductVariationAdd() {
    $this->drupalGet('admin/commerce/config/product-variation-types/add');
    $this->assertSession()->pageTextContains('Is a ticket');

    $edit = [
      'id' => strtolower($this->randomMachineName(8)),
      'label' => 'Pants',
      'orderItemType' => 'default',
      'traits[purchasable_entity_ticket]' => FALSE,
    ];
    $this->submitForm($edit,'Save');
    $this->assertSession()->pageTextContains('Saved the Pants product variation type.');
    $variation_type = ProductVariationType::load($edit['id']);
    $this->assertNotEmpty($variation_type);
    $this->assertEquals('Pants', $variation_type->label());
    $this->assertEquals('default', $variation_type->getOrderItemTypeId());
    $this->assertEquals([], $variation_type->getTraits());

    $this->drupalGet('admin/commerce/config/product-variation-types/add');
    $edit = [
      'id' => strtolower($this->randomMachineName(8)),
      'label' => 'The Cat Concerto',
      'orderItemType' => 'default',
      'traits[purchasable_entity_ticket]' => TRUE,
    ];
    $this->submitForm($edit,'Save');
    $this->assertSession()->pageTextContains('Saved the The Cat Concerto product variation type.');
    $variation_type = ProductVariationType::load($edit['id']);
    $this->assertNotEmpty($variation_type);
    $this->assertEquals('The Cat Concerto', $variation_type->label());
    $this->assertEquals('default', $variation_type->getOrderItemTypeId());
    $this->assertEquals([0 => 'purchasable_entity_ticket'], $variation_type->getTraits());
  }

  /**
   * Test product variation edit.
   */
  public function testProductVariationEdit() {
    $this->drupalGet('admin/commerce/config/product-variation-types/ticket/edit');
    $this->assertSession()->pageTextContains('Is a ticket');
  }

}
