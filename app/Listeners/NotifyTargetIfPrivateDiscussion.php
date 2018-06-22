<?php

namespace App\Listeners;

use App\Events\DiscussionCreated;
use App\Member;
use App\Notifications\PrivateDiscussionNotification;
use App\User;

class NotifyTargetIfPrivateDiscussion
{
    /**
     * Handle the event.
     *
     * @param DiscussionCreated $event
     * @return void
     */
    public function handle(DiscussionCreated $event)
    {
        if ($event->discussion->target instanceof Member) {
            /** @var User $user */
            $user = $event->discussion->target->user;

            $user->notify(new PrivateDiscussionNotification($event->discussion));
        }
    }
}
