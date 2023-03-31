<?php

namespace Drupal\bat_event\Util;

use Drupal\datetime\Plugin\Field\FieldType\DateTimeItemInterface;
use Drupal\Core\Datetime\DrupalDateTime;

/**
 * Defines the Utility EventMaintenance class.
 */
class EventMaintenance {

  /**
   * Remove old events from database.
   */
  public function deleteOldBatEvents($options) {

    $config = \Drupal::config('bat_event.settings');

    if (empty($config->get("enable_remove_old_events"))) {
      return;
    }

    $date = new DrupalDateTime((int) $config->get("daysago") . ' days ago');
    $date->setTimezone(new \DateTimezone(DateTimeItemInterface::STORAGE_TIMEZONE));
    $formatted = $date->format(DateTimeItemInterface::DATETIME_STORAGE_FORMAT);

    $query = \Drupal::entityQuery('bat_event');
    $query->accessCheck(FALSE);
    $count_pre = $query
      ->count()
      ->execute();

    $ids = \Drupal::entityQuery('bat_event')
      ->condition('event_dates.value', $formatted, '<')
      ->range(0, (int) $config->get("howmany"))
      ->execute();

    bat_event_delete_multiple($ids);

    $query = \Drupal::entityQuery('bat_event');
    $query->accessCheck(FALSE);
    $count_post = $query->count()->execute();

    $tmp = [
      "%c" => $config->get("howmany"),
      "%older" => $config->get("daysago"),
      "%remain" => $count_post,
      "%count_pre" => $count_pre,
    ];
    $message = t("counter_pre : [ %counter_pre ].N. %c bat_event(s)  older than %older days deleted. %remain bat_event(s) still in DB", $tmp);
    \Drupal::logger('bat_event')->notice($message);
  }

}
