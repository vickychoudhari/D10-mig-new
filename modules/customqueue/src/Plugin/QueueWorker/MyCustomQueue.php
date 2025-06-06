<?php

namespace Drupal\customqueue\QueueWorker;

use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Queue\QueueWorkerBase;

/**
 * Processes queued items using batch processing.
 *
 * @QueueWorker(
 * id = "customqueue_queue_worker",
 * title = @Translation("customqueue Queue Worker"),
 * cron = {"time" = 60}
 * )
 */
class MyCustomQueue extends QueueWorkerBase
{

/**
 * The entity type manager.
 *
 * @var \Drupal\Core\Entity\EntityTypeManagerInterface
 */
    protected $entityTypeManager;

/**
 * Constructs a new MyCustomQueue object.
 *
 * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entity_type_manager
 * The entity type manager.
 */
    public function __construct(EntityTypeManagerInterface $entity_type_manager)
    {
        $this->entityTypeManager = $entity_type_manager;
    }

/**
 * {@inheritdoc}
 */
   /**
* {@inheritdoc}
*/
public function processItem($data) {
// Implement your custom processing logic here.
// This method will be called for each item in the queue.

// Example: Updating an entity field value.
$entity = $this->entityTypeManager->getStorage('node')->load($data['nid']);
$entity->set('field_status', 'processed');
$entity->save();

// Batch processing.
$batch = [
'operations' => [
[[get_class($this), 'processItem'], [$data]],
],
'finished' => [get_class($this), 'finishedCallback'],
'title' => t('Processing queue items...'),
'init_message' => t('Starting processing...'),
'progress_message' => t('Processed @current out of @total.'),
];

batch_set($batch);
}

/**
* Batch processing finished callback.
*/
public static function finishedCallback($success, $results, $operations) {
if ($success) {
// Batch processing completed successfully.
// Perform any additional actions here.
}
else {
// Batch processing failed.
// Log or handle errors here.
}
}
}
