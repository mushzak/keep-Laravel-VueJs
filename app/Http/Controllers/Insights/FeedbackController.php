<?php

namespace App\Http\Controllers\Insights;

use App\Http\Controllers\Controller;

class FeedbackController extends Controller
{
    public function __invoke()
    {
        $this->authorize('facilitate', auth()->user()->activeGroup);

        $group = auth()->user()->activeGroup;

        $feedback = auth()->user()->activeGroup->feedback;

        $average = auth()->user()->activeGroup->feedback()
            ->whereNotNull('rating')
            ->avg('rating');

        $members = auth()->user()->activeGroup->members()
            ->with('user', 'feedback.question')
            ->get();

        return view('insights.feedback', compact('group', 'members', 'feedback', 'average'));
    }
}
