<?php

namespace App\Listeners;

use App\Events\ReplyCreated;
use App\Group;
use App\Member;
use App\Notifications\UrgentReplyNotification;

class NotifyTargetsIfUrgentReply
{
    /**
     * Handle the event.
     *
     * @param ReplyCreated $event
     * @return void
     */
    public function handle(ReplyCreated $event)
    {
        // If this reply is not urgent, do nothing.
        if ($event->reply->is_urgent == false)
            return;

        if ($event->reply->discussion->target instanceof Member) {
            /** @var User $user */
            $user = $event->discussion->target->user;

            $user->notify(new UrgentReplyNotification($event->reply));
        } elseif ($event->reply->discussion->target instanceof Group) {
            foreach ($event->reply->discussion->target->members as $member) {
                /** @var User $user */
                $user = $member->user;

                $user->notify(new UrgentReplyNotification($event->reply));
            }
        }
    }
}
