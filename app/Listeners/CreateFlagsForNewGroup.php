<?php

namespace App\Listeners;

use App\Events\GroupCreated;

class CreateFlagsForNewGroup
{
    /**
     * Handle the event.
     *
     * @param  GroupCreated  $event
     * @return void
     */
    public function handle(GroupCreated $event)
    {
        $event->group->flags()->createMany([
            ['type' => 'group-updated-expectations'],
            ['type' => 'group-updated-agreements'],
            ['type' => 'group-updated-feedback'],
            ['type' => 'group-updated-check-ins'],
            ['type' => 'group-updated-member-plan'],
            ['type' => 'group-updated-member-profile'],
            ['type' => 'group-updated-member-engagement'],
        ]);
    }
}
