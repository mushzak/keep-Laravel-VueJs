<?php

namespace App\Http\Controllers\Group;

use App\Group;
use App\Member;
use App\Http\Controllers\Controller;

class ProfileEditController extends Controller
{
    /**
     * Display the member's editable.
     *
     * @param Group $group
     * @param Member $member
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Group $group, Member $member)
    {
        $this->authorize('update', $member);

        $member->load([
            'group',
            'commitments',
            'lastGoal.objectives',
        ]);

        return view('groups.profiles.edit', compact('group', 'member'));
    }
}
