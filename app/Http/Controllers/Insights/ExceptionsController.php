<?php

namespace App\Http\Controllers\Insights;

use App\Http\Controllers\Controller;

class ExceptionsController extends Controller
{
    public function __invoke()
    {
        $this->authorize('facilitate', auth()->user()->activeGroup);

        $members = auth()->user()->activeGroup->members()
            ->withCount('completedCommitments')
            ->with('user')
            ->orderBy('completed_commitments_count', 'desc')
            ->get();

        return view('insights.exceptions', compact('members'));
    }
}
