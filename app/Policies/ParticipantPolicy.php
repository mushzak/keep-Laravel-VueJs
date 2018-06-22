<?php

namespace App\Policies;

use App\User;
use App\Participant;
use Illuminate\Auth\Access\HandlesAuthorization;

class ParticipantPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can respond to a meeting invitation, thereby changing
     * the status of the participant object.
     *
     * @param  \App\User  $user
     * @param  \App\Participant  $participant
     * @return mixed
     */
    public function respond(User $user, Participant $participant)
    {
        return $user->id === $participant->member->user->id;
    }
}
