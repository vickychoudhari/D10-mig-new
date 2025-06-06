<?php

namespace Drupal\article_queue_worker\Commands;

use Drupal\Core\Database\Database;
use Drupal\Core\Queue\QueueFactory;
use Drush\Commands\DrushCommands;

/**
 * Drush command to fetch articles from remote DB and queue them.
 */
class ArticleQueueDrushCommand extends DrushCommands
{

    protected $queueFactory;

    public function __construct(QueueFactory $queue_factory)
    {
        $this->queueFactory = $queue_factory;
    }

    /**
     * Fetch remote article nodes and queue them.
     *
     * @command article:queue:remote
     */
    public function queueRemoteArticles()
    {
        // Get connection to remote DB (set in settings.php)
        $remote = Database::getConnection('default', 'migrated7');
        $queue = $this->queueFactory->get('article_node_queue_worker');

        $query = $remote->select('node_field_data', 'n')
            ->fields('n', ['nid', 'title', 'created'])
            ->condition('type', 'article')
            ->condition('status', 1)
            ->range(0, 10);

        $results = $query->execute();

        foreach ($results as $row) {
            $item = [
                'nid' => $row->nid,
                'title' => $row->title,
                'created' => date('c', $row->created),
            ];
            $queue->createItem($item);
            $this->output()->writeln("Queued article: {$item['title']} (NID: {$item['nid']})");
        }
    }

}
