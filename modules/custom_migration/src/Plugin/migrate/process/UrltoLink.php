<?php

namespace Drupal\custom_migration\Plugin\migrate\process;

use Drupal\migrate\MigrateExecutableInterface;
use Drupal\migrate\Plugin\MigrateProcessInterface;
use Drupal\migrate\ProcessPluginBase;
use Drupal\migrate\Row;

/**
 * Converts a URL string into a link field array.
 *
 * @MigrateProcessPlugin(
 *   id = "url_to_link"
 * )
 */
class UrltoLink extends ProcessPluginBase implements MigrateProcessInterface
{

    /**
     * {@inheritdoc}
     */
    public function transform($value, MigrateExecutableInterface $migrate_executable, Row $row, $destination_property) {
  // If the source value is an array, try to extract the first value.
  if (is_array($value)) {
    if (isset($value['url'])) {
      $value = $value['url']; // From field collection style data
    }
    elseif (isset($value[0])) {
      $value = is_array($value[0]) && isset($value[0]['value']) ? $value[0]['value'] : $value[0];
    }
    else {
      $value = reset($value);
    }
  }

  // Sanitize the URL and ensure it starts with http/https.
  if (!empty($value) && !preg_match('/^https?:\/\//i', $value)) {
    $value = 'https://' . ltrim($value, '/');
  }

  return [
    'uri' => $value,
    'title' => '',
    'options' => [],
  ];
}


}
