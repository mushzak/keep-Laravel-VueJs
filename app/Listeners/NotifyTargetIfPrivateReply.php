<?php

namespace App\Listeners;

use App\Events\ReplyCreated;
use App\Member;
use App\Notifications\PrivateReplyNotification;

class NotifyTargetIfPrivateReply
{
    /**
     * Handle the event.
     *
     * @param ReplyCreated $event
     * @return void
     */
    public function handle(ReplyCreated $event)
    {
        if ($event->reply->discussion->target instanceof Member) {
            /** @var User $user */
            $user = $event->reply->discussion->target->user;

            $user->notify(new PrivateReplyNotification($event->reply));
        }
    }
}
