<?php

namespace App\Http\Controllers\Insights;

use App\Http\Controllers\Controller;

class HistoryController extends Controller
{
    public function __invoke()
    {
        $this->authorize('facilitate', auth()->user()->activeGroup);

        $members = auth()->user()->activeGroup->members()
            ->with('user', 'feedback.question')
            ->get();

        return view('insights.history', compact('members', 'feedback', 'average'));
    }
}
