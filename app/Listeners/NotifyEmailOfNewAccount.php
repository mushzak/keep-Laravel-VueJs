<?php

namespace App\Listeners;

use App\Events\AccountCreated;
use App\Notifications\NotifyNewAccount;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotifyEmailOfNewAccount
{
    /**
     * Handle the event.
     *
     * @param  InviteCreated  $event
     * @return void
     */
    public function handle(AccountCreated $event)
    {
        $event->account->manager->notify(new NotifyNewAccount($event->account->manager));
    }
}
