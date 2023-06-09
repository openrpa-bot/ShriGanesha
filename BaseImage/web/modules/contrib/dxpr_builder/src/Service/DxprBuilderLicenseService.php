<?php

namespace Drupal\dxpr_builder\Service;

use Drupal\Component\Datetime\TimeInterface;
use Drupal\Component\Serialization\Json;
use Drupal\Component\Utility\Crypt;
use Drupal\Component\Utility\Html;
use Drupal\Component\Utility\UrlHelper;
use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Database\Connection;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Extension\ModuleExtensionList;
use Drupal\Core\Cache\CacheBackendInterface;
use Drupal\Core\Messenger\MessengerInterface;
use Drupal\Core\Site\Settings;
use Drupal\Core\State\StateInterface;
use Drupal\Core\StringTranslation\StringTranslationTrait;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Url;
use Drupal\Core\Queue\QueueFactory;
use Drupal\Core\Session\AccountProxyInterface;
use Drupal\user\UserInterface;
use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use Psr\Http\Message\ResponseInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Description.
 */
class DxprBuilderLicenseService implements DxprBuilderLicenseServiceInterface, EventSubscriberInterface {

  use StringTranslationTrait;

  /**
   * The request stack.
   *
   * @var \Symfony\Component\HttpFoundation\RequestStack
   */
  private $requestStack;

  /**
   * The entity type manager service.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  private $entityTypeManager;

  /**
   * The database connection.
   *
   * @var \Drupal\Core\Database\Connection
   */
  private $database;

  /**
   * The http client.
   *
   * @var \GuzzleHttp\Client
   */
  private $client;

  /**
   * The config factory service.
   *
   * @var \Drupal\Core\Config\ConfigFactoryInterface
   */
  private $configFactory;

  /**
   * The module extension list service.
   *
   * @var \Drupal\Core\Extension\ModuleExtensionList
   */
  private $moduleExtensionList;

  /**
   * The state service.
   *
   * @var \Drupal\Core\State\StateInterface
   */
  private $state;

  /**
   * The cache.default cache backend.
   *
   * @var \Drupal\Core\Cache\CacheBackendInterface
   */
  private $cache;

  /**
   * Queue for site user updates.
   *
   * @var \Drupal\Core\Queue\QueueInterface
   */
  private $queue;

  /**
   * The current user.
   *
   * @var \Drupal\Core\Session\AccountProxyInterface
   */
  protected $currentUser;

  /**
   * The messenger service.
   *
   * @var \Drupal\Core\Messenger\MessengerInterface
   */
  protected $messenger;

  /**
   * The time service.
   *
   * @var \Drupal\Component\Datetime\TimeInterface
   */
  protected $time;

  /**
   * DxprBuilderLicenseService constructor.
   *
   * @param \Symfony\Component\HttpFoundation\RequestStack $requestStack
   *   The request stack.
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entity_type_manager
   *   The entity type manager service.
   * @param \Drupal\Core\Database\Connection $database
   *   The database connection.
   * @param \GuzzleHttp\Client $client
   *   The http client.
   * @param \Drupal\Core\Config\ConfigFactoryInterface $config_factory
   *   The config factory service.
   * @param \Drupal\Core\Extension\ModuleExtensionList $module_extension_list
   *   The module extension list service.
   * @param \Drupal\Core\State\StateInterface $state
   *   The state service.
   * @param \Drupal\Core\Cache\CacheBackendInterface $cache
   *   The cache backend.
   * @param \Drupal\Core\Queue\QueueFactory $queue_factory
   *   Queue for site user updates.
   * @param \Drupal\Core\Session\AccountProxyInterface $currentUser
   *   The current user.
   * @param \Drupal\Core\Messenger\MessengerInterface $messenger
   *   The messenger service.
   * @param \Drupal\Component\Datetime\TimeInterface $time
   *   The time service.
   */
  public function __construct(
    RequestStack $requestStack,
    EntityTypeManagerInterface $entity_type_manager,
    Connection $database,
    Client $client,
    ConfigFactoryInterface $config_factory,
    ModuleExtensionList $module_extension_list,
    StateInterface $state,
    CacheBackendInterface $cache,
    QueueFactory $queue_factory,
    AccountProxyInterface $currentUser,
    MessengerInterface $messenger,
    TimeInterface $time
  ) {
    $this->requestStack = $requestStack;
    $this->entityTypeManager = $entity_type_manager;
    $this->database = $database;
    $this->client = $client;
    $this->configFactory = $config_factory;
    $this->moduleExtensionList = $module_extension_list;
    $this->state = $state;
    $this->cache = $cache;
    $this->queue = $queue_factory->get('dxpr_builder_site_user');
    $this->currentUser = $currentUser;
    $this->messenger = $messenger;
    $this->time = $time;
  }

