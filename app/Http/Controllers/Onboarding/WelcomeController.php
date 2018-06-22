<?php

namespace App\Http\Controllers\Onboarding;

use App\Member;
use App\Http\Controllers\Controller;

class WelcomeController extends Controller
{
    /**
     * Returns the welcome page within onboarding.
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke()
    {
        $member = Member::byGroupUser(auth()->user()->activeGroup, auth()->user())
            ->with('user')
            ->firstOrFail();

        return view('onboarding.welcome', compact('member'));
    }
}
