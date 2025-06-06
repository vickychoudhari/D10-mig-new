<?php

namespace Drupal\custom_migration\Plugin\migrate\source;

use Drupal\migrate_drupal\Plugin\migrate\source\DrupalSqlBase;

/**
 * Source plugin for Nodequeue.
 *
 * @MigrateSource(
 *   id = "d7_nodequeue"
 * )
 */
class D7Nodequeue extends DrupalSqlBase
{

    public function query()
    {
        return $this->select('nodequeue_queue', 'nq')
            ->fields('nq', ['qid', 'name', 'title']);
    }

    public function fields()
    {
        return [
            'qid' => $this->t('Queue ID'),
            'name' => $this->t('Queue machine name'),
            'title' => $this->t('Queue title'),
        ];
    }

    public function getIds()
    {
        return [
            'qid' => [
                'type' => 'integer',
                'alias' => 'nq',
            ],
        ];
    }
}
