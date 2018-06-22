<?php

namespace App\Http\Controllers\Onboarding;

use App\Member;
use App\Rules\PasswordMustMatchUser;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StoreAgreementController extends Controller
{
    public function __invoke(Request $request)
    {
        $request->validate([
            'password' => ['required', new PasswordMustMatchUser(auth()->user())],
        ]);

        $member = Member::byGroupUser(auth()->user()->activeGroup, auth()->user())
            ->with('user')
            ->firstOrFail();

        $member->update([
            'onboarding_step' => Member::ONBOARDING_EXPECTATIONS,
        ]);

        flash()->success('You have agreed to the group terms and conditions.');
        return $this->route('onboarding');
    }
}
