<?php

namespace App\Http\Controllers\ManageGroup;

use App\Group;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ShowController extends Controller
{
    /**
     * Show the group profile.
     *
     * @param Group $group
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Group $group)
    {
        $this->authorize('participate', $group);

        return view('manage-group.show', compact('group'));
    }
}