  /**
   * {@inheritdoc}
   */
  public static function getSubscribedEvents() {
    $events[KernelEvents::TERMINATE][] = ['processSyncQueue'];
    return $events;
  }

  /**
   * {@inheritdoc}
   */
  public function getLicenseInfo() {
    $domain = $this->requestStack->getCurrentRequest()->getHost();
    $base_url = Url::fromRoute('<front>', [], ['absolute' => TRUE])->toString();
    $jwt = $this->configFactory->get('dxpr_builder.settings')->get('json_web_token');

    $free_tier = [
      'users_limit' => 1,
      'entities_limit' => 10,
    ];

    if (!$jwt) {
      return ['status' => 'not found'] + $free_tier;
    }

    $result = $this->cache->get('dxpr_builder_license_info');
    if ($result !== FALSE) {
      return $result->data;
    }

    $site = Crypt::hmacBase64(Settings::getHashSalt(), '3TUoWRDSEFn77KMT');
    $domain = Html::escape($domain);
    $module_info = $this->moduleExtensionList->getExtensionInfo('dxpr_builder');

    $users_count = $this->getUsersCount();
    $users_tier = $this->getUsersTier($users_count);
    $this->state->set('dxpr_builder.users_tier_users_count', $users_tier . ' ' . $users_count);

    $query = UrlHelper::buildQuery([
      'gba' => $users_count,
      'users_tier' => $users_tier,
      'project' => 'dxpr_builder',
      'site_base_url' => $base_url,
      'site' => $site,
      'values_count' => $this->getValuesCount(),
      'site_mail' => $this->configFactory->get('system.site')->get('mail'),
      'version' => $module_info['version'] ?? NULL,
    ]);
    $end_point = self::DOMAIN_STATUS_ENDPOINT . '?' . $query;
    $request_options = [
      RequestOptions::HEADERS => [
        'Authorization' => 'Bearer ' . $jwt,
      ],
    ];
    try {
      $result = $this->client->request('GET', $end_point, $request_options);
    }
    catch (\Exception $e) {
      $this->messenger->addMessage($this->t('DXPR Subscription lookup failed due to an error.'), 'warning');
      watchdog_exception('dxpr_builder', $e);
      $result = FALSE;
    }

    if ($result instanceof ResponseInterface && $result->getStatusCode() === 200) {
      $result = Json::decode($result->getBody());
      $result['users_count'] = $users_count;
      $result['status'] = 'authorized';
    }
    else {
      $result = [
        'status' => 'not found',
        'users_limit' => NULL,
        'entities_limit' => NULL,
      ];
    }

    $authorized = !isset($result['status']) || $result['status'] === 'authorized';
    $interval = $authorized ? self::LICENSE_CHECK_INTERVAL : self::LICENSE_NOT_AUTHORIZED_INTERVAL;
    $now = $this->time->getRequestTime();
    $this->cache->set('dxpr_builder_license_info', $result, $now + $interval);

    return $result;
  }

