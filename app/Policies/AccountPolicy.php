<?php

namespace App\Policies;

use App\User;
use App\Account;
use Illuminate\Auth\Access\HandlesAuthorization;

class AccountPolicy
{
    use HandlesAuthorization;

    /**
     * Determine if the user can manage the account
     *
     * @param User $user
     * @param Account $account
     * @return boolean
     */
    public function manage(User $user, Account $account)
    {
        return $user->id === $account->manager->id;
    }
}
