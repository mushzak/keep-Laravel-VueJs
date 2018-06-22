<?php

namespace App\Events;

use App\Account;
use Illuminate\Queue\SerializesModels;

class AccountCreated
{
    use SerializesModels;

    /** @var Account */
    public $account;

    /**
     * Create a new event instance.
     *
     * @param Account $account
     */
    public function __construct(Account $account)
    {
        $this->account = $account;
    }
}