  /**
   * {@inheritdoc}
   */
  public function isBlacklisted() {
    $domain = $this->requestStack->getCurrentRequest()->getHost();

    $blacklisted = $this->cache->get('dxpr_builder_blacklisted');
    if ($blacklisted !== FALSE) {
      return $blacklisted->data;
    }

    $end_point = self::DOMAIN_BLACKLIST_ENDPOINT . $domain;

    try {
      $result = $this->client->request('GET', $end_point);
    }
    catch (\Exception $e) {
      watchdog_exception('dxpr_builder', $e);
      $result = FALSE;
    }

    if ($result instanceof ResponseInterface && $result->getStatusCode() === 200) {
      $result = Json::decode($result->getBody());
    }

    $blacklisted = isset($result['status']) && $result['status'] === 'blacklisted';
    $interval = $blacklisted ? self::BLACKLIST_BLOCKED_INTERVAL : self::BLACKLIST_CHECK_INTERVAL;
    $now = $this->time->getRequestTime();
    $this->cache->set('dxpr_builder_blacklisted', $blacklisted, $now + $interval);

    $blacklisted_state = $this->state->get('dxpr_builder.blacklisted', FALSE);
    if ($blacklisted_state !== $blacklisted) {
      $this->state->set('dxpr_builder.blacklisted', $blacklisted);
      drupal_flush_all_caches();
    }

    return $blacklisted;
  }

  /**
   * {@inheritdoc}
   */
  public function removeMailFromCentralStorage(string $mail): void {
    $this->queue->createItem([
      'users_data' => [
        [
          'mail' => $mail,
          'roles' => [],
        ],
      ],
      'operation' => DxprBuilderLicenseServiceInterface::DXPR_USER_REMOVE_OPERATION,
    ]);
  }

  /**
   * {@inheritdoc}
   */
  public function syncUsersWithCentralStorage(array $user_ids, string $operation, string $json_web_token = ''): void {
    // Build a list of users.
    $users_data = [];
    foreach ($user_ids as $user_id) {
      if ($user = $this->entityTypeManager->getStorage('user')->load($user_id)) {
        $users_data[] = [
          'mail' => $user->getEmail(),
          'roles' => $user->getRoles(),
        ];
      }
    }

    // We will only execute the first call directly and queue subsequent calls.
    // Always queue when a hostname is not available (when running from Drush).
    // Run directly when JWT is provided (when changing license in settings).
    static $called = TRUE;
    if (empty($json_web_token) && ($called || !$this->hasHostname())) {
      $this->queue->createItem([
        'users_data' => $users_data,
        'operation' => $operation,
      ]);
      return;
    }
    else {
      $called = TRUE;
      $this->sendToCentralStorage($users_data, $operation, $json_web_token);
    }
  }

  /**
   * {@inheritdoc}
   */
  public function syncAllUsersWithCentralStorage(string $operation, string $json_web_token = ''): void {
    $dxpr_editors = $this->getEditors();
    $this->syncUsersWithCentralStorage($dxpr_editors, $operation, $json_web_token);
  }

  /**
   * {@inheritdoc}
   */
  public function isBillableUser(UserInterface $account) {
    if ($account->isBlocked()) {
      return FALSE;
    }
    if ($account->id() == 1 || $account->hasPermission('edit with dxpr builder')) {
      return TRUE;
    }
    return FALSE;
  }

  /**
   * Get user ids for DXPR editors.
   *
   * @return array
   *   User ID's.
   *
   * @phpstan-return array<int, string>
   */
  private function getEditors(): array {
    $dxpr_builder_role_ids = [];
    foreach ($this->entityTypeManager->getStorage('user_role')->loadMultiple() as $user_role) {
      if ($user_role->hasPermission('edit with dxpr builder')) {
        $dxpr_builder_role_ids[] = $user_role->id();
      }
    }
    if ($dxpr_builder_role_ids) {
      $result = $this->entityTypeManager->getStorage('user')
        ->getQuery()
        ->accessCheck(FALSE)
        ->condition('roles', $dxpr_builder_role_ids, 'IN')
        ->execute();
      $dxpr_editors = array_values($result);
    }
    else {
      $dxpr_editors = [];
    }
    if (!in_array('1', $dxpr_editors)) {
      $dxpr_editors[] = '1';
    }
    return $dxpr_editors;
  }

  /**
   * Check if a hostname is available.
   *
   * @return bool
   *   Returns boolean value
   */
  private function hasHostname() {
    return $this->requestStack->getCurrentRequest()->getHost() !== 'default';
  }

