<?php

namespace App\Listeners;

use App\Channel;
use App\Events\DiscussionCreated;
use App\Group;
use App\Notifications\UrgentDiscussionNotification;
use App\User;

class NotifyTargetsIfUrgentDiscussion
{
    /**
     * Handle the event.
     *
     * @param  DiscussionCreated $event
     * @return void
     */
    public function handle(DiscussionCreated $event)
    {
        if ($event->discussion->is_urgent) {
            if ($event->discussion->target instanceof Member) {
                /** @var User $user */
                $user = $event->discussion->target->user;

                $user->notify(new UrgentDiscussionNotification($event->discussion));
            } elseif ($event->discussion->target instanceof Group) {
                foreach ($event->discussion->target->members as $member) {
                    /** @var User $user */
                    $user = $member->user;

                    $user->notify(new UrgentDiscussionNotification($event->discussion));
                }
            }
        }
    }
}
