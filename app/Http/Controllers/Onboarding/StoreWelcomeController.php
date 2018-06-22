<?php

namespace App\Http\Controllers\Onboarding;

use App\Member;
use App\Http\Controllers\Controller;

class StoreWelcomeController extends Controller
{
    /**
     * Stores the fact that the user saw this page and advances them.
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke()
    {
        $member = Member::byGroupUser(auth()->user()->activeGroup, auth()->user())
            ->with('user')
            ->firstOrFail();

        $member->update([
            'onboarding_step' => Member::ONBOARDING_ABOUT,
        ]);

        flash()->success('You have completed the welcoming phase of your onboarding.');
        return $this->route('onboarding');
    }
}
