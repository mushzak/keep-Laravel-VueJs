<?php

namespace App\Listeners;

use App\Invite;
use App\Member;
use \Illuminate\Auth\Events\Login;

class CheckSuccessfulLoginForInvites
{
    /**
     * Handle the event.
     *
     * @param  Login $event
     * @return void
     */
    public function handle(Login $event)
    {
        $invites = Invite::where('email', $event->user->email)->get();

        foreach ($invites as &$invite) {
            $invite->confirm(auth()->user());
        }
    }
}
