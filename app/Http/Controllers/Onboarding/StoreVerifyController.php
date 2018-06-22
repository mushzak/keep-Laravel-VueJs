<?php

namespace App\Http\Controllers\Onboarding;

use App\Member;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StoreVerifyController extends Controller
{
    /**
     * Save the verify fields and move onto the next step of onboarding.
     *
     * @param Request $request
     * @return string
     */
    public function __invoke(Request $request)
    {
        $member = Member::byGroupUser(auth()->user()->activeGroup, auth()->user())
            ->with('user')
            ->firstOrFail();

        $input = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'text_phone' => ['nullable', 'regex:/^[0-9 \(\)\-]+$/'],
            'is_using_2fa' => 'required|boolean',
        ], [
            'text_phone.regex' => 'You must provide a phone number.'
        ]);

        $member->update([
            'email' => $input['email'],
            'onboarding_step' => Member::ONBOARDING_WELCOME,
        ]);

        $member->user->update([
            'name' => $input['name'],
            'text_phone' => $input['text_phone'],
            'is_using_2fa' => $input['is_using_2fa'],
        ]);

        flash()->success('You have completed the verification phase of your onboarding.');
        return $this->route('onboarding');
    }
}
