<?php

namespace App\Listeners;

use App\Member;
use Illuminate\Auth\Events\Login;

class BlockInactiveMembers
{
    /**
     * Handle the event.
     *
     * @param  Login  $event
     * @return void
     */
    public function handle(Login $event)
    {
        if (!$event->user->activeGroup)
            return;

        $member = Member::byGroupUser($event->user->activeGroup, $event->user)->first();

        if ($member && $member->status == 'inactivated') {
            auth()->logout();
            flash()->error('You have been marked as inactive by your group facilitator.');
        }
    }
}
