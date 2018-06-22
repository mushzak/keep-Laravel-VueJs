<?php

namespace App\Listeners;

use App\Events\MemberCreated;

class AddDefaultValuesForNewMember
{
    /**
     * When a new member is created, populate default values
     *
     * @param  MemberCreated  $event
     * @return void
     */
    public function handle(MemberCreated $event)
    {
        
        //create default what We are About / expectations
        $event->member->commitments()->create([
                    'name' => 'Describe a task that you plan to complete before the next meeting.',
                    'ask' => 'Describe an issue or obstacle meeting your objectives.',
                    'backstory' => 'Provide details about the past week.',
                    'outcome' => 'Describe your attempt to complete the commitment.',
                    'process_number' => $event->member->group->current_process,
                ]);


        
    }
}