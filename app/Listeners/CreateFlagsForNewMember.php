<?php

namespace App\Listeners;

use App\Events\MemberCreated;

class CreateFlagsForNewMember
{
    /**
     * Handle the event.
     *
     * @param  MemberCreated $event
     * @return void
     */
    public function handle(MemberCreated $event)
    {
        $event->member->flags()->createMany([
            ['type' => 'updated-action-plan'],
            ['type' => 'updated-goals-and-objectives'],
            ['type' => 'updated-big-picture'],
            ['type' => 'updated-personal-motivation'],
            ['type' => 'updated-personal-background'],
            ['type' => 'updated-professional-background'],
            ['type' => 'updated-contact-info'],
        ]);
    }
}