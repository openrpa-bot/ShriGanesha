<?php

namespace Drupal\Core\Entity;

/**
 * Provides a trait for accessing changed time.
 */
trait EntityChangedTrait {

  /**
   * Returns the timestamp of the last entity change across all translations.
   *
   * @return int
   *   The timestamp of the last entity save operation across all
   *   translations.
   */
  public function getChangedTimeAcrossTranslations() {
    $changed = $this->getUntranslated()->getChangedTime();
    foreach ($this->getTranslationLanguages(FALSE) as $language) {
      $translation_changed = $this->getTranslation($language->getId())->getChangedTime();
      $changed = max($translation_changed, $changed);
    }
    return $changed;
  }

  /**
   * Gets the timestamp of the last entity change for the current translation.
   *
   * @return int|null
   *   The timestamp of the last entity save operation. Some entities allow a
   *   NULL value indicating the changed time is unknown.
   */
  public function getChangedTime() {
    $value = $this->get('changed')->value;
    return isset($value) ? (int) $value : NULL;
  }

  /**
   * Sets the timestamp of the last entity change for the current translation.
   *
   * @param int $timestamp
   *   The timestamp of the last entity save operation.
   *
   * @return $this
   */
  public function setChangedTime($timestamp) {
    $this->set('changed', $timestamp);
    return $this;
  }

}
