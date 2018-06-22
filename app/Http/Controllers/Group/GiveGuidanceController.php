<?php

namespace App\Http\Controllers\Group;

use App\Group;
use App\Member;
use App\Http\Controllers\Controller;

class GiveGuidanceController extends Controller
{
    /**
     * Allow the member to give guidance.
     *
     * @param  \App\Group $group
     * @param  \App\Member $member
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Group $group, Member $member)
    {
        $goal = $member
            ->goals()
            ->topLevelOnly()
            ->with('objectives')
            ->first();

        $process = $group->processes()->firstOrFail();

        $steps = $process
            ->processSteps()
            ->with(['records.comments' => function ($query) {
                $query->orderBy('id', 'desc');
            }])
            ->with('records.comments.author.user')
            ->with(['records' => function ($query) use ($group, $member) {
                $query
                    ->where('current_process', $group->current_process)
                    ->where('member_id', $member->id)
                    ->orderBy('id', 'desc');
            }])
            ->orderBy('id', 'desc')
            ->get();

        $members = $group->members()->get();

        return view('groups.members.guidance.create', compact('group', 'member', 'members', 'goal', 'steps'));
    }
}