  /**
   * Send to license storage API.
   *
   * @param mixed[] $users_data
   *   The user data.
   * @param string $operation
   *   The opertion.
   * @param string $json_web_token
   *   DXPR product key in JWT.
   */
  private function sendToCentralStorage(array $users_data, string $operation, string $json_web_token = ''): void {
    $hostname = $this->requestStack->getCurrentRequest()->getHost();
    $config = $this->configFactory->get('dxpr_builder.settings');
    if (empty($json_web_token)) {
      $json_web_token = $config->get('json_web_token');
    }
    if (!empty($users_data) && $json_web_token !== NULL) {
      $config = $this->configFactory->get('dxpr_builder.settings');
      $endpoint = $config->get('license_endpoint') ?? self::CENTRAL_USER_STORAGE_ENDPOINT;
      try {
        $request_options = [
          RequestOptions::HEADERS => [
            'Authorization' => 'Bearer ' . $json_web_token,
          ],
          RequestOptions::JSON => [
            'domain' => $hostname,
            'users' => $users_data,
          ],
        ];
        $this->client->request('POST', $endpoint . $operation, $request_options);
        // Clear cache to immediately reflect changes on admin pages.
        $this->cache->invalidate('dxpr_builder_license_info');
      }
      catch (\Exception $e) {
        watchdog_exception('dxpr_builder', $e);
        // Add item to queue to try again later.
        $this->queue->createItem([
          'users_data' => $users_data,
          'operation' => $operation,
        ]);
      }
    }
  }

  /**
   * {@inheritdoc}
   */
  public function processSyncQueue(): void {
    $account = $this->entityTypeManager->getStorage('user')->load($this->currentUser->id());
    if (!$account->hasPermission('edit with dxpr builder')) {
      // Only execute process for editors to minimize performance impact.
      return;
    }
    if (!$this->hasHostname()) {
      // Do not run in Drush calls.
      return;
    }

    // Group users per operation. Each operation is a separate API call.
    $data = [];
    $limit = 100;
    while (($item = $this->queue->claimItem()) && --$limit) {
      /** @var object|null $item */
      if (!isset($data[$item->data['operation']])) {
        $data[$item->data['operation']] = [];
      }
      $data[$item->data['operation']] = array_merge($data[$item->data['operation']], $item->data['users_data']);
      $this->queue->deleteItem($item);
    }

    // Send users to API.
    foreach (array_keys($data) as $operation) {
      try {
        $this->sendToCentralStorage($data[$operation], $operation);
      }
      catch (\Exception $e) {
        watchdog_exception('dxpr_builder', $e);
      }
    }
  }

  /**
   * {@inheritdoc}
   */
  public function getUserLicenseInfo() {
    $license_info = $this->state->get('dxpr_user_license_info');

    if (empty($license_info)) {
      $license_info = [
        'dxpr_users' => $this->getUsersCount(),
        'allocated_seats' => 0,
      ];

      $this->state->set('dxpr_user_license_info', $license_info);
    }

    return $license_info;
  }

  /**
   * {@inheritdoc}
   */
  public function getUsersCount() {
    $users = $this->getLicenseUsers();
    return count(array_keys($users));
  }

  /**
   * Get users tier.
   *
   * @param int $count
   *   Count for which needs to get tier.
   *
   * @return int
   *   Tier value.
   */
  protected function getUsersTier($count) {
    $tier = 0;
    if ($count) {
      foreach (self::TIERS_ARRAY as $preset) {
        if ($count < $preset) {
          break;
        }
        $tier = $preset;
      }
    }
    return $tier;
  }

