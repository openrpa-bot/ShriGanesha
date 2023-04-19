<?php

namespace Drupal\Tests\commerce_ticketing\Functional;

use Drupal\commerce_ticketing\Entity\CommerceTicket;

/**
 * Tests commerce order relationship with tickets.
 *
 * @group commerce_ticketing
 */
class TicketOrderTest extends TicketBrowserTestBase {

  /**
   * {@inheritdoc}
   */
  protected static $modules = [
    'commerce_checkout',
    'commerce_cart',
    'commerce_order',
  ];

  /**
   * The order.
   *
   * @var \Drupal\commerce_order\Entity\OrderInterface
   */
  protected $order;

  /**
   * {@inheritdoc}
   */
  protected function setUp(): void {
    parent::setUp();
    $customer = $this->drupalCreateUser(['view own commerce_ticket']);
    $this->drupalLogin($customer);

    /** @var \Drupal\commerce_order\Entity\OrderItemInterface $order_item */
    $order_item = $this->createEntity('commerce_order_item', [
      'title' => $this->randomMachineName(),
      'type' => 'default',
      'quantity' => 1,
      'unit_price' => $this->variation->getPrice(),
      'purchased_entity' => $this->variation,
    ]);
    $order_item->save();
    /** @var \Drupal\commerce_order\Entity\OrderInterface $order */
    $this->order = $this->createEntity('commerce_order', [
      'type' => 'default',
      'mail' => $customer->getEmail(),
      'order_items' => [$order_item],
      'uid' => $customer,
      'store_id' => $this->store,
      'state' => 'completed',
    ]);
    $this->order->save();

    $this->createTickets($this->order);
    $this->order->save();
  }

  /**
   * Tests removing tickets from an order.
   */
  public function testRemoveTickets() {
    $this->drupalLogin($this->adminUser);
    $this->drupalGet($this->order->toUrl());
    $edit_link = $this->getSession()->getPage()->findLink('Tickets');
    $edit_link->click();
    $delete_link = $this->getSession()->getPage()->findLink('Delete');
    $delete_link->click();
    $this->submitForm([], 'Delete');

    $this->assertSession()->pageTextContains('The commerce ticket Ticket has been deleted.');
    $tickets = CommerceTicket::loadMultiple();
    $this->assertEquals(0, count($tickets));
    $this->drupalGet($this->order->toUrl());
    $edit_link = $this->getSession()->getPage()->findLink('Tickets');
    $edit_link->click();
    $this->assertSession()->pageTextContains('There are no commerce ticket entities yet.');
  }

}
