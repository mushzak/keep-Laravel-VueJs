<?php

namespace App\Listeners;

use App\Events\MeetingEnded;

class NotifyParticipantsOfMeetingSummary
{
    /**
     * Handle the event.
     *
     * @param  MeetingEnded  $event
     * @return void
     */
    public function handle(MeetingEnded $event)
    {
        //
    }
}
