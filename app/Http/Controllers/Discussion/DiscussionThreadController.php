<?php

namespace App\Http\Controllers\Discussion;

use App\Discussion;
use App\Group;
use App\Http\Controllers\Controller;
use App\Member;

class DiscussionThreadController extends Controller
{
    /**
     * Display a particular discussion thread
     *
     * @param Group $group
     * @param Discussion $discussion
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function __invoke(Group $group, Discussion $discussion)
    {
        $member = Member::byGroupUser($group, auth()->user())->firstOrFail();
        $members = $group->members;

        $discussion->load('author.user', 'replies.author.user');

        return view('groups.discussions.show', compact('group', 'member', 'members', 'discussion'));
    }
}
