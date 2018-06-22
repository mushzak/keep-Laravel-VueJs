<?php

namespace App\Http\Controllers\ManageGroup;

use App\Group;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EditController extends Controller
{
    /**
     * Show the form for managing the specified group.
     *
     * @param Group $group
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Group $group)
    {
        $this->authorize('facilitate', $group);

        return view('manage-group.edit', compact('group'));
    }
}
