<?php

namespace App\Http\Controllers\Member;

use App\Member;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Carbon;

/**
 * @deprecated
 */
class OnboardingController extends Controller
{
    public function start()
    {
        $member=Member::byGroupUser(auth()->user()->active_group_id, auth()->user())->firstOrFail();
        $step=1;
        return view('members.onboarding.step_1', compact( 'member','step'));
    }

    public function step_1(Request $request, Member $member)
    {
        $step=1;
        return view('members.onboarding.step_1', compact( 'member','step'));
    }


    public function step_2(Request $request, Member $member)
    {
    	$step=2;
       	return view('members.onboarding.step_2', compact( 'member','step'));
    }

    public function step_what_to_expect(Request $request, Member $member)
    {
    	$step=3;
       	return view('members.onboarding.step_what_to_expect', compact( 'member','step'));
    }

    public function step_shared_expectations(Request $request, Member $member)
    {
       	$step=4;
       	return view('members.onboarding.step_shared_expectations', compact( 'member','step'));
    }

    public function step_survey(Request $request, Member $member)
    {
       	$step=5;
       	return view('members.onboarding.step_survey', compact( 'member','step'));
    }

    public function finished(Request $request, Member $member)
    {
        $step=6;
        return redirect('/');
    }




    public function step_1update(Request $request, Member $member)
    {
       //
    }
}