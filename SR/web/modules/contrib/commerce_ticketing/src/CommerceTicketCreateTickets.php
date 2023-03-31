<?php

namespace Drupal\commerce_ticketing;

use Drupal\commerce_order\Entity\OrderInterface;
use Drupal\commerce_order\Entity\OrderType;
use Drupal\commerce_product\Entity\ProductVariationType;
use Drupal\commerce_ticketing\Entity\CommerceTicket;
use Drupal\Core\StringTranslation\StringTranslationTrait;

trait CommerceTicketCreateTickets {

  use StringTranslationTrait;

  /**
   * Create tickets for all relevant line items.
   *
   * @param \Drupal\commerce_order\Entity\OrderInterface $order
   *
   * @throws \Drupal\Component\Plugin\Exception\InvalidPluginDefinitionException
   * @throws \Drupal\Component\Plugin\Exception\PluginNotFoundException
   * @throws \Drupal\Core\Entity\EntityStorageException
   */
  protected function createTickets(OrderInterface $order) {
    $line_items = $order->getItems();
    $existing_tickets = $order->get('tickets')->referencedEntities();
    $sorted_tickets = [];

    /** @var CommerceTicket $existing_ticket */
    foreach ($existing_tickets as $existing_ticket) {
      if (!empty($item_id = $existing_ticket->getOrderItemId())) {
        $sorted_tickets[] = $item_id;
      }
    }
    $sorted_tickets = array_count_values($sorted_tickets);

    foreach ($line_items as $line_item) {
      $purchased_entity = $line_item->getPurchasedEntity();
      if (!empty($purchased_entity)) {
        /** @var ProductVariationType $variation_type */
        $variation_type = ProductVariationType::load($purchased_entity->bundle());
        /** @var OrderType $order_type */
        $order_type = OrderType::load($order->bundle());
        $ticket_type = $order_type->getThirdPartySetting('commerce_ticketing', 'ticket_type');
        $order_state = $variation_type->getThirdPartySetting('commerce_ticketing', 'order_state');
        $auto_create_ticket = $variation_type->getThirdPartySetting('commerce_ticketing', 'auto_create_ticket');
        $auto_activate_ticket = $variation_type->getThirdPartySetting('commerce_ticketing', 'auto_activate_ticket');

        $default_state = 'created';
        if ($auto_activate_ticket && $order->getState()->getId() == $order_state) {
          $default_state = 'active';
        }

        if (!empty($ticket_type) && $auto_create_ticket) {
          // Create multiple tickets per line item.
          $quantity = $line_item->getQuantity();
          $current_quantity = !empty($sorted_tickets[$line_item->id()]) ? $sorted_tickets[$line_item->id()] : 0;

          if (empty($sorted_tickets[$line_item->id()]) || $current_quantity < $quantity) {

            for ($i = $current_quantity; $i < $quantity; $i++) {
              $ticket = CommerceTicket::create(
                [
                  'name' => substr($this->t('Ticket') . ' ' . $purchased_entity->label(), 0, 50),
                  'bundle' => $ticket_type,
                  'state' => $default_state,
                  'uid' => $order->get('uid'),
                  'order_id' => $order->id(),
                  'order_item_id' => $line_item->id(),
                ]
              );
              $ticket->save();
            }
          }
        }
      }
    }

    // Update backreference on order.
    $storage = \Drupal::entityTypeManager()->getStorage('commerce_ticket');
    $ticket_ids = $storage->getQuery()
      ->condition('order_id', $order->id())
      ->sort('id')
      ->execute();

    $order->set('tickets', $ticket_ids);
  }

}
