<?php

namespace App\Listeners;

use App\Events\GroupDeleting;

class DeleteMembers
{
    /**
     * Delete all members in the group.
     *
     * @param  GroupDeleting  $group
     * @return void
     */
    public function handle(GroupDeleting $event)
    {
        foreach ($event->group->members as $member) {
            $member->delete();
        }
    }
}
