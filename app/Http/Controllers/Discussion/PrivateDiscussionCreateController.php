<?php

namespace App\Http\Controllers\Discussion;

use App\Http\Controllers\Controller;
use App\Member;

class PrivateDiscussionCreateController extends Controller
{
    /**
     * Display the form to create a private discussion.
     *
     * @param Member $member
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function __invoke(Member $member)
    {
        $group = $member->group;

        return view('groups.discussions.member-create', compact('group', 'member'));
    }
}
