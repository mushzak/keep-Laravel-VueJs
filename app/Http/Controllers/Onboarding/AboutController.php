<?php

namespace App\Http\Controllers\Onboarding;

use App\Member;
use App\Http\Controllers\Controller;

class AboutController extends Controller
{
    /**
     * @return \Illuminate\Http\Response
     */
    public function __invoke()
    {
        $member = Member::byGroupUser(auth()->user()->activeGroup, auth()->user())
            ->with('user')
            ->firstOrFail();

        return view('onboarding.about', compact('member'));
    }
}
