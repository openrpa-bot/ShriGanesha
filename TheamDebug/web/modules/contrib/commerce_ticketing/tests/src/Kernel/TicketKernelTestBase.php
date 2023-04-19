<?php

namespace Drupal\Tests\commerce_ticketing\Kernel;

use Drupal\commerce_order\Entity\Order;
use Drupal\commerce_order\Entity\OrderInterface;
use Drupal\commerce_order\Entity\OrderType;
use Drupal\commerce_payment\Entity\Payment;
use Drupal\commerce_payment\Entity\PaymentGateway;
use Drupal\commerce_product\Entity\Product;
use Drupal\commerce_product\Entity\ProductVariation;
use Drupal\commerce_ticketing\CommerceTicketCreateTickets;
use Drupal\Core\Session\AccountInterface;
use Drupal\Tests\commerce_cart\Kernel\CartKernelTestBase;

/**
 * Defines base class for commerce_ticketing kernel test cases.
 */
abstract class TicketKernelTestBase extends CartKernelTestBase {

  use CommerceTicketCreateTickets;

  /**
   * Modules to enable.
   *
   * @var array
   */
  protected static $modules = [
    'commerce_payment',
    'commerce_payment_example',
    'commerce_ticketing',
    'commerce_ticketing_test',
    'entity_print',
    'entity_print_test',
    'image',
    'file',
    'system',
  ];

  /**
   * Commerce tickets entities.
   *
   * @var \Drupal\commerce_ticketing\Entity\CommerceTicket[]
   */
  protected $tickets = [];

  /**
   * The order.
   *
   * @var \Drupal\commerce_order\Entity\OrderInterface
   */
  protected $order;

  /**
   * The order item storage.
   *
   * @var \Drupal\commerce_order\OrderItemStorageInterface
   */
  protected $orderItemStorage;

  /**
   * The variation to test against.
   *
   * @var \Drupal\commerce_product\Entity\ProductVariation
   */
  protected $variation;

  /**
   * Onsite payment gateway.
   *
   * @var \Drupal\commerce_payment\Entity\PaymentGatewayInterface
   */
  protected $paymentGateway;

  /**
   * {@inheritdoc}
   */
  protected function setUp(): void {
    parent::setUp();

    $this->installEntitySchema('file');
    $this->installEntitySchema('commerce_payment');
    $this->installEntitySchema('commerce_ticket');
    $this->installConfig([
      'commerce_ticketing',
      'commerce_ticketing_test',
      'commerce_payment',
      'commerce_product',
      'system',
      'user',
      'entity_print',
      'entity_print_test',
    ]);

    $this->container->get('theme_installer')->install(['stark']);

    // Enables the default commerce order for tickets.
    $order_type = OrderType::load('default');
    $order_type->setThirdPartySetting('commerce_ticketing', 'enable_ticketing', TRUE);
    $order_type->setThirdPartySetting('commerce_ticketing', 'ticket_type', 'default');
    $order_type->setThirdPartySetting('commerce_ticketing', 'send_ticket_mail', TRUE);
    $order_type->save();

    // Adds the ticket's field to the commerce order default type.
    $field_definition = commerce_ticketing_build_ticketing_field_definition('default');
    $this->container->get('commerce.configurable_field_manager')->createField($field_definition);

    $customer = $this->createUser([], ['view own commerce_ticket', 'view own commerce_order', 'view commerce_product']);
    $this->orderItemStorage = $this->container->get('entity_type.manager')->getStorage('commerce_order_item');

    // Set a gateway for doing payments later.
    $this->paymentGateway = PaymentGateway::create([
      'id' => 'offsite',
      'label' => 'Off-site',
      'plugin' => 'example_offsite_redirect',
      'configuration' => [
        'redirect_method' => 'post',
        'payment_method_types' => ['credit_card'],
      ],
    ]);
    $this->paymentGateway->save();

    $this->variation = $this->createProductVariation();
    $this->variation->save();
    // Product is needed to control the permissions on the variations.
    // @see \Drupal\commerce_product\ProductVariationAccessControlHandler::checkAccess()
    $this->product = $this->createProduct();
    $this->product->save();
    $this->variation = $this->reloadEntity($this->variation);
    $this->order = $this->createOrder([], $customer);

    // Add the item to the cart.
    $order_item = $this->orderItemStorage->createFromPurchasableEntity($this->variation);
    $order_item->save();
    $this->order->addItem($order_item);

    // Save and reload to have a fresh order.
    $this->order->save();
    $this->order = $this->reloadEntity($this->order);

    assert($this->order instanceof OrderInterface);
    $this->assertCount(1, $this->order->getItems());

    // Set the default print engine.
    $config = $this->container->get('config.factory')->getEditable('entity_print.settings');
    $config
      ->set('print_engines.pdf_engine', 'testprintengine')
      ->save();
  }

  /**
   * Adds payment for an order.
   *
   * @param \Drupal\commerce_order\Entity\OrderInterface|null $order
   *   The order to add payment for, empty to use the default.
   *
   * @throws \Drupal\Core\Entity\EntityStorageException
   */
  protected function addPayment(OrderInterface $order = NULL) {
    if (empty($order)) {
      $payment = Payment::create([
        'type' => 'payment_default',
        'payment_gateway' => $this->paymentGateway->id(),
        'order_id' => $this->order->id(),
        'amount' => $this->order->getTotalPrice(),
        'state' => 'completed',
      ]);
      $payment->save();
      $this->order->save();
    }
    else {
      $payment = Payment::create([
        'type' => 'payment_default',
        'payment_gateway' => $this->paymentGateway->id(),
        'order_id' => $order->id(),
        'amount' => $order->getTotalPrice(),
        'state' => 'completed',
      ]);
      $payment->save();
      $order->save();
    }
  }

  /**
   * Creates a test order.
   *
   * @param array $values
   *   Array of default values.
   * @param \Drupal\Core\Session\AccountInterface|null $customer
   *   Customer to assign the order.
   * @param string $email
   *   E-mail to use instead of customer's.
   *
   * @return \Drupal\commerce_order\Entity\OrderInterface
   */
  protected function createOrder(array $values = [], AccountInterface $customer = NULL, string $email = '') {
    return Order::create($values + [
      'type' => 'default',
      'state' => 'draft',
      'mail' => $email ?? (!empty($customer) ? $customer->getEmail() : $this->randomString() . '@example.com'),
      'uid' => !empty($customer) ? $customer->id() : 0,
      'ip_address' => '127.0.0.1',
      'store_id' => $this->store->id(),
      'payment_gateway' => $this->paymentGateway->id(),
    ]);
  }

  /**
   * Creates a test product variation.
   *
   * @param array $values
   *   Array of default values.
   *
   * @return \Drupal\commerce_product\Entity\ProductVariationInterface
   */
  protected function createProductVariation(array $values = []) {
    return ProductVariation::create($values + [
      'type' => 'ticket',
      'sku' => strtolower($this->randomMachineName()),
      'title' => $this->randomString(),
      'price' => [
        'number' => '10.00',
        'currency_code' => 'USD',
      ],
      'status' => 1,
    ]);
  }

  /**
   * Creates a test product.
   *
   * @param array $values
   *   Array of default values.
   *
   * @return \Drupal\commerce_product\Entity\ProductInterface
   */
  protected function createProduct(array $values = []) {
    return Product::create($values + [
      'type' => 'ticket',
      'title' => $this->randomMachineName(),
      'stores' => [$this->store],
      'variations' => [$this->variation],
    ]);
  }

}
