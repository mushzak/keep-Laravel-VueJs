<?php

namespace App\Http\Controllers\Member;

use App\Commitment;
use App\Member;
use App\Http\Controllers\Controller;

class CommitmentCompletedStatusController extends Controller
{
    /**
     * Toggle the completed status of an objective.
     *
     * @param Member $member
     * @param Commitment $commitment
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Member $member, Commitment $commitment)
    {
        if ($commitment->completed()) {
            $commitment->markAsIncomplete();
        } else {
            $commitment->markAsComplete();
        }

        $commitment->save();

        return response([], 204);
    }
}
