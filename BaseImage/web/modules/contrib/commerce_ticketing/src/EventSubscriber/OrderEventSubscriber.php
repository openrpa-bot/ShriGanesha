<?php

namespace Drupal\commerce_ticketing\EventSubscriber;

use Drupal\commerce_order\Entity\OrderInterface;
use Drupal\commerce_order\Event\OrderAssignEvent;
use Drupal\commerce_order\Event\OrderEvent;
use Drupal\commerce_order\Event\OrderEvents;
use Drupal\commerce_product\Entity\ProductVariationType;
use Drupal\commerce_ticketing\CommerceTicketCreateTickets;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Lock\LockBackendInterface;
use Drupal\Core\Logger\LoggerChannelInterface;
use Drupal\Core\StringTranslation\StringTranslationTrait;
use Drupal\state_machine\Event\WorkflowTransitionEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Drupal\Core\Queue\QueueFactory;

/**
 * Subscriber to events related to the order.
 */
class OrderEventSubscriber implements EventSubscriberInterface {

  use StringTranslationTrait;
  use CommerceTicketCreateTickets;

  /**
   * The entity type manager.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * Lock service.
   *
   * @var \Drupal\Core\Lock\LockBackendInterface
   */
  protected $lock;

  /**
   * Logger.
   *
   * @var \Drupal\Core\Logger\LoggerChannelInterface
   */
  protected $logger;

  /**
   * The commerce_ticketing_send_ticket_receipt_worker queue.
   *
   * @var \Drupal\Core\Queue\QueueInterface
   */
  protected $queue;

  /**
   * Constructs a new OrderEventSubscriber object.
   *
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entity_type_manager
   *   The entity type manager.
   */
  public function __construct(EntityTypeManagerInterface $entity_type_manager, LockBackendInterface $lock, LoggerChannelInterface $logger, QueueFactory $queue_factory) {
    $this->entityTypeManager = $entity_type_manager;
    $this->lock = $lock;
    $this->logger = $logger;
    $this->queue = $queue_factory->get('commerce_ticketing_send_ticket_receipt_worker');
  }

  /**
   * {@inheritdoc}
   */
  public static function getSubscribedEvents() {
    return [
      'commerce_order.validate.post_transition' => ['onValidateTransition'],
      'commerce_order.fulfill.post_transition' => ['onFulfillTransition'],
      'commerce_order.cancel.post_transition' => ['onCancelTransition'],
      OrderEvents::ORDER_DELETE => ['onOrderDelete', -100],
      OrderEvents::ORDER_ASSIGN => ['onOrderAssign'],
      OrderEvents::ORDER_PAID => ['onOrderPaid'],
    ];
  }

  /**
   * Create the order's tickets when the order is validated.
   *
   * @param \Drupal\state_machine\Event\WorkflowTransitionEvent $event
   *   The transition event.
   *
   * @throws \Drupal\Core\Entity\EntityStorageException
   */
  public function onValidateTransition(WorkflowTransitionEvent $event) {
    /** @var \Drupal\commerce_order\Entity\OrderInterface $order */
    $order = $event->getEntity();
    $this->autoActivateTickets($order);
  }



  /**
   * Create the order's tickets when the order is fulfilled.
   *
   * @param \Drupal\state_machine\Event\WorkflowTransitionEvent $event
   *   The transition event.
   *
   * @throws \Drupal\Core\Entity\EntityStorageException
   */
  public function onFulfillTransition(WorkflowTransitionEvent $event) {
    /** @var \Drupal\commerce_order\Entity\OrderInterface $order */
    $order = $event->getEntity();
    $this->autoActivateTickets($order);
  }

  /**
   * Cancels the order's tickets when the order is canceled.
   *
   * @param \Drupal\state_machine\Event\WorkflowTransitionEvent $event
   *   The transition event.
   *
   * @throws \Drupal\Component\Plugin\Exception\InvalidPluginDefinitionException
   * @throws \Drupal\Component\Plugin\Exception\PluginNotFoundException
   * @throws \Drupal\Core\Entity\EntityStorageException
   */
  public function onCancelTransition(WorkflowTransitionEvent $event) {
    /** @var \Drupal\commerce_order\Entity\OrderInterface $order */
    $order = $event->getEntity();
    $this->cancelTickets($order);
  }

  /**
   * Event listener for order paid event.
   *
   * @param \Drupal\commerce_order\Event\OrderEvent $orderEvent
   *   The order event.
   *
   * @throws \Drupal\Component\Plugin\Exception\InvalidPluginDefinitionException
   * @throws \Drupal\Component\Plugin\Exception\PluginNotFoundException
   * @throws \Drupal\Core\Entity\EntityStorageException
   */
  public function onOrderPaid(OrderEvent $orderEvent) {
    $order = $orderEvent->getOrder();

    // Automatically create tickets for all placed orders.
    $this->createTickets($order);
    $this->autoActivateTickets($order);

    $order_type_storage = $this->entityTypeManager->getStorage('commerce_order_type');
    /** @var \Drupal\commerce_order\Entity\OrderTypeInterface $order_type */
    $order_type = $order_type_storage->load($order->bundle());
    if ($order_type->getThirdPartySetting('commerce_ticketing', 'send_ticket_mail')) {
      $this->sendTicketMails($order);
    }
  }

