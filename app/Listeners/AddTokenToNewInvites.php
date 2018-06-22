<?php

namespace App\Listeners;

use App\Events\InviteCreating;

class AddTokenToNewInvites
{
    /**
     * Handle the event.
     *
     * @param  InviteCreating  $event
     * @return void
     */
    public function handle(InviteCreating $event)
    {
        $event->invite->token = str_random(50);
    }
}
