<?php

namespace App\Http\Controllers\Onboarding;

use App\Feedback;
use App\Http\Controllers\Controller;
use App\Member;
use Illuminate\Http\Request;

class StoreExpectationController extends Controller
{
    /**
     * @param Request $request
     * @return string
     */
    public function __invoke(Request $request)
    {
        $member = Member::byGroupUser(auth()->user()->activeGroup, auth()->user())
            ->with('user')
            ->firstOrFail();

        $input = $request->validate([
            'feedback' => 'required|array',
            'feedback.*' => 'required',
            'rating.*' => 'required|min:1|max:10',
        ]);

        foreach ($input['feedback'] as $key => $feedbackContent) {
            $rating = $input['rating'][$key] ?? null;

            Feedback::updateOrCreate(
                ['member_id' => $member->id, 'question_id' => $key],
                ['content' => $feedbackContent, 'rating' => $rating]
            );
        }

        $member->update([
            'onboarding_step' => Member::ONBOARDED,
        ]);

        flash()->success('You have been onboarded.');
        return $this->route('onboarding');
    }
}
