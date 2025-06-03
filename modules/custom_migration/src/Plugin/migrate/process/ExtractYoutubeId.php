<?php

namespace Drupal\custom_migration\Plugin\migrate\process;

use Drupal\migrate\MigrateExecutableInterface;
use Drupal\migrate\Plugin\MigrateProcessInterface;
use Drupal\migrate\ProcessPluginBase;
use Drupal\migrate\Row;

/**
 * Extracts YouTube video ID from a URL.
 *
 * @MigrateProcessPlugin(
 *   id = "extract_youtube_id"
 * )
 */
class ExtractYoutubeId extends ProcessPluginBase implements MigrateProcessInterface
{

    /**
     * {@inheritdoc}
     */
    public function transform($value, MigrateExecutableInterface $migrate_executable, Row $row, $destination_property)
    {

        if (preg_match('/(?:youtube\.com\/watch\?v=|youtu\.be\/)([^&]+)/', $value, $matches)) {
            return $matches[1];
        }
        dump($value);
        return $value;
    }

}
