<?php

namespace App\Http\Controllers;

use App\Group;

class HomeController extends Controller
{
    /**
     * Redirect a user based on their status within the system.
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function __invoke()
    {
        // Redirect to login page if not authenticated.
        if ( ! auth()->check())
            return redirect()->route('login');

        // Or else, return an error if the user does not belong to any groups.
        if ( ! auth()->user()->groups()->whereNull('members.deleted_at')->count())
            return response()->view('static.no_group', [], 422);

        // Or else, redirect to the active group page if the user belongs to a group,
        // but does not have one active.
        if ( ! auth()->user()->active_group_id)
            return redirect()->route('active-group.index');

        // Or else, redirect to the active group's dashboard.
        $activeGroup = Group::findOrFail(auth()->user()->active_group_id);
        return redirect()->route('groups.member-dashboard', $activeGroup->slug);
    }
}
