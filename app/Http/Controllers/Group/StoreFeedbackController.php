<?php

namespace App\Http\Controllers\Group;

use App\Feedback;
use App\Group;
use App\Member;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StoreFeedbackController extends Controller
{
    /**
     * Show the give feedback page.
     *
     * @param Request $request
     * @param  \App\Group $group
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, Group $group)
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

        flash()->success('You have provided your feedback.');
        return $this->route('groups.give-feedback', $group->slug);
    }
}