  /**
   * {@inheritdoc}
   */
  public function getValuesCount(string $entity_type_filter = NULL, string $before_id = NULL) {
    /** @var \Drupal\Core\Entity\Display\EntityViewDisplayInterface[] $entity_view_displays */
    $entity_view_displays = $this->entityTypeManager->getStorage('entity_view_display')
      ->loadMultiple();

    $entity_types = [];
    foreach ($entity_view_displays as $entity_view_display) {
      foreach ($entity_view_display->getComponents() as $component) {
        if (isset($component['type']) && $component['type'] === 'dxpr_builder_text') {
          $entity_type = $entity_view_display->getTargetEntityTypeId();
          if (!$entity_type_filter || $entity_type_filter === $entity_type) {
            $entity_types[$entity_type][] = $entity_view_display->getTargetBundle();
          }
          break;
        }
      }
    }

    $values_count = 0;
    foreach ($entity_types as $entity_type_id => $entity_bundles) {
      try {
        if ($this->entityTypeManager->hasHandler($entity_type_id, 'storage')) {
          $entity_type = $this->entityTypeManager->getStorage($entity_type_id)
            ->getEntityType();
          $id_key = $entity_type->getKey('id');
          $bundle_key = $entity_type->getKey('bundle');
          $data_table = $entity_type->getDataTable();

          if ($data_table && $entity_type->isTranslatable()) {
            $query = $this->database->select($data_table);
          }
          else {
            $query = $this->database->select($entity_type->getBaseTable());
          }

          if ($bundle_key) {
            $query->condition($bundle_key, $entity_bundles, 'IN');
          }

          if ($before_id) {
            $query->condition($id_key, $before_id, '<');
          }

          $count = $query->countQuery()
            ->execute()
            ->fetchField();

          $values_count += (int) $count;
        }
      }
      catch (\Exception $exception) {
        watchdog_exception('dxpr_builder', $exception);
      }
    }

    return $values_count;
  }

  /**
   * {@inheritdoc}
   */
  public function getLicenseUsers() {
    $result = '';

    $cache_result = $this->cache->get('dxpr_builder_license_users');
    if ($cache_result !== FALSE) {
      return $cache_result->data;
    }

    try {
      $endpoint = self::USERS_ENDPOINT;
      $config = $this->configFactory->get('dxpr_builder.settings');

      $jwt = $config->get('json_web_token');
      if (!$jwt) {
        // No license set. Do not request users from central storage,
        // but make sure to list billable users from the current site.
        $users_data = [];
        foreach ($this->getEditors() as $uid) {
          $user = $this->entityTypeManager->getStorage('user')->load($uid);
          $users_data[$user->getEmail()] = [
            'domains' => 1,
            'roles' => $user->getRoles(),
          ];
        }
        return $users_data;
      }

      $request_options = [
        RequestOptions::HEADERS => [
          'Authorization' => 'Bearer ' . $jwt,
        ],
      ];
      $result = $this->client->request('GET', $endpoint, $request_options);
      if ($result instanceof ResponseInterface && $result->getStatusCode() === 200) {
        $result = Json::decode($result->getBody());
        $interval = self::LICENSE_CHECK_INTERVAL;
        $now = $this->time->getRequestTime();
        $this->cache->set('dxpr_builder_license_users', $result['site_users'], $now + $interval);
      }
    }
    catch (\Exception $e) {
      watchdog_exception('dxpr_builder', $e);
      $this->messenger->addError($this->t('We are having trouble connecting to the DXPR servers, the data will refresh when the network is working again.'));
      return [];
    }
    return $result['site_users'];
  }

  /**
   * {@inheritdoc}
   */
  public function withinUsersLimit(AccountInterface $account) {
    $license_info = $this->getLicenseInfo();
    if (empty($license_info['users_limit'])) {
      // Number of users is not limited for this licenses.
      return TRUE;
    }

    // Count users registered before the logged in user.
    $users_before_count = 0;
    $users = $this->getLicenseUsers();
    if (isset($users[$account->getEmail()])) {
      $account_id = $users[$account->getEmail()]['id'];
      foreach ($users as $user) {
        if ($user['id'] < $account_id) {
          ++$users_before_count;
        }
      }
    }
    else {
      $users_before_count = count(array_keys($users));
    }

    return $users_before_count < $license_info['users_limit'];
  }

  /**
   * {@inheritdoc}
   */
  public function withinEntitiesLimit(EntityInterface $entity) {
    $license_info = $this->getLicenseInfo();
    if (empty($license_info['entities_limit'])) {
      // Number of entities is not limited for this licenses.
      return TRUE;
    }
    $entities_before_count = $this->getValuesCount(
      $entity->getEntityTypeId(),
      $entity->id()
    );
    return $entities_before_count < $license_info['entities_limit'];
  }

}
