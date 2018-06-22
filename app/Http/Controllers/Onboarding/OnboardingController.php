<?php

namespace App\Http\Controllers\Onboarding;

use App\Http\Controllers\Controller;
use App\Member;

class OnboardingController extends Controller
{
    /**
     * Redirect to the member's currently active onboarding step.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function __invoke()
    {
        $member = Member::byGroupUser(auth()->user()->activeGroup, auth()->user())->firstOrFail();

        switch ($member->onboarding_step) {
            case Member::ONBOARDING_VERIFY: return redirect('/onboarding/verify');
            case Member::ONBOARDING_WELCOME: return redirect('/onboarding/welcome');
            case Member::ONBOARDING_ABOUT: return redirect('/onboarding/about');
            case Member::ONBOARDING_AGREEMENTS: return redirect('/onboarding/agreements');
            case Member::ONBOARDING_EXPECTATIONS: return redirect('/onboarding/expectations');
            default: return redirect('/');
        }
    }
}