  /**
   * Event listener for order delete event.
   *
   * @param \Drupal\commerce_order\Event\OrderEvent $orderEvent
   *   The order event.
   *
   * @throws \Drupal\Component\Plugin\Exception\InvalidPluginDefinitionException
   * @throws \Drupal\Component\Plugin\Exception\PluginNotFoundException
   * @throws \Drupal\Core\Entity\EntityStorageException
   */
  public function onOrderDelete(OrderEvent $orderEvent) {
    $order = $orderEvent->getOrder();
    if ($order->hasField('tickets') && !$order->get('tickets')->isEmpty()) {
      $this->entityTypeManager->getStorage('commerce_ticket')->delete($order->get('tickets')->referencedEntities());
    }
  }

  /**
   * Event listener for order assign event.
   *
   * @param \Drupal\commerce_order\Event\OrderAssignEvent $event
   *   The order event.
   *
   * @throws \Drupal\Core\Entity\EntityStorageException
   */
  public function onOrderAssign(OrderAssignEvent $event) {
    $order = $event->getOrder();
    $original_customer = $order->getCustomer();
    $customer = $event->getCustomer();

    if ($customer->id() != $original_customer->id()) {
      $tickets = $order->get('tickets')->referencedEntities();
      /** @var \Drupal\commerce_ticketing\CommerceTicketInterface[] $tickets */
      foreach ($tickets as $ticket) {
        $ticket->setOwner($customer);
        $ticket->save();
      }
    }
  }

  /**
   * Activate tickets.
   *
   * @param \Drupal\commerce_order\Entity\OrderInterface $order
   *
   * @throws \Drupal\Core\Entity\EntityStorageException
   */
  protected function autoActivateTickets(OrderInterface $order) {
    $existing_tickets = $order->get('tickets')->referencedEntities();
    /** @var \Drupal\commerce_ticketing\CommerceTicketInterface $ticket */
    foreach ($existing_tickets as $ticket) {
      if ($ticket->getPurchasedEntity()) {
        $variation_type = ProductVariationType::load($ticket->getPurchasedEntity()->bundle());
        $order_state = $variation_type->getThirdPartySetting('commerce_ticketing', 'order_state');
        $auto_activate_ticket = $variation_type->getThirdPartySetting('commerce_ticketing', 'auto_activate_ticket');
        if ($auto_activate_ticket && $order->getState()->getId() == $order_state && $ticket->getState()->getId() == 'created') {
          $ticket_state = $ticket->getState();
          $ticket_state_transitions = $ticket_state->getTransitions();
          $ticket_state->applyTransition($ticket_state_transitions['activate']);
          $ticket->save();
        }
      }
    }
  }

  /**
   * Send a ticket mail for each ticket of the order.
   *
   * @param \Drupal\commerce_order\Entity\OrderInterface $order
   *
   * @throws \Drupal\Component\Plugin\Exception\InvalidPluginDefinitionException
   * @throws \Drupal\Component\Plugin\Exception\PluginNotFoundException
   */
  protected function sendTicketMails(OrderInterface $order) {
    $order_item_storage = $this->entityTypeManager->getStorage('commerce_order_item');
    $tickets = $order->get('tickets')->referencedEntities();

    /** @var \Drupal\commerce_ticketing\CommerceTicketInterface[] $tickets */
    foreach ($tickets as $ticket) {
      $current_state = $ticket->getState()->getId();
      /** @var \Drupal\commerce_order\Entity\OrderItem $order_item */
      $order_item = $order_item_storage->load($ticket->get('order_item_id')->getValue()[0]['target_id']);

      $is_sent = isset($order_item->getData('ticket_mail_sent')[$ticket->id()]) && $order_item->getData('ticket_mail_sent')[$ticket->id()];
      $is_added_to_queue = isset($order_item->getData('added_to_queue')[$ticket->id()]) && $order_item->getData('added_to_queue')[$ticket->id()];
      $skip_sending = $order_item->getData('skip_ticket_mail');

      // Try to send an email with attachment.
      if ($current_state == 'active' && !$is_sent && !$is_added_to_queue && !$skip_sending) {
        $this->queue->createItem($ticket);
        $added_to_queue_order_item_data = $order_item->getData('added_to_queue');
        $added_to_queue_order_item_data[$ticket->id()] = TRUE;
        $order_item->setData('added_to_queue', $added_to_queue_order_item_data);
      }
    }
  }

  /**
   * Cancel all related tickets.
   *
   * @param \Drupal\commerce_order\Entity\OrderInterface $order
   *
   * @throws \Drupal\Component\Plugin\Exception\InvalidPluginDefinitionException
   * @throws \Drupal\Component\Plugin\Exception\PluginNotFoundException
   * @throws \Drupal\Core\Entity\EntityStorageException
   */
  protected function cancelTickets(OrderInterface $order) {
    /** @var \Drupal\commerce_ticketing\CommerceTicketInterface[] $tickets */
    $tickets = $order->get('tickets')->referencedEntities();
    foreach ($tickets as $ticket) {
      $ticket_state = $ticket->getState();
      $ticket_state_transitions = $ticket_state->getTransitions();
      if (!empty($ticket_state_transitions['cancel'])) {
        $ticket_state->applyTransition($ticket_state_transitions['cancel']);
        $ticket->save();
      }
    }
  }

}
