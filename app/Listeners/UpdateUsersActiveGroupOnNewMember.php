<?php

namespace App\Listeners;

use App\Events\MemberCreated;

class UpdateUsersActiveGroupOnNewMember
{
    /**
     * When a new membership is created, update that member's user to set the new membership
     * as the active group.
     *
     * @param  MemberCreated  $event
     * @return void
     */
    public function handle(MemberCreated $event)
    {
        $event->member->user->update([
            'active_group_id' => $event->member->group_id,
        ]);
    }
}
