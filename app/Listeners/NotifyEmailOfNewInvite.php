<?php

namespace App\Listeners;

use App\Events\InviteCreated;
use App\Notifications\NotifyNewInvite;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotifyEmailOfNewInvite
{
    /**
     * Handle the event.
     *
     * @param  InviteCreated  $event
     * @return void
     */
    public function handle(InviteCreated $event)
    {
        $event->invite->notify(new NotifyNewInvite());
    }
}
