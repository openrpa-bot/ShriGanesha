<?php

namespace Drupal\commerce_ticketing;

use Drupal\entity_print\Plugin\PrintEngineInterface;
use Drupal\entity_print\PrintBuilder as EntityPrintPrintBuilder;

/**
 * The print builder service.
 */
class PrintBuilder extends EntityPrintPrintBuilder {

  /**
   * {@inheritdoc}
   */
  public function deliverPrintableforMail(array $entities, PrintEngineInterface $print_engine, $use_default_css = TRUE) {
    $this->prepareRenderer($entities, $print_engine, $use_default_css);
    return $print_engine->getBlob();
  }

}
