<?php

namespace App\Http\Controllers\Discussion;

use App\Group;
use App\Http\Controllers\Controller;

class GroupDiscussionCreateController extends Controller
{
    /**
     * Display the form to create a group discussion.
     *
     * @param Group $group
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function __invoke(Group $group)
    {
        return view('groups.discussions.group-create', compact('group'));
    }
}
