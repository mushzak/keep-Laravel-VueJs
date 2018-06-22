<?php

namespace App\Http\Controllers\ManageMembers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ListInvitedController extends Controller
{
    /**
     * @return \Illuminate\Http\Response
     */
    public function __invoke()
    {
        $group = auth()->user()->activeGroup;
        $this->authorize('facilitate', $group);

        $invites = $group->invites()->get();

        return view('manage-members.invites.index', compact('group', 'invites'));
    }
}
