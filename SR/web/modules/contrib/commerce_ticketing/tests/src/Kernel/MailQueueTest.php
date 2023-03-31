<?php

namespace Drupal\Tests\commerce_ticketing\Kernel;

use Drupal\commerce_order\Entity\Order;
use Drupal\commerce_order\Entity\OrderInterface;
use Drupal\commerce_payment\Entity\Payment;

/**
 * Tests the ticket emails.
 *
 * @group commerce_ticketing
 */
class MailQueueTest extends TicketKernelTestBase {

  /**
   * Tests queue generation for orders with email.
   */
  public function testOrderWithEmail() {
    $queue_name = 'commerce_ticketing_send_ticket_receipt_worker';
    $this->assertEquals(0, \Drupal::queue('commerce_ticketing_send_ticket_receipt_worker')->numberOfItems());
    $payment = Payment::create([
      'type' => 'payment_default',
      'payment_gateway' => $this->paymentGateway->id(),
      'order_id' => $this->order->id(),
      'amount' => $this->order->getTotalPrice(),
      'state' => 'completed',
    ]);
    $payment->save();
    $this->order->save();

    // Run the queue.
    $queue_worker = \Drupal::service('plugin.manager.queue_worker')->createInstance($queue_name);
    /** @var \Drupal\Core\Queue\QueueInterface $queue */
    $queue = \Drupal::service('queue')->get($queue_name);
    $this->assertEquals(1, $queue->numberOfItems());

    $item = $queue->claimItem();
    $queue_worker->processItem($item->data);
    $queue->deleteItem($item);

    $this->assertEquals(0, $queue->numberOfItems());
  }

  /**
   * Tests orders with no mail.
   */
  public function testNoMailWithOrderSendTicketsOff() {
    // Adds the ticket's field to the commerce order default type.
    $field_definition = commerce_ticketing_build_ticketing_field_definition('default_without_email');
    $this->container->get('commerce.configurable_field_manager')->createField($field_definition);

    $this->assertEquals(0, \Drupal::queue('commerce_ticketing_send_ticket_receipt_worker')->numberOfItems());

    $customer = $this->createUser([], ['view own commerce_ticket', 'view own commerce_order', 'view commerce_product']);
    $order = $this->createOrder(['type' => 'default_without_email'], $customer);

    // Add the item to the cart.
    $order_item = $this->orderItemStorage->createFromPurchasableEntity($this->variation);
    $order_item->save();
    $order->addItem($order_item);

    // Save and reload to have a fresh order.
    $order->save();
    $order = $this->reloadEntity($order);

    assert($order instanceof OrderInterface);
    $this->assertCount(1, $order->getItems());

    $this->addPayment($order);
    $this->assertEquals(0, \Drupal::queue('commerce_ticketing_send_ticket_receipt_worker')->numberOfItems());
  }

}
