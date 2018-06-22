<?php

namespace App\Listeners;

use App\Events\AccountCreated;

class CreateFlagsForNewAccount
{
    /**
     * Handle the event.
     *
     * @param  AccountCreated  $event
     * @return void
     */
    public function handle(AccountCreated $event)
    {
        $event->account->flags()->createMany([
            ['type' => 'account-updated-subscription'],
            ['type' => 'account-updated-branding'],
            ['type' => 'account-updated-contact'],
            ['type' => 'account-updated-security'],
        ]);

    }
}
