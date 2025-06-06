<?php

namespace Drupal\custom_events_and_subscribers\EventSubscriber;

use Drupal\custom_events_and_subscribers\Event\UserLoginEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class UserLoginSubscriber implements EventSubscriberInterface
{

    /**
     * @inheritdoc
     */
    public static function getSubscribedEvents()
    {
        return [
            UserLoginEvent::EVENT_NAME => 'onUserLogin',
        ];
    }

    /**
     * subscribe to the user login event Dispatched.
     */
    public function onUserLogin(UserLoginEvent $event)
    {

        $database = \Drupal::database();
        $dateFormatter = \Drupal::service('date.formatter');
        $current_user = \Drupal::currentUser();
        $current_user_roles = $current_user->getRoles();



        $account_created = $database->select('users_field_data', 'ud')
            ->fields('ud', ['created'])
            ->condition('ud.uid', $event->account->id())
            ->execute()
            ->fetchField();

        // Get user roles (excluding 'authenticated').
$roles = array_diff($event->account->getRoles(), ['authenticated']);
$role_names = empty($roles) ? 'No special roles' : implode(', ', $roles);

// Show message.
\Drupal::messenger()->addStatus(t('Welcome! Your account was created on @created_date. Roles: @roles', [
    '@created_date' => $dateFormatter->format($account_created, 'short'),
    '@roles' => $role_names,
]));


    }
}
