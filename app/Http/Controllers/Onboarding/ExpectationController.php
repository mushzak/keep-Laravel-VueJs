<?php

namespace App\Http\Controllers\Onboarding;

use App\Http\Controllers\Controller;
use App\Member;

class ExpectationController extends Controller
{
    /**
     * @return \Illuminate\Http\Response
     */
    public function __invoke()
    {
        $member = Member::byGroupUser(auth()->user()->activeGroup, auth()->user())
            ->with('user')
            ->firstOrFail();

        $questions = $member->group->questions()->where('when_asked', 'onboarding')->get();

        return view('onboarding.expectations', compact('member', 'questions'));
    }
}
