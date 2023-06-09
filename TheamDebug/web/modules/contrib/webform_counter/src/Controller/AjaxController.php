<?php

namespace Drupal\webform_counter\Controller;

use Drupal\webform\WebformSubmissionStorageInterface;
use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\ReplaceCommand;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\StringTranslation\PluralTranslatableMarkup;
use Drupal\Component\Gettext\PoItem;
use Drupal\webform\Entity\Webform;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Controller for AJAX calls.
 */
class AjaxController extends ControllerBase {

  /**
   * Replaces the counter placeholder generated by webform_counter_tokens().
   *
   * @param \Symfony\Component\HttpFoundation\Request $request
   *
   * @return \Drupal\Core\Ajax\AjaxResponse|\Symfony\Component\HttpFoundation\Response
   */
  public function counter(Request $request) {
    $webform_id = $request->request->get('webform');
    if (!is_scalar($webform_id) || trim($webform_id) === '') {
      return new Response('The "webform" parameter is missing or has incorrect format', 400);
    }
    $webform = Webform::load($webform_id);
    if (!$webform) {
      return new Response('Cannot find requested webform', 400);
    }
    $type = $request->request->get('type');
    if ($type !== 'basic' && $type !== 'progress') {
      return new Response('The "type" parameter is missing or has incorrect format/value', 400);
    }
    $selector = $request->request->get('selector');
    if (!is_scalar($selector) || trim($selector) === '') {
      return new Response('The "selector" parameter is missing or has incorrect format', 400);
    }

    $submissions_count_text = $webform->getThirdPartySetting('webform_counter', 'submissions_count_text');
    if (
      !($parts = explode(PoItem::DELIMITER, $submissions_count_text)) ||
      count($parts) < 2 ||
      trim($parts[0]) === '' ||
      trim($parts[1]) === ''
    ) {
      return new Response('Counter is not setup for this webform', 406);
    }

    $offline_count = $webform->getThirdPartySetting('webform_counter', 'offline_submissions_count') ?: 0;
    $submission_storage = \Drupal::entityTypeManager()->getStorage('webform_submission');
    assert($submission_storage instanceof WebformSubmissionStorageInterface);
    $count = $submission_storage->getTotal($webform) + $offline_count;

    $submissions_count_text = PluralTranslatableMarkup::createFromTranslatedString($count, $submissions_count_text);

    $progress_bar  = '';
    $target_count = $webform->getThirdPartySetting('webform_counter', 'target_submissions_count') ?: 0;
    $percent = round(100 * $count / $target_count);
    $percent = $percent < 0 ? 0 : ($percent > 100 ? 100 : $percent);
    if ($type === 'progress' && $target_count) {
      $build = [
        '#theme' => 'progress_bar',
        '#percent' => $percent,
      ];
      $progress_bar = \Drupal::service('renderer')->render($build);
    }

    $build = [
      '#type' => 'inline_template',
      '#template' => "
        <span
          class='webform-counter webform-counter--wrapper webform-counter--{{ type }}'
        >
          $progress_bar
          <span class='webform-counter--text'>{{ content }}</span>
        </span>
      ",
      '#context' => [
        'content' => $submissions_count_text,
        'type' => $type,
      ],
    ];

    $response = new AjaxResponse();
    $response->addCommand(new ReplaceCommand($selector, \Drupal::service('renderer')->render($build)));
    return $response;
  }

}
