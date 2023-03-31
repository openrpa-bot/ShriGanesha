<?php

namespace Drupal\commerce_ticketing\Routing;

use Drupal\Component\Uuid\Uuid;
use Drupal\Core\ParamConverter\EntityConverter;
use Drupal\Core\ParamConverter\ParamConverterInterface;
use Symfony\Component\Routing\Route;

class UuidParamConverter extends EntityConverter implements ParamConverterInterface {

  /**
   * {@inheritdoc}
   */
  public function convert($value, $definition, $name, array $defaults) {
    if (!empty($value) && Uuid::isvalid($value)) {
      $storage = $this->entityTypeManager->getStorage('commerce_ticket');
      if ($entities = $storage->loadByProperties(['uuid' => $value])) {
        return reset($entities);
      }
    }
    return NULL;
  }

  /**
   * {@inheritdoc}
   */
  public function applies($definition, $name, Route $route) {
    return (parent::applies($definition, $name, $route) && $definition['type'] === 'entity:commerce_ticket');
  }

}
