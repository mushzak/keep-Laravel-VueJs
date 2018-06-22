<?php

namespace App\Listeners;

use App\Events\ParticipantCreated;
use App\Notifications\ParticipantAddedNotification;

class NotifyParticipantOfInvite
{
    /**
     * Handle the event.
     *
     * @param  ParticipantCreated  $event
     * @return void
     */
    public function handle(ParticipantCreated $event)
    {
        $event->participant->member->user->notify(
            new ParticipantAddedNotification($event->participant)
        );
    }
}
