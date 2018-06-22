<?php

namespace App\Http\Controllers\Member;

use App\Member;
use App\Objective;
use App\Http\Controllers\Controller;

class ObjectiveCompletedStatusController extends Controller
{
    /**
     * Toggle the completed status of an objective.
     *
     * @param Member $member
     * @param Objective $objective
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Member $member, Objective $objective)
    {
        if ($objective->completed()) {
            $objective->markAsIncomplete();
        } else {
            $objective->markAsComplete();
        }

        $objective->save();

        return response([], 204);
    }
}
