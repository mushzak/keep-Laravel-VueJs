<?php

namespace App\Listeners;

use App\Events\ParticipantDeleted;
use App\Notifications\ParticipantRemovedNotification;

class NotifyParticipantOfRemoval
{
    /**
     * Handle the event.
     *
     * @param  ParticipantDeleted  $event
     * @return void
     */
    public function handle(ParticipantDeleted $event)
    {
        $event->participant->member->user->notify(
            new ParticipantRemovedNotification($event->participant)
        );
    }
}
