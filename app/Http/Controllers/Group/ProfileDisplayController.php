<?php

namespace App\Http\Controllers\Group;

use App\Group;
use App\Http\Controllers\Controller;
use App\Member;

class ProfileDisplayController extends Controller
{
    /**
     * Display the member's profile.
     *
     * @param Group $group
     * @param Member $member
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Group $group, Member $member)
    {
        $this->authorize('participate', $group);

        $member->load(['user','lastGoal.objectives']);

        return view('groups.profiles.show', compact('group', 'member'));
    }
}
