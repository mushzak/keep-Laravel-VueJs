<?php

namespace App\Http\Controllers\Group\Meeting;

use App\Participant;
use App\Meeting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ParticipantController extends Controller
{
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Meeting  $meeting
     * @param  \App\Participant  $participant
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Meeting $meeting, Participant $participant)
    {
        $this->authorize('facilitate', $meeting->group);

        $participant->update(
            $request->validate([
                'is_present' => 'required|boolean',
            ])
        );

        return response([], 204);
    }
}
