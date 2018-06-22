<?php

namespace App\Http\Controllers\Onboarding;

use App\Http\Controllers\Controller;
use App\Member;

class StoreAboutController extends Controller
{
    public function __invoke()
    {
        $member = Member::byGroupUser(auth()->user()->activeGroup, auth()->user())
            ->with('user')
            ->firstOrFail();

        $member->update([
            'onboarding_step' => Member::ONBOARDING_AGREEMENTS,
        ]);

        flash()->success('You have acknowledged what the group is about.');
        return $this->route('onboarding');
    }
}
