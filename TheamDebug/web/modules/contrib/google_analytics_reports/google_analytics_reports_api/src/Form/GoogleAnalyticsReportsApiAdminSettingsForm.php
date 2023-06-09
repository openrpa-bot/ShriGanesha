<?php

namespace Drupal\google_analytics_reports_api\Form;

use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Link;
use Drupal\Core\Url;
use Drupal\Core\Datetime\DateFormatterInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\google_analytics_reports_api\GoogleAnalyticsReportsApiFeed;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Represents the admin settings form for google_analytics_reports_api.
 */
class GoogleAnalyticsReportsApiAdminSettingsForm extends FormBase {

  /**
   * The config factory used by the config entity query.
   *
   * @var \Drupal\Core\Config\ConfigFactoryInterface
   */
  protected $configFactory;

  /**
   * The date formatter service.
   *
   * @var \Drupal\Core\Datetime\DateFormatterInterface
   */
  protected $dateFormatter;

  /**
   * The RequestStack service.
   *
   * @var Symfony\Component\HttpFoundation\RequestStack
   */
  protected $requestStack;

  /**
   * Constructs a new Google Analytics Reports Api Admin Settings Form.
   *
   * @param \Drupal\Core\Config\ConfigFactoryInterface $config_factory
   *   The configuration factory.
   * @param \Drupal\Core\Datetime\DateFormatterInterface $date_formatter
   *   The Date formatter.
   * @param Symfony\Component\HttpFoundation\RequestStack $request_stack
   *   The request service.
   */
  public function __construct(ConfigFactoryInterface $config_factory, DateFormatterInterface $date_formatter, RequestStack $request_stack) {
    $this->configFactory = $config_factory;
    $this->dateFormatter = $date_formatter;
    $this->requestStack = $request_stack;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('config.factory'),
      $container->get('date.formatter'),
      $container->get('request_stack')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'google_analytics_reports_api_settings';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return ['google_analytics_reports_api.settings'];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    // TODO move to a separate controller/url? Problematic could be that
    // users have set this url as the allowed redirect url in google console.
    // We could use a event listener?
    $code = $this->getRequest()->query->get('code');
    if ($code) {
      google_analytics_reports_api_authenticate($code);

      $redirect_uri = Url::fromRoute('google_analytics_reports_api.settings')
        ->setAbsolute()
        ->toString();
      $redirect = new RedirectResponse($redirect_uri);
      $redirect->send();
      exit;
    }

    $account = google_analytics_reports_api_gafeed();
    $config = $this->config('google_analytics_reports_api.settings');

    // There are no profiles, and we should just leave it at setup.
    if (!$account || !$account->isAuthenticated()) {
      $dev_console_url = Url::fromUri('https://console.developers.google.com');
      $dev_console_link = Link::fromTextAndUrl($this->t('Google Developers Console'), $dev_console_url)->toRenderable();
      $dev_console_link['#attributes']['target'] = '_blank';

      $current_path_uri = $this->requestStack->getCurrentRequest()->getUri();
      $current_path_url = Url::fromUri($current_path_uri, ['absolute' => TRUE]);

      $setup_help = $this->t('To access data from Google Analytics you have to create a new project in Google Developers Console.');
      $setup_help .= '<ol>';
      $setup_help .= ' <li>' . $this->t('Open %google_developers_console.', ['%google_developers_console' => \Drupal::service('renderer')->render($dev_console_link)]) . '</li>';
      $setup_help .= ' <li>' . $this->t('Along the toolbar click the pull down arrow and the press <strong>Create a Project</strong> button, enter project name and press <strong>Create</strong>.') . '</li>';
      $setup_help .= ' <li>' . $this->t('Click <strong>Enable and manage APIs</strong>.') . '</li>';
      $setup_help .= ' <li>' . $this->t('In the search box type <strong>Analytics</strong> and then press <strong>Analytics API</strong>, this opens the API page, press <strong>Enable</strong>.') . '</li>';
      $setup_help .= ' <li>' . $this->t('Click on <strong>Go to Credentials</strong>') . '</li>';
      $setup_help .= ' <li>' . $this->t('Under <strong>Where will you be calling the API from?</strong> select <strong>Web Browser Javascript</strong> and then select <strong>User Data</strong>') . '</li>';
      $setup_help .= ' <li>' . $this->t('Hit <strong>What credentials do I need</strong>, edit the name if necessary.') . '</li>';
      $setup_help .= ' <li>' . $this->t('Leave empty <strong>Authorized JavaScript origins</strong>, fill in <strong>Authorized redirect URIs</strong> with <code>@url</code> and press <strong>Create Client ID</strong> button.', ['@url' => $current_path_url->toString()]) . '</li>';
      $setup_help .= ' <li>' . $this->t('Type a Product name to show to users and hit <strong>Continue</strong> and then <strong>Done</strong>') . '</li>';
      $setup_help .= ' <li>' . $this->t('Click on the name of your new client ID to be shown both the <strong>Client ID</strong> and <strong>Client Secret</strong>.') . '</li>';
      $setup_help .= ' <li>' . $this->t('Copy <strong>Client ID</strong> and <strong>Client secret</strong> from opened page to the form below.') . '</li>';
      $setup_help .= ' <li>' . $this->t('Press <strong>Start setup and authorize account</strong> in the form below and allow the project access to Google Analytics data.') . '</li>';
      $setup_help .= '</ol>';

      $form['setup'] = [
        '#type' => 'details',
        '#title' => $this->t('Initial setup'),
        '#description' => $setup_help,
        '#open' => TRUE,
      ];

      $form['setup']['client_id'] = [
        '#type' => 'textfield',
        '#title' => $this->t('Client ID'),
        '#default_value' => $config->get('client_id'),
        '#size' => 75,
        '#description' => $this->t('Client ID from your project in Google Developers Console.'),
        '#required' => TRUE,
      ];

      $form['setup']['client_secret'] = [
        '#type' => 'textfield',
        '#title' => $this->t('Client Secret'),
        '#default_value' => $config->get('client_secret'),
        '#size' => 30,
        '#description' => $this->t('Client Secret from your project in Google Developers Console'),
        '#required' => TRUE,
      ];
      $form['setup']['setup_submit'] = [
        '#type' => 'submit',
        '#value' => $this->t('Start setup and authorize account'),
        '#submit' => ['::adminSubmitSetup'],
      ];
    }
    elseif ($account->isAuthenticated()) {
      // Load profiles list.
      $profile_list = google_analytics_reports_api_profiles_list();

      $form['settings'] = [
        '#type' => 'details',
        '#title' => $this->t('Settings'),
        '#open' => TRUE,
      ];

      $profile_info = '';
      if (isset($profile_list['current_profile'])) {
        $profile_info = parse_url($profile_list['current_profile']->websiteUrl, PHP_URL_HOST) . ' - ' . $profile_list['current_profile']->name . ' (' . $profile_list['current_profile']->id . ')';
      }

      $form['settings']['profile_id'] = [
        '#type' => 'select',
        '#title' => $this->t('Reports profile'),
        '#options' => $profile_list['options'],
        '#default_value' => $profile_list['profile_id'],
        '#description' => $this->t('Choose your Google Analytics profile.  The currently active profile is: %profile.', ['%profile' => $profile_info]),
      ];

      // Default cache periods.
      $times = [];
      // 1-6 days.
      for ($days = 1; $days <= 6; $days++) {
        $times[] = $days * 60 * 60 * 24;
      }
      // 1-4 weeks.
      for ($weeks = 1; $weeks <= 4; $weeks++) {
        $times[] = $weeks * 60 * 60 * 24 * 7;
      }

      $options = array_map([
        $this->dateFormatter,
        'formatInterval',
      ], array_combine($times, $times));

      $form['settings']['cache_length'] = [
        '#type' => 'select',
        '#title' => $this->t('Query cache'),
        '#description' => $this->t('The <a href="@link">Google Analytics Quota Policy</a> restricts the number of queries made per day. This limits the creation of new reports on your site.  We recommend setting this cache option to at least three days.', [
          '@link' => Url::fromUri('https://developers.google.com/analytics/devguides/reporting/core/v3/limits-quotas', [
            'fragment' => 'core_reporting',
          ])->toString(),
        ]),
        '#options' => $options,
        '#default_value' => $config->get('cache_length'),
      ];

      $form['settings']['settings_submit'] = [
        '#type' => 'submit',
        '#value' => $this->t('Save settings'),
        '#submit' => ['::adminSubmitSettings'],
      ];
      $form['revoke'] = [
        '#type' => 'details',
        '#title' => $this->t('Revoke access and logout'),
        '#description' => $this->t('Revoke your access token from Google Analytics. This action will log you out of your Google Analytics account and stop all reports from displaying on your site.'),
      ];
      $form['revoke']['revoke_submit'] = [
        '#type' => 'submit',
        '#value' => $this->t('Revoke access token'),
        '#submit' => ['::adminSubmitRevoke'],
      ];
    }

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
  }

