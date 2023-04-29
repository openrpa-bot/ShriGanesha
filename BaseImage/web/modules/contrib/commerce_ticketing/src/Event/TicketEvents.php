<?php

namespace Drupal\commerce_ticketing\Event;

final class TicketEvents {

  /**
   * Name of the event fired after loading a ticket.
   *
   * @Event
   *
   * @see \Drupal\commerce_ticketing\Event\TicketEvent
   */
  const TICKET_LOAD = 'commerce_ticketing.commerce_ticket.load';

  /**
   * Name of the event fired after creating a new ticket.
   *
   * Fired before the order is saved.
   *
   * @Event
   *
   * @see \Drupal\commerce_ticketing\Event\TicketEvent
   */
  const TICKET_CREATE = 'commerce_ticketing.commerce_ticket.create';

  /**
   * Name of the event fired before saving a ticket.
   *
   * @Event
   *
   * @see \Drupal\commerce_ticketing\Event\TicketEvent
   */
  const TICKET_PRESAVE = 'commerce_ticketing.commerce_ticket.presave';

  /**
   * Name of the event fired after saving a new ticket.
   *
   * @Event
   *
   * @see \Drupal\commerce_ticketing\Event\TicketEvent
   */
  const TICKET_INSERT = 'commerce_ticketing.commerce_ticket.insert';

  /**
   * Name of the event fired after saving an existing ticket.
   *
   * @Event
   *
   * @see \Drupal\commerce_ticketing\Event\TicketEvent
   */
  const TICKET_UPDATE = 'commerce_ticketing.commerce_ticket.update';

  /**
   * Name of the event fired before deleting a ticket.
   *
   * @Event
   *
   * @see \Drupal\commerce_ticketing\Event\TicketEvent
   */
  const TICKET_PREDELETE = 'commerce_ticketing.commerce_ticket.predelete';

  /**
   * Name of the event fired after deleting a ticket.
   *
   * @Event
   *
   * @see \Drupal\commerce_ticketing\Event\TicketEvent
   */
  const TICKET_DELETE = 'commerce_ticketing.commerce_ticket.delete';

}
