<?php

namespace App\Listeners;

use App\Events\MeetingDeleted;

class DeleteParticipants
{
    /**
     * Delete all participants of the meeting.
     *
     * @param  MeetingDeleted  $event
     * @return void
     */
    public function handle(MeetingDeleted $event)
    {
        foreach ($event->meeting->participants as $participant) {
            $participant->delete();
        }
    }
}
