<?php

namespace App\Policies;

use App\User;
use App\Group;
use Illuminate\Auth\Access\HandlesAuthorization;

class GroupPolicy
{
    use HandlesAuthorization;

    /**
     * Determine if the user can facilitate the group
     *
     * @param User $user
     * @param Group $group
     * @return boolean
     */
    public function facilitate(User $user, Group $group)
    {
        return $user->id === $group->facilitator_id;
    }

    /**
     * Determine if the user can facilitate the group
     *
     * @param User $user
     * @param Group $group
     * @return boolean
     */
    public function manage(User $user, Group $group)
    {
        return $user->id === $group->account->manager->id;
    }

    /**
     * Determine if the user can participate (is a member within) the group
     *
     * @param User $user
     * @param Group $group
     * @return boolean
     */
    public function participate(User $user, Group $group)
    {
        return $group->users->contains($user);
    }
}
