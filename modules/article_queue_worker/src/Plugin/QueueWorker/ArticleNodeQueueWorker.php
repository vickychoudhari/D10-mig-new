<?php

namespace Drupal\article_queue_worker\Plugin\QueueWorker;

use Drupal\Core\Queue\QueueWorkerBase;
use Drupal\node\Entity\Node;

/**
 * QueueWorker for importing article nodes.
 *
 * @QueueWorker(
 *   id = "article_node_queue_worker",
 *   title = @Translation("Article Node Queue Worker"),
 *   cron = {"time" = 30}
 * )
 */
class ArticleNodeQueueWorker extends QueueWorkerBase
{

    public function processItem($data)
    {
        $node = Node::create([
            'type' => 'article',
            'title' => $data['title'],
            'body' => [
                'value' => "Imported from remote. NID: {$data['nid']}",
                'format' => 'basic_html',
            ],
            'created' => strtotime($data['created']),
        ]);
        $node->save();

        \Drupal::logger('article_queue_worker')->notice("Created article: @title", [
            '@title' => $data['title'],
        ]);
    }

}
