<?php

namespace Drupal\Tests\commerce_ticketing\Functional;

use Drupal\commerce_order\Entity\Order;
use Drupal\user\RoleInterface;

/**
 * Tests ticket access.
 *
 * @group commerce_ticketing
 */
class TicketEntityAccessTest extends TicketBrowserTestBase {

  /**
   * {@inheritdoc}
   */
  protected static $modules = [
    'commerce_cart',
  ];

  /**
   * Guest details for anonymous checkout.
   *
   * @var string[]
   */
  protected array $guestDetails = [
    'contact_information[email]' => 'guest@example.com',
    'contact_information[email_confirm]' => 'guest@example.com',
  ];

  /**
   * Payment details.
   *
   * @var string[]
   */
  protected array $paymentDetails = [
    'payment_information[add_payment_method][payment_details][number]' => '4012888888881881',
    'payment_information[add_payment_method][payment_details][expiration][month]' => '02',
    'payment_information[add_payment_method][payment_details][expiration][year]' => '2024',
    'payment_information[add_payment_method][payment_details][security_code]' => '123',
  ];

  /**
   * Billing information.
   *
   * @var string[]
   */
  protected array $billingInfo = [
    'payment_information[add_payment_method][billing_information][address][0][address][given_name]' => 'Armando',
    'payment_information[add_payment_method][billing_information][address][0][address][family_name]' => 'Bronca Segura',
    'payment_information[add_payment_method][billing_information][address][0][address][address_line1]' => '123 New York Drive',
    'payment_information[add_payment_method][billing_information][address][0][address][locality]' => 'New York City',
    'payment_information[add_payment_method][billing_information][address][0][address][administrative_area]' => 'NY',
    'payment_information[add_payment_method][billing_information][address][0][address][postal_code]' => '10001',
  ];

  /**
   * Tests that anonymous users with view permission can view their own tickets.
   */
  public function testViewAccessAnonymousWithPermission() {
    // Ensure that access checks are respected even if anonymous users have
    // permission to view their own orders.
    user_role_grant_permissions(RoleInterface::ANONYMOUS_ID, ['view own commerce_ticket']);

    // Anonymous active cart.
    $this->switchSession('anonymous');
    $this->drupalGet('product/' . $this->variation->getProductId());
    $this->submitForm([], 'Add to cart');

    // Anonymous completed cart.
    $this->drupalGet('checkout/1/login');
    $this->submitForm([], 'Continue as Guest');
    $this->submitForm($this->guestDetails + $this->paymentDetails + $this->billingInfo, 'Continue to review');
    $this->submitForm([], 'Pay and complete purchase');
    $order = Order::load(1);
    $ticket = $order->get('tickets')->referencedEntities();
    $ticket = reset($ticket);

    $this->drupalGet('commerce_ticket/' . $ticket->uuid());
    $this->assertSession()->statusCodeEquals(200);
    $this->assertSession()->pageTextContains('TICKET-1');

    // Check that other anonymous users are not allowed to see tickets.
    $this->switchSession('anonymous2');
    $this->drupalGet('commerce_ticket/' . $ticket->uuid());
    $this->assertSession()->statusCodeEquals(403);
  }

  /**
   * Tests that users without the view permission cannot view their own tickets.
   */
  public function testViewAccessAnonymousWithoutPermission() {
    $this->drupalLogout();
    // Anonymous active cart.
    $this->drupalGet('product/' . $this->variation->getProductId());
    $this->submitForm([], 'Add to cart');

    // Anonymous completed cart.
    $this->drupalGet('checkout/1/login');
    $this->submitForm([], 'Continue as Guest');
    $this->submitForm($this->guestDetails + $this->paymentDetails + $this->billingInfo, 'Continue to review');
    $this->submitForm([], 'Pay and complete purchase');
    $order = Order::load(1);
    $ticket = $order->get('tickets')->referencedEntities();
    $ticket = reset($ticket);

    $this->drupalGet('commerce_ticket/' . $ticket->uuid());
    $this->assertSession()->statusCodeEquals(403);
  }

  /**
   * Tests that auth users with view permission can view their own tickets.
   */
  public function testViewAccessAuthenticatedwithPermission() {
    $customer = $this->drupalCreateUser(['access checkout', 'view own commerce_ticket']);
    $this->drupalLogin($customer);

    $this->drupalGet('product/' . $this->variation->getProductId());
    $this->submitForm([], 'Add to cart');

    $this->drupalGet('checkout/1/order_information');
    $this->submitForm($this->paymentDetails + $this->billingInfo, 'Continue to review');
    $this->submitForm([], 'Pay and complete purchase');
    $order = Order::load(1);
    $ticket = $order->get('tickets')->referencedEntities();
    $ticket = reset($ticket);

    $this->drupalGet('commerce_ticket/' . $ticket->uuid());
    $this->assertSession()->statusCodeEquals(200);
    $this->assertSession()->pageTextContains('TICKET-1');

    $this->switchSession('anonymous');
    $this->drupalGet('commerce_ticket/' . $ticket->uuid());
    $this->assertSession()->statusCodeEquals(403);
  }

  /**
   * Tests that auth users with view permission can view their own tickets.
   */
  public function testViewAccessAuthenticatedwithoutPermission() {
    $customer = $this->drupalCreateUser(['access checkout']);
    $this->drupalLogin($customer);

    $this->drupalGet('product/' . $this->variation->getProductId());
    $this->submitForm([], 'Add to cart');

    $this->drupalGet('checkout/1/order_information');
    $this->submitForm($this->paymentDetails + $this->billingInfo, 'Continue to review');
    $this->submitForm([], 'Pay and complete purchase');
    $order = Order::load(1);
    $ticket = $order->get('tickets')->referencedEntities();
    $ticket = reset($ticket);

    $this->drupalGet('commerce_ticket/' . $ticket->uuid());
    $this->assertSession()->statusCodeEquals(403);
  }

}
