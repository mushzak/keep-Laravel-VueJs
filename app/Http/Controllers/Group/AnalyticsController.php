<?php

namespace App\Http\Controllers\Group;

use App\Group;
use App\Http\Controllers\Controller;
use App\Member;

class AnalyticsController extends Controller
{
    /**
     * Display the member's analytical information.
     *
     * @param Group $group
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Group $group)
    {
        $member = Member::byGroupUser($group, auth()->user())->firstOrFail();

        return view('groups.analytics.index', compact('group', 'member'));
    }
}
