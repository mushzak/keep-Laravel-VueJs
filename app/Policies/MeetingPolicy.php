<?php

namespace App\Policies;

use App\Group;
use App\Member;
use App\User;
use App\Meeting;
use Illuminate\Auth\Access\HandlesAuthorization;

class MeetingPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view an index of the meetings.
     *
     * @param  \App\User $user
     * @param  \App\Group $group
     * @return mixed
     */
    public function index(User $user, Group $group)
    {
        if ($user->id === $group->facilitator->id)
            return true;

        return Member::whereUserId($user->id)->whereGroupId($group->id)->exists();
    }

    /**
     * Determine whether the user can view the meeting.
     *
     * @param  \App\User $user
     * @param  \App\Meeting $meeting
     * @return mixed
     */
    public function view(User $user, Meeting $meeting)
    {
        if ($user->id === $meeting->group->facilitator->id)
            return true;

        return Member::whereUserId($user->id)->whereGroupId($meeting->group->id)->exists();
    }

    /**
     * Determine whether the user can schedule a new meeting.
     *
     * @param  \App\User $user
     * @param  \App\Group $group
     * @return mixed
     */
    public function create(User $user, Group $group)
    {
        if ($user->id === $group->facilitator->id)
            return true;

        return false;
    }

    /**
     * Determine whether the user can update the meeting.
     *
     * @param  \App\User $user
     * @param  \App\Meeting $meeting
     * @return mixed
     */
    public function update(User $user, Meeting $meeting)
    {
        if ($user->id === $meeting->group->facilitator->id)
            return true;

        return false;
    }

    /**
     * Determine whether the user can delete the meeting.
     *
     * @param  \App\User $user
     * @param  \App\Meeting $meeting
     * @return mixed
     */
    public function delete(User $user, Meeting $meeting)
    {
        return $this->update($user, $meeting);
    }
}
