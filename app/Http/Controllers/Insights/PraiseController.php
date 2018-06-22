<?php

namespace App\Http\Controllers\Insights;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PraiseController extends Controller
{
    public function __invoke()
    {
        $this->authorize('facilitate', auth()->user()->activeGroup);

        $members = auth()->user()->activeGroup->members()
            ->withCount('completedCommitments')
            ->with('user')
            ->orderBy('completed_commitments_count')
            ->get();

        return view('insights.praise', compact('members'));
    }
}
