<?php

namespace Drupal\commerce_ticketing\EventSubscriber;

use Drupal\commerce_ticketing\Event\TicketEvent;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Ticket events.
 */
class TicketSubscriber implements EventSubscriberInterface {

  /**
   * The entity type manager.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * Constructs a new TicketSubscriber object.
   *
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entity_type_manager
   *   The entity type manager.
   */
  public function __construct(EntityTypeManagerInterface $entity_type_manager) {
    $this->entityTypeManager = $entity_type_manager;
  }

  /**
   * {@inheritdoc}
   */
  public static function getSubscribedEvents() {
    return [
      'commerce_ticketing.commerce_ticket.presave' => ['setTicketNumber', -30],
      'commerce_ticketing.commerce_ticket.delete' => ['removeFromOrder', -30],
    ];
  }

  /**
   * Sets the ticket number.
   *
   * The number is generated using the number pattern specified by the
   * ticket type. If no number pattern was specified, the ticket ID is
   * used as a fallback.
   *
   * Skipped if the ticket number has already been set.
   *
   * @param \Drupal\commerce_ticketing\Event\TicketEvent $event
   *   The event.
   *
   * @throws \Drupal\Component\Plugin\Exception\InvalidPluginDefinitionException
   * @throws \Drupal\Component\Plugin\Exception\PluginNotFoundException
   */
  public function setTicketNumber(TicketEvent $event) {
    $ticket = $event->getTicket();
    if (!$ticket->getTicketNumber()) {
      $ticket_type_storage = $this->entityTypeManager->getStorage('commerce_ticket_type');
      /** @var \Drupal\commerce_ticketing\Entity\CommerceTicketType $ticket_type */
      $ticket_type = $ticket_type_storage->load($ticket->bundle());
      /** @var \Drupal\commerce_number_pattern\Entity\NumberPatternInterface $number_pattern */
      $number_pattern = $ticket_type->getNumberPattern();
      $ticket_number = $number_pattern ? $number_pattern->getPlugin()->generate($ticket): $ticket->id();
      $ticket->setTicketNumber($ticket_number);
    }
  }

  /**
   * Removes the back reference on the order.
   *
   * @param \Drupal\commerce_ticketing\Event\TicketEvent $event
   *   The event.
   *
   * @throws \Drupal\Core\Entity\EntityStorageException
   */
  public function removeFromOrder(TicketEvent $event) {
    $ticket = $event->getTicket();
    $order = $ticket->getOrder();
    if ($order) {
      $existing_tickets = $order->get('tickets')->getValue();
      foreach ($existing_tickets as $key => $existing_ticket) {
        if ($existing_ticket['target_id'] == $ticket->id()) {
          unset($order->get('tickets')->getValue()[$key]);
        }
      }

      $order->save();
    }
  }

}
