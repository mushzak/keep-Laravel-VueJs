<?php

namespace App\Http\Controllers\Group;

use App\Group;
use App\Member;
use App\Http\Controllers\Controller;

class ViewFeedbackController extends Controller
{
    /**
     * Display the list of feedback.
     *
     * @param  \App\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Group $group)
    {
        $member = Member::whereGroupId($group->id)
            ->whereUserId(auth()->id())
            ->firstOrFail();

        $feedbacks = $member->feedbacks()->with(['member.user', 'qnas'])->get();

        return view('groups.feedback.index', compact('group', 'member', 'feedbacks'));
    }
}
