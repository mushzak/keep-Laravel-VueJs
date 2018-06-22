<?php

namespace App\Http\Controllers;

use App\Group;

class ActiveGroupController extends Controller
{
    /**
     * Display a listing of different groups the user belongs to.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $groups = auth()->user()->groups()->whereNull('members.deleted_at')->with('facilitator')->get();

        return view('active-group.index', compact('groups'));
    }

    /**
     * Set the user's current active group.
     *
     * @param  \App\Group  $activeGroup
     * @return \Illuminate\Http\Response
     */
    public function update(Group $activeGroup)
    {
        $this->authorize('participate', $activeGroup);

        auth()->user()->update(['active_group_id' => $activeGroup->id]);

        flash()->success('Your active group has successfully been changed.');
        return $this->route('home');
    }
}
