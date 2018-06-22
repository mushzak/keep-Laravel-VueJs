<?php

namespace App\Http\Controllers\Group;

use App\Group;
use App\Member;
use App\Http\Controllers\Controller;

class PlanController extends Controller
{
    /**
     * Allow the member to affirm their plan.
     *
     * @param  \App\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Group $group)
    {
        $this->authorize('participate', $group);

        $member = Member::whereGroupId($group->id)
            ->whereUserId(auth()->id())
            ->firstOrFail();

        return view('groups.plan.index', compact('group', 'member'));
    }
}
