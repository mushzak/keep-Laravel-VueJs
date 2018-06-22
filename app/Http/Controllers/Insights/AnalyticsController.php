<?php

namespace App\Http\Controllers\Insights;

use App\Http\Controllers\Controller;

class AnalyticsController extends Controller
{
    public function __invoke()
    {
        $this->authorize('facilitate', auth()->user()->activeGroup);

        $members = auth()->user()->activeGroup->members()
            ->withCount('discussionsSent', 'repliesSent', 'completedCommitments', 'completedObjectives')
            ->with('user')
            ->get();

        foreach ($members as $member) {
            $member->predictor = $member->predictorMetric();
        }

        return view('insights.analytics', compact('members'));
    }
}
