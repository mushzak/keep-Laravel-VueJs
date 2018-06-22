<?php

namespace App\Listeners;

use App\Events\DiscussionCreated;
use App\Group;
use App\Notifications\MentionedInDiscussionNotification;

class TagNotifiedUsersInDiscussion
{
    /**
     * Handle the event.
     *
     * @param  DiscussionCreated  $event
     * @return void
     */
    public function handle(DiscussionCreated $event)
    {
        if ($event->discussion->target instanceof Group) {
            // For each user in the group, see if they have been mentioned.
            // If so, send them a notification.
            $users = $event->discussion->target->users;

            foreach ($users as $user) {
                if (str_contains($event->discussion->body, "@{$user->name}")) {
                    $user->notify(new MentionedInDiscussionNotification($event->discussion));
                }
            }
        }
    }
}
