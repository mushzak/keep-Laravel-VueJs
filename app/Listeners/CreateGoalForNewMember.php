<?php

namespace App\Listeners;

use App\Events\MemberCreated;

class CreateGoalForNewMember
{
    /**
     * Handle the event.
     *
     * @param  MemberCreated  $event
     * @return void
     */
    public function handle(MemberCreated $event)
    {
        $event->member->goals()->create([
            'name' => 'Your first goal.',
        ]);
    }
}
