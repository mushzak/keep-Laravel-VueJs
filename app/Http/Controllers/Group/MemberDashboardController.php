<?php

namespace App\Http\Controllers\Group;

use App\Group;
use App\Http\Controllers\Controller;
use App\Member;

class MemberDashboardController extends Controller
{
    /**
     * Show the member's dashboard
     *
     * @param Group $group
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Group $group)
    {
        $member = Member::byGroupUser($group, auth()->user())->firstOrFail();
        return view('dashboards.member', compact('group', 'member'));
    }
}
