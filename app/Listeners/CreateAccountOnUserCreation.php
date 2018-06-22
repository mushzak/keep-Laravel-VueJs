<?php

namespace App\Listeners;

use App\Account;
use App\Group;
use App\Member;
use Illuminate\Auth\Events\Registered;

class CreateAccountOnUserCreation
{
    /**
     * Handle the event.
     *
     * @param  \Illuminate\Auth\Events\Registered  $event
     * @return void
     */
    public function handle(Registered $event)
    {
        $account = Account::create([
            'manager_id' => $event->user->id,
            'name' => $event->user->name,
        ]);

        $group = Group::create([
            'account_id' => $account->id,
            'facilitator_id' => $event->user->id,
            'name' => $event->user->name . " Group",
        ]);

        Member::create([
            'group_id' => $group->id,
            'user_id' => $event->user->id,
        ]);
    }
}
