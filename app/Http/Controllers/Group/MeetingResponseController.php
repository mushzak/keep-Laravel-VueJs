<?php

namespace App\Http\Controllers\Group;

use App\Participant;
use App\Http\Controllers\Controller;

class MeetingResponseController extends Controller
{
    /**
     * The user accepted the meeting invitation.
     *
     * @param Participant $participant
     * @return \Illuminate\Http\RedirectResponse
     */
    public function accept(Participant $participant)
    {
        $this->authorize('respond', $participant);

        $participant->update([
            'status' => Participant::ACCEPTED,
        ]);

        flash()->success("You have accepted the meeting invite.");

        return redirect()->route('groups.meetings.show', [
            $participant->member->group->slug, $participant->meeting->id
        ]);
    }

    /**
     * The user rejected the meeting invitation.
     *
     * @param Participant $participant
     * @return \Illuminate\Http\RedirectResponse
     */
    public function reject(Participant $participant)
    {
        $this->authorize('respond', $participant);

        $participant->update([
            'status' => Participant::REJECTED,
        ]);

        flash()->success("You have rejected the meeting invite.");

        return redirect()->route('groups.meetings.show', [
            $participant->member->group->slug, $participant->meeting->id
        ]);
    }
}
