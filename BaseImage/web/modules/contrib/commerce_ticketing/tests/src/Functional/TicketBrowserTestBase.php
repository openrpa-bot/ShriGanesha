<?php

namespace Drupal\Tests\commerce_ticketing\Functional;

use Behat\Mink\Driver\BrowserKitDriver;
use Behat\Mink\Session;
use Drupal\commerce_order\Entity\OrderType;
use Drupal\commerce_ticketing\CommerceTicketCreateTickets;
use Drupal\Tests\commerce\Functional\CommerceBrowserTestBase;
use Drupal\Tests\DrupalTestBrowser;

/**
 * Defines base class for commerce_ticketing functional test cases.
 */
abstract class TicketBrowserTestBase extends CommerceBrowserTestBase {

  use CommerceTicketCreateTickets;

  /**
   * The variation to test against.
   *
   * @var \Drupal\commerce_product\Entity\ProductVariation
   */
  protected $variation;

  /**
   * An on-site payment gateway.
   *
   * @var \Drupal\commerce_payment\Entity\PaymentGatewayInterface
   */
  protected $paymentGateway;

  /**
   * Modules to enable.
   *
   * @var array
   */
  protected static $modules = [
    'commerce_checkout',
    'commerce_product',
    'commerce_order',
    'commerce_payment',
    'commerce_payment_example',
    'commerce_ticketing',
    'commerce_ticketing_test',
    'inline_entity_form',
  ];

  /**
   * {@inheritdoc}
   */
  protected function getAdministratorPermissions() {
    return array_merge([
      'administer commerce_order',
      'administer commerce_order_type',
      'administer commerce_ticketing',
      'administer commerce ticket types',
      'access commerce_order overview',
    ], parent::getAdministratorPermissions());
  }

  /**
   * {@inheritdoc}
   */
  protected function setUp(): void {
    parent::setUp();

    // Enables the default commerce order for tickets.
    $order_type = OrderType::load('default');
    $order_type->setThirdPartySetting('commerce_ticketing', 'enable_ticketing', TRUE);
    $order_type->setThirdPartySetting('commerce_ticketing', 'ticket_type', 'default');
    $order_type->setThirdPartySetting('commerce_ticketing', 'send_ticket_mail', TRUE);
    $order_type->save();

    // Adds the tickets field to the commerce order default type.
    $field_definition = commerce_ticketing_build_ticketing_field_definition('default');
    \Drupal::service('commerce.configurable_field_manager')->createField($field_definition);


    // Create a product variation.
    $this->variation = $this->createEntity('commerce_product_variation', [
      'type' => 'ticket',
      'sku' => $this->randomMachineName(),
      'price' => [
        'number' => 111,
        'currency_code' => 'USD',
      ],
    ]);

    // We need a product too otherwise tests complain about the missing
    // backreference.
    $this->createEntity('commerce_product', [
      'type' => 'ticket',
      'title' => $this->randomMachineName(),
      'stores' => [$this->store],
      'variations' => [$this->variation],
    ]);

    // Add a example payment gateway so the tickets are created on completion.
    $this->paymentGateway = $this->createEntity('commerce_payment_gateway', [
      'id' => 'example',
      'label' => 'Example',
      'plugin' => 'example_onsite',
    ]);
  }

  /**
   * Switches to a different session.
   *
   * @param string $name
   *   The name of the session to switch to.
   */
  protected function switchSession($name) {
    $create_session = !$this->mink->hasSession($name);
    if ($create_session) {
      $client = new DrupalTestBrowser();
      $this->mink->registerSession($name, new Session(new BrowserKitDriver($client)));
    }
    $this->mink->setDefaultSessionName($name);

    if ($create_session) {
      // Visit the front page to initialise the session.
      $this->initFrontPage();
    }
  }

}
