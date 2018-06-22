<?php

namespace App\Listeners;

use App\Events\ReplyCreated;
use App\Group;
use App\Notifications\MentionedInReplyNotification;

class TagNotifiedUsersInReply
{
    /**
     * Handle the event.
     *
     * @param  ReplyCreated  $event
     * @return void
     */
    public function handle(ReplyCreated $event)
    {
        if ($event->reply->discussion->target instanceof Group) {
            // For each user in the group, see if they have been mentioned.
            // If so, send them a notification.
            $users = $event->reply->discussion->target->users;

            foreach ($users as $user) {
                if (str_contains($event->reply->body, "@{$user->name}")) {
                    $user->notify(new MentionedInReplyNotification($event->reply));
                }
            }
        }
    }
}
