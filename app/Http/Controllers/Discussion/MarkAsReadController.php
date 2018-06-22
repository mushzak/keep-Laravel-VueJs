<?php

namespace App\Http\Controllers\Discussion;

use App\Discussion;
use App\Member;
use App\Http\Controllers\Controller;

class MarkAsReadController extends Controller
{
    /**
     * Display the form to create a group discussion.
     *
     * @param Discussion $discussion
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function __invoke(Discussion $discussion)
    {

        $member=auth()->user()->activeGroupMember;

        $discussion->beenReadBy()->syncWithoutDetaching([$member->id => ['updated_at' => \Carbon\Carbon::now()]] );

        return response([], 204);
    }
}
