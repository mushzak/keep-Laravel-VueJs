<?php

namespace App\Http\Controllers\Group;

use App\Group;
use App\Member;
use App\Http\Controllers\Controller;

class ProfileController extends Controller
{
    /**
     * Display the member's profile.
     *
     * @param  \App\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Group $group)
    {
        $this->authorize('participate', $group);

        $member = Member::whereGroupId($group->id)
            ->whereUserId(auth()->id())
            ->with(['user','lastGoal.objectives'])
            ->firstOrFail();
 
        return view('groups.profile.index', compact('group', 'member'));
    }
}
