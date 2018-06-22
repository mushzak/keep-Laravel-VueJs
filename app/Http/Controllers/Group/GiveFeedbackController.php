<?php

namespace App\Http\Controllers\Group;

use App\Group;
use App\Http\Controllers\Controller;
use App\Member;

class GiveFeedbackController extends Controller
{
    /**
     * Show the give feedback page.
     *
     * @param  \App\Group $group
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Group $group)
    {
        $questions = $group->questions;

        $member = Member::byGroupUser(auth()->user()->activeGroup, auth()->user())
            ->with('user')
            ->firstOrFail();

        return view('groups.feedback.index', compact('group', 'member', 'questions'));
    }
}
