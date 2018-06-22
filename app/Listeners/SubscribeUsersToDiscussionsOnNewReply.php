<?php

namespace App\Listeners;

use App\Events\ReplyCreated;

class SubscribeUsersToDiscussionsOnNewReply
{
    /**
     * If you reply to a discussion, you become subscribed to it.
     *
     * @param  ReplyCreated  $event
     * @return void
     */
    public function handle(ReplyCreated $event)
    {
        $event->reply->discussion->subscribe(
            $event->reply->author->user
        );
    }
}
