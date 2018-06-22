<?php

namespace App\Policies;

use App\Discussion;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class DiscussionPolicy
{
    use HandlesAuthorization;

    /**
     * Determine if the user can participate in a discussion
     *
     * @param User $user
     * @param Discussion $discussion
     * @return boolean
     */
    public function participate(User $user, Discussion $discussion)
    {
        return true;
    }
}
