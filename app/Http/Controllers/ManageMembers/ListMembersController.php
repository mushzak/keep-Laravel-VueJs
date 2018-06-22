<?php

namespace App\Http\Controllers\ManageMembers;

use App\Http\Controllers\Controller;

class ListMembersController extends Controller
{
    /**
     * Show the form for managing the list of members
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke()
    {
        $group = auth()->user()->activeGroup;
        $this->authorize('facilitate', $group);

        $members = $group->members()
            ->with('user', 'group')
            ->get();

        return view('manage-members.index', compact('members'));
    }
}
