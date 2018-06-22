<?php

namespace App\Listeners;

use App\Events\MeetingCreated;

class CreateDiscussionForNewMeeting
{
    /**
     * Handle the event.
     *
     * @param  MeetingCreated  $event
     * @return void
     */
    public function handle(MeetingCreated $event)
    {
        $event->meeting->discussion()->create([
            'title' => $event->meeting->subject,
            'body' => '(discussion generated automatically for meeting)',
        ]);
    }
}
