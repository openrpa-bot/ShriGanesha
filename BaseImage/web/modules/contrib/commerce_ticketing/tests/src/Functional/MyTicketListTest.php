<?php

namespace Drupal\Tests\commerce_ticketing\Functional;

/**
 * Tests ticket access.
 *
 * @group commerce_ticketing
 */
class MyTicketListTest extends TicketBrowserTestBase {

  /**
   * {@inheritdoc}
   */
  protected static $modules = ['views'];

  /**
   * Optimistic path: User can see their own tickets.
   */
  public function testViewMyTickets() {
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
    $order = $this->createEntity('commerce_order', [
      'type' => 'default',
      'mail' => $customer->getEmail(),
      'order_items' => [$order_item],
      'uid' => $customer,
      'store_id' => $this->store,
      'state' => 'completed',
    ]);
    $order->save();

    $this->createTickets($order);

    $this->drupalGet('user/' . $customer->id() . '/tickets');
    $this->assertSession()->statusCodeEquals(200);
    $this->assertSession()->pageTextContains('TICKET-1');
  }

  /**
   * Pesimistic path: User can't see their own tickets.
   */
  public function testViewMyTicketsNoPermission() {
    $customer = $this->drupalCreateUser();

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
    $order = $this->createEntity('commerce_order', [
      'type' => 'default',
      'mail' => $customer->getEmail(),
      'order_items' => [$order_item],
      'uid' => $customer,
      'store_id' => $this->store,
      'state' => 'completed',
    ]);
    $order->save();

    $this->createTickets($order);

    $this->drupalGet('user/' . $customer->id() . '/tickets');
    $this->assertSession()->statusCodeEquals(403);
  }

}
