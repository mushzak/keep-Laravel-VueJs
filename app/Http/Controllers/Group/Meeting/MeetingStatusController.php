<?php

namespace App\Http\Controllers\Group\Meeting;

use App\Meeting;
use App\Http\Controllers\Controller;

class MeetingStatusController extends Controller
{
    /**
     * Advance the meeting agenda.
     *
     * @param  \App\Meeting  $meeting
     * @return \Illuminate\Http\Response
     */
    public function update(Meeting $meeting)
    {
        $meeting->advanceAgenda()->save();

        return response([], 204);
    }

    /**
     * Rollback the meeting agenda.
     *
     * @param  \App\Meeting  $meeting
     * @return \Illuminate\Http\Response
     */
    public function destroy(Meeting $meeting)
    {
        $meeting->rollbackAgenda()->save();

        return response([], 204);
    }
}
