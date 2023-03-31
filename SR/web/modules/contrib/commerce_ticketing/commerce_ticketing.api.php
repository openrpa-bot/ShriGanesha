<?php

/**
 * @file
 * Hooks and documentation related to the Coupon Ticketing module.
 */

use Drupal\commerce_ticketing\CommerceTicketInterface;

/**
 * Alter the Qrcode value.
 *
 * @param string $default_data
 *   Defaults to the ticket uuid.
 * @param \Drupal\commerce_ticketing\CommerceTicketInterface $ticket
 *   The ticket entity.
 */
function hook_commerce_ticketing_qr_code_value_alter(&$default_data, CommerceTicketInterface $ticket) {
  if ($ticket->bundle() == 'concert') {
    $default_data = '/some-custom-route-to-do-stuff-with-ticket/' . $default_data;
  }
}
