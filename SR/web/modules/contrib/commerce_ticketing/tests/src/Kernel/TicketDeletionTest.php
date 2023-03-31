<?php

namespace Drupal\Tests\commerce_ticketing\Kernel;

use Drupal\commerce_ticketing\Entity\CommerceTicket;

/**
 * Tests the ticket delete.
 *
 * @group commerce_ticketing
 */
class TicketDeletionTest extends TicketKernelTestBase {

  /**
   * Tests ticket delete when order is completed.
   */
  public function testTicketDeleteOrderCompleted() {
    $this->assertCount(0, $this->tickets);
    $this->addPayment();
    $this->assertEquals('completed', $this->order->getState()->getId());
    $tickets = CommerceTicket::loadMultiple();
    $this->assertCount(1, $tickets);
    $ticket = reset($tickets);
    $ticket->delete();
    \Drupal::entityTypeManager()->getStorage('commerce_ticket')->resetCache();
    $tickets = CommerceTicket::loadMultiple();
    $this->assertCount(0, $tickets);
  }

}
