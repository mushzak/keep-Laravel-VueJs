<?php

namespace App\Jobs;

use App\Meeting;
use App\Notifications\UpcomingMeetingNotification;
use App\Participant;
use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;

class NotifyActiveParticipantsOfMeeting
{
    use Dispatchable, Queueable;

    /**
     * For each meeting that needs it, this will send a reminder notification to all participants about the upcoming
     * meeting.
     *
     * @return void
     */
    public function handle()
    {
        /** @var \Illuminate\Database\Eloquent\Collection $meetings */
        $meetings = Meeting::reminderNotificationNeeded()
            ->with(['participants' => function ($query) {
                return $query->where('status', '!=', Participant::REJECTED);
            }])
            ->get();

        /** @var Meeting $meeting */
        foreach ($meetings as $meeting) {
            /** @var Participant $participant */
            foreach ($meeting->participants as $participant) {
                $participant->member->user->notify(
                    new UpcomingMeetingNotification($participant)
                );
            }

            $meeting->update(['was_participants_reminded' => true]);
        }
    }
}
