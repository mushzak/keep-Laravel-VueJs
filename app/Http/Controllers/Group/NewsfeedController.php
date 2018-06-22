<?php

namespace App\Http\Controllers\Group;

use App\Group;
use App\Member;
use App\Http\Controllers\Controller;

class NewsfeedController extends Controller
{
    /**
     * Display the member's news feed.
     *
     * @param  \App\Group $group
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Group $group)
    {
        $member = Member::whereGroupId($group->id)
            ->with('user')
            ->whereUserId(auth()->id())
            ->firstOrFail();

        return view('groups.newsfeed.index', compact('group', 'member'));
    }
}
