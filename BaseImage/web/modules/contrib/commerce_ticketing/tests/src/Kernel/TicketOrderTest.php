<?php

namespace Drupal\Tests\commerce_ticketing\Kernel;

use Drupal\commerce_ticketing\Entity\CommerceTicket;

/**
 * Tests the ticket order relationship.
 *
 * @group commerce_ticketing
 */
class TicketOrderTest extends TicketKernelTestBase {

  /**
   * Tests order deletion.
   */
  public function testOrderDelete() {
    $this->addPayment();
    $tickets = CommerceTicket::loadMultiple();
    $this->assertCount(1, $tickets);
    $this->order->delete();
    \Drupal::entityTypeManager()->getStorage('commerce_ticket')->resetCache();
    $tickets = $this->order->get('tickets')->referencedEntities();
    $this->assertCount(0, $tickets);
  }

  /**
   * Test cancelling the order.
   */
  public function testOrderCancel() {
    $this->createTickets($this->order);
    $this->order->save();
    $this->order->state = 'canceled';
    $this->order->save();
    \Drupal::entityTypeManager()->getStorage('commerce_ticket')->resetCache();
    $tickets = $this->order->get('tickets')->referencedEntities();
    /** @var \Drupal\commerce_ticketing\CommerceTicketInterface $ticket */
    $ticket = reset($tickets);
    $this->assertEquals('canceled', $ticket->getState()->getId());
  }

}
