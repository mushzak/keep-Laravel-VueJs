<?php

namespace App\Http\Controllers\Member;

use App\Goal;
use App\Objective;
use App\Member;
use App\Rules\Datetime;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Carbon;

class ObjectiveController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Member  $member
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Member $member)
    {
        /** @var Goal $lastGoal */
        $lastGoal = $member->lastGoal()->firstOrFail();

        $input = $request->validate([
            'name' => 'required',
            'due_at' => ['required', new Datetime],
        ]);

        $lastGoal->objectives()->create([
            'name' => $input['name'],
            'due_at' => Carbon::createFromTimeStampUTC(strtotime($input['due_at'])),
        ]);

        $member->performAndResolve('updated-goals-and-objectives');

        return response([], 204);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Member  $member
     * @param  \App\Objective  $objective
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Member $member, Objective $objective)
    {
        $input = $request->validate([
            'name' => 'required',
            'due_at' => ['required', new Datetime],
        ]);

        $objective->update([
            'name' => $input['name'],
            'due_at' => Carbon::createFromTimeStampUTC(strtotime($input['due_at'])),
        ]);

        $member->performAndResolve('updated-goals-and-objectives');

        return response()->json(['member'=>$member,'objective_new' => $objective]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Member  $member
     * @param  \App\Objective  $objective
     * @return \Illuminate\Http\Response
     */
    public function destroy(Member $member, Objective $objective)
    {
        $objective->delete();
        $member->performAndResolve('updated-goals-and-objectives');
        return response([], 204);
    }
}
