<?php

namespace App\Http\Controllers\Group;

use App\Group;
use App\Http\Controllers\Controller;

class ProfileIndexController extends Controller
{
    /**
     * Display a listing of the group's members and links to their profiles.
     *
     * @param Group $group
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Group $group)
    {
        $this->authorize('participate', $group);

        $members = $group->members()
            ->with('user', 'commitments', 'objectives')
            ->paginate();

        return view('groups.profiles.index', compact('group', 'members'));
    }
}
