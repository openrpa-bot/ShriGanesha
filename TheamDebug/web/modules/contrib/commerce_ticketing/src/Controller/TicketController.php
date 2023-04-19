<?php

namespace Drupal\commerce_ticketing\Controller;

use Drupal\commerce_order\Entity\OrderInterface;
use Drupal\commerce_ticketing\CommerceTicketInterface;
use Drupal\Core\Entity\Controller\EntityController;

/**
 * Provides ticket related controller actions.
 */
class TicketController extends EntityController {

  /**
   * Redirects to the ticket add form.
   *
   * @param \Drupal\commerce_order\Entity\OrderInterface $commerce_order
   *   The commerce order to add a ticket to.
   *
   * @return \Symfony\Component\HttpFoundation\RedirectResponse
   *   A redirect response to the ticket add page.
   *
   * @throws \Drupal\Component\Plugin\Exception\InvalidPluginDefinitionException
   * @throws \Drupal\Component\Plugin\Exception\PluginNotFoundException
   */
  public function addTicketPage(OrderInterface $commerce_order) {
    $order_type = $this->entityTypeManager->getStorage('commerce_order_type')->load($commerce_order->bundle());
    // Find the ticket type associated to this order type.
    $ticket_type = $order_type->getThirdPartySetting('commerce_ticketing', 'ticket_type', 'default');

    return $this->redirect('entity.commerce_ticket.add_form', [
      'commerce_order' => $commerce_order->id(),
      'commerce_ticket_type' => $ticket_type,
    ]);
  }

  /**
   * Redirects to the tickets' collection.
   *
   * @param \Drupal\commerce_ticketing\CommerceTicketInterface $commerce_ticket
   *   The commerce ticket entity.
   *
   * @return \Symfony\Component\HttpFoundation\RedirectResponse
   *   A redirect response to the ticket collection page.
   */
  public function collectionRedirect(CommerceTicketInterface $commerce_ticket) {
    return $this->redirect('entity.commerce_ticket.collection', [
      'commerce_order' => $commerce_ticket->getOrderId(),
    ]);
  }

  /**
   * Provides the collection title callback for tickets.
   *
   * @return string
   *   The title for the ticket collection.
   */
  public function collectionTitle() {
    return $this->t('Tickets');
  }

}
