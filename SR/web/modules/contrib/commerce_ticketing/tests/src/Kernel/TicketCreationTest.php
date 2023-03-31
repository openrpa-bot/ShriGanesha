<?php

namespace Drupal\Tests\commerce_ticketing\Kernel;

use Drupal\commerce_order\Entity\OrderInterface;
use Drupal\commerce_ticketing\Entity\CommerceTicket;
use Drupal\Core\Session\AccountInterface;
use Drupal\user\Entity\Role;

/**
 * Tests the ticket creation.
 *
 * @group commerce_ticketing
 */
class TicketCreationTest extends TicketKernelTestBase {

  /**
   * The order assignment service.
   *
   * @var \Drupal\commerce_order\OrderAssignmentInterface
   */
  protected $orderAssignment;

  /**
   * {@inheritdoc}
   */
  protected function setUp(): void {
    parent::setUp();

    $this->orderAssignment = $this->container->get('commerce_order.order_assignment');
  }

  /**
   * Tests ticket creation.
   */
  public function testTicketCreation() {
    $this->assertCount(0, $this->tickets);
    $this->addPayment();
    $tickets = CommerceTicket::loadMultiple();
    $this->assertCount(1, $tickets);
    $ticket = reset($tickets);
    $this->assertEquals($ticket->label(), 'Ticket ' . $this->variation->label());
  }

  /**
   * Tests ticket creation with a really long title.
   */
  public function testTicketCreationLongTitle() {
    $this->assertCount(0, $this->tickets);
    $customer = $this->createUser([], ['view own commerce_ticket', 'view own commerce_order', 'view commerce_product']);
    $order = $this->createOrder([], $customer);

    $variation = $this->createProductVariation();
    $variation->save();
    $product = $this->createProduct(['variations' => [$variation]]);
    $product->save();
    $variation = $this->reloadEntity($variation);

    // Add the item to the cart.
    $order_item = $this->orderItemStorage->createFromPurchasableEntity($variation);
    $order_item->save();
    $order->addItem($order_item);

    // Save and reload to have a fresh order.
    $order->save();
    $order = $this->reloadEntity($order);

    assert($order instanceof OrderInterface);
    $this->assertCount(1, $order->getItems());

    $this->addPayment($order);
    $tickets = CommerceTicket::loadMultiple();
    $this->assertCount(1, $tickets);
    $ticket = reset($tickets);
    $this->assertEquals($ticket->label(), substr($this->t('Ticket') . ' ' . $variation->label(), 0, 50));
  }

  /**
   * Tests ticket creation.
   */
  public function testTicketCreationAnonymous() {
    $this->assertCount(0, $this->tickets);
    $mail = 'valentina@example.com';
    Role::load(AccountInterface::ANONYMOUS_ROLE)
      ->grantPermission('view commerce_product')
      ->save();
    $order = $this->createOrder([], NULL, $mail);

    $variation = $this->createProductVariation();
    $variation->save();
    $product = $this->createProduct(['variations' => [$variation]]);
    $product->save();
    $variation = $this->reloadEntity($variation);

    // Add the item to the cart.
    $order_item = $this->orderItemStorage->createFromPurchasableEntity($variation);
    $order_item->save();
    $order->addItem($order_item);

    // Save and reload to have a fresh order.
    $order->save();
    $order = $this->reloadEntity($order);
    assert($order instanceof OrderInterface);

    $this->assertEquals($mail, $order->getEmail());
    $this->assertEquals(0, $order->getCustomerId());

    $this->addPayment($order);
    $this->assertCount(1, CommerceTicket::loadMultiple());

    $logged_in_user = $this->createUser(['mail' => $mail]);
    $this->orderAssignment->assignMultiple([$order], $logged_in_user);
    $this->assertEquals($logged_in_user->id(), $order->getCustomerId());

    /** @var \Drupal\commerce_ticketing\CommerceTicketInterface[] $tickets */
    $tickets = $order->get('tickets')->referencedEntities();
    foreach ($tickets as $ticket) {
      $this->assertEquals($logged_in_user->id(), $ticket->getOwnerId());
    }
  }

}
