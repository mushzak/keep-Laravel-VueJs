<?php

namespace App\Jobs;

use App\Meeting;
use App\Notifications\MeetingParticipantsNotification;
use App\Participant;
use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;

class NotifyFacilitatorOfMeetingParticipants
{
    use Dispatchable, Queueable;

    /**
     * For each meeting that needs it, this will send a list of participants who have not yet responded to a meeting
     * invite to the group's facilitator.
     *
     * @return void
     */
    public function handle()
    {
        /** @var \Illuminate\Database\Eloquent\Collection $meetings */
        $meetings = Meeting::meetingParticipantNotificationNeeded()->get();

        foreach ($meetings as $meeting) {
            $participants = $meeting->participants()
                ->get();


            if ($participants->count()) {
                $accepted = $meeting
                                ->participants()
                                ->whereStatus(1)
                                ->get();
                $declined = $meeting
                                ->participants()
                                ->whereStatus(0)
                                ->where('updated_at','>','created_at')
                                ->get();

                $no_response = $meeting
                                ->participants()
                                ->whereStatus(0)
                                ->where('updated_at','=','created_at')
                                ->get();

                $meeting->group->facilitator->notify(
                    new MeetingParticipantsNotification($meeting, $accepted, $declined, $no_response)
                );
            }

            $meeting->update(['was_facilitator_notified_of_unaccepted' => true]);
        }
    }
}