  /**
   * Save Google Analytics Reports API admin setup.
   */
  public function adminSubmitSetup(array &$form, FormStateInterface $form_state) {
    $config = $this->configFactory->getEditable('google_analytics_reports_api.settings');
    $config
      ->set('client_id', $form_state->getValue('client_id'))
      ->set('client_secret', $form_state->getValue('client_secret'))
      ->save();

    $redirect_uri = Url::fromRoute('google_analytics_reports_api.settings')
      ->setAbsolute()
      ->toString();

    $google_analytics_reports_api_feed = new GoogleAnalyticsReportsApiFeed();
    $response = $google_analytics_reports_api_feed->beginAuthentication($form_state->getValue('client_id'), $redirect_uri);
    $form_state->setResponse($response);
  }

  /**
   * Save Google Analytics Reports API settings.
   */
  public function adminSubmitSettings(array &$form, FormStateInterface $form_state) {
    $config = $this->configFactory->getEditable('google_analytics_reports_api.settings');
    $config
      ->set('profile_id', $form_state->getValue('profile_id'))
      ->set('cache_length', $form_state->getValue('cache_length'))
      ->save();
    $this->messenger()->addMessage($this->t('Settings have been saved successfully.'));
  }

  /**
   * Revoke Google Analytics access token.
   */
  public function adminSubmitRevoke(array &$form, FormStateInterface $form_state) {
    google_analytics_reports_api_revoke();
    $this->messenger()->addMessage($this->t('Access token has been successfully revoked.'));
  }

}
