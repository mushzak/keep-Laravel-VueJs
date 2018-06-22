<?php

namespace App\Http\Controllers\Discussion;

use App\Group;
use App\Http\Controllers\Controller;

class SearchUserController extends Controller
{
    /**
     * Show group members.
     *
     * @param Group $group
     * @return \Illuminate\Http\Response
     */
    public function __invoke($group)
    {
        $groupObj = Group::find($group);
        $users = $groupObj->members()->with('user')->get();
        return response()->json(['data' => $users]);
    }
}
