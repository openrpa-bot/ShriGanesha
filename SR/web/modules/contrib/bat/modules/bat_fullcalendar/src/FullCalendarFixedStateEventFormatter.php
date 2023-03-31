<?php

namespace Drupal\bat_fullcalendar;

use Drupal\Core\Extension\ModuleHandlerInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\bat_event\EventTypeInterface;
use Roomify\Bat\Event\EventInterface;
use Roomify\Bat\EventFormatter\AbstractEventFormatter;

/**
 * Description message.
 */
class FullCalendarFixedStateEventFormatter extends AbstractEventFormatter {

  /**
   * The event type.
   *
   * @var \Drupal\bat_event\EventTypeInterface
   */
  protected $eventType;

  /**
   * Print as background event.
   *
   * @var bool
   */
  protected $background;

  /**
   * The current user.
   *
   * @var \Drupal\Core\Session\AccountInterface
   */
  protected $currentUser;

  /**
   * The module handler.
   *
   * @var \Drupal\Core\Extension\ModuleHandlerInterface
   */
  protected $moduleHandler;

  /**
   * Description message.
   *
   * @param \Drupal\Core\Session\AccountInterface $current_user
   *   Current user.
   * @param \Drupal\Core\Extension\ModuleHandlerInterface $module_handler
   *   The module handler.
   */
  public function __construct(AccountInterface $current_user, ModuleHandlerInterface $module_handler) {
    $this->background = TRUE;
    $this->currentUser = $current_user;
    $this->moduleHandler = $module_handler;
  }

  /**
   * Description message.
   *
   * @param \Drupal\bat_event\EventTypeInterface $event_type
   *   The event type.
   */
  public function setEventType(EventTypeInterface $event_type) {
    $this->eventType = $event_type;
  }

  /**
   * Description message.
   *
   * @param bool $background
   *   The event type.
   */
  public function setBackground($background) {
    $this->background = $background;
  }

  /**
   * {@inheritdoc}
   */
  public function format(EventInterface $event) {
    $editable = FALSE;

    // Load the unit entity from Drupal.
    $bat_unit = bat_unit_load($event->getUnitId());

    // Get the unit entity default value.
    $default_value = $bat_unit->getEventDefaultValue($this->eventType->id());

    // From
    // https://www.drupal.org/files/issues/2020-04-05/3125109.missing_states.patch
    $calendar_label = '';
    // Get the default state info which will provide the default value for
    // formatting.
    if ($state_info = bat_event_load_state($default_value)) {
      $calendar_label = $state_info->getCalendarLabel();
    }

    // However if the event is in the database,
    // then load the actual event and get its value.
    if ($event->getValue()) {
      // Load the event from the database to get the actual
      // state and load that info.
      if ($bat_event = bat_event_load($event->getValue())) {
        if ($event_label = $bat_event->getEventLabel()) {
          $calendar_label = $event_label;
        }
        elseif ($state_info = bat_event_load_state($bat_event->getEventValue())) {
          $calendar_label = $state_info->getCalendarLabel();
        }

        if (bat_event_access($bat_event, 'update', $this->currentUser)->isAllowed()) {
          $editable = TRUE;
        }
      }
    }

    $formatted_event = [
      'start' => $event->startYear() . '-' . $event->startMonth('m') . '-' . $event->startDay('d') . 'T' . $event->startHour('H') . ':' . $event->startMinute() . ':00',
      'end' => $event->endYear() . '-' . $event->endMonth('m') . '-' . $event->endDay('d') . 'T' . $event->endHour('H') . ':' . $event->endMinute() . ':00',
      'title' => $calendar_label,
      'color' => $state_info ? $state_info->getColor() : '#B4B4B4',
      'blocking' => 1,
      'fixed' => 1,
      'editable' => $editable,
    ];

    // Render non blocking events in the background.
    // if ($state_info->getBlocking() == 0) {.
    if ($state_info && !$state_info->getBlocking()) {
      if ($this->background) {
        $formatted_event['rendering'] = 'background';
      }
      $formatted_event['blocking'] = 0;
    }

    $formatted_event['type'] = $this->eventType->id();

    // Allow other modules to alter the event data.
    $this->moduleHandler->alter('bat_fullcalendar_formatted_event', $formatted_event);

    return $formatted_event;
  }

}
