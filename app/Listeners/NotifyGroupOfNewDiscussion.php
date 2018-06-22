<?php

namespace App\Listeners;

use App\Events\DiscussionCreated;
use App\Notifications\DiscussionWasCreatedNotification;

class NotifyGroupOfNewDiscussion
{
    /**
     * Handle the event.
     *
     * @param  DiscussionCreated  $event
     * @return void
     */

    public function handle(DiscussionCreated $event)
    {
        $event->discussion
            ->author
            ->group
            ->users
            ->each
            ->notify(
                new DiscussionWasCreatedNotification($event->discussion)
            );
    }
}
