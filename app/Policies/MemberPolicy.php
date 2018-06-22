<?php

namespace App\Policies;

use App\User;
use App\Member;
use Illuminate\Auth\Access\HandlesAuthorization;

class MemberPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the member.
     *
     * @param  \App\User  $user
     * @param  \App\Member  $member
     * @return mixed
     */
    public function view(User $user, Member $member)
    {
        return true;
    }

    /**
     * Determine whether the user can update the member.
     *
     * @param  \App\User  $user
     * @param  \App\Member  $member
     * @return mixed
     */
    public function update(User $user, Member $member)
    {
        if ($member->user->id == $user->id)
            return true;

        return false;
    }
}
