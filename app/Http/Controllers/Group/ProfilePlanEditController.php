<?php

namespace App\Http\Controllers\Group;

use App\Group;
use App\Http\Controllers\Controller;
use App\Member;

class ProfilePlanEditController extends Controller
{
    /**
     * Display the member's editable plan.
     *
     * @param Group $group
     * @param Member $member
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Group $group, Member $member)
    {
        $this->authorize('update', $member);

       $data = $member->load([
            'group',
            'commitments',
            'lastGoal.objectives',
            'openFlags',
        ]);
        return view('groups.profiles.plan.edit', compact('group', 'member'));
    }
}
