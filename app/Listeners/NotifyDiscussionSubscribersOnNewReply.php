<?php

namespace App\Listeners;

use App\Events\ReplyCreated;
use App\Notifications\DiscussionWasRepliedToNotification;
use Illuminate\Support\Facades\Cookie;

class NotifyDiscussionSubscribersOnNewReply
{
    /**
     * Handle the event.
     *
     * @param  ReplyCreated  $event
     * @return void
     */
    public function handle(ReplyCreated $event)
    {
        $cookieName = 'deny_'.$event->reply->discussion->id;

        if(isset($_COOKIE[$cookieName])) {
            // wait 30 minute
        }else{
            setcookie($cookieName,'deny',time()+1800,'/');
            $event->reply->discussion->subscribers()
                ->where('users.id', '!=', $event->reply->author_id)
                ->get()
                ->each
                ->notify(
                    new DiscussionWasRepliedToNotification($event->reply)
                );
        }
    }
}
