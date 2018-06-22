<?php

namespace App\Listeners;

use App\Events\GroupCreated;

class AddDefaultValuesForNewGroup
{
    /**
     * When a new group is created, populate default values
     *
     * @param  GroupCreated  $event
     * @return void
     */
    public function handle(GroupCreated $event)
    {
        
        //create default what We are About / expectations
        $event->group->expectations()->create([
                    'content' => 'Our group is about working together to reach our goals.',
                ]);


        //create default Agreements
        $event->group->agreements()->create([
                    'content' => 'Each member agrees to provide respectful, informative feedback.',
                ]);
        $event->group->agreements()->create([
                    'content' => 'Each member agrees to attend 80% of all meetings.',
                ]);

        $event->group->agreements()->create([
                    'content' => 'Each member agrees informaion is confidential. Information discussed during these meetings should not be disclosed to non-members.',
                ]);


        //create default Feedback
        $event->group->questions()->create([
                    'content' => 'Why did you join this group?',
                    'has_rating' => 0,
                    'when_asked' => 'onboarding',
                ]);

        $event->group->questions()->create([
                    'content' => 'What do you expect as an outcome of participating in this group?',
                    'has_rating' => 0,
                    'when_asked' => 'onboarding',
                ]);
        $event->group->questions()->create([
                    'content' => 'Overall how do you feel about the group?',
                    'has_rating' => 1,
                    'when_asked' => 'onboarding',
                ]);

    }
}