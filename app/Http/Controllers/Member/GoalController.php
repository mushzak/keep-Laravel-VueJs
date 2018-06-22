<?php

namespace App\Http\Controllers\Member;

use App\Goal;
use App\Member;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class GoalController extends Controller
{
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Member $member
     * @param  \App\Goal $goal
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Member $member, Goal $goal)
    {
        $goal->update(
            $request->validate([
                'name' => 'nullable',
            ])
        );

        $member->performAndResolve('updated-goals-and-objectives');

        return response([], 204);
    }
}
