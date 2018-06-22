<?php

namespace App\Http\Controllers\GroupConfig;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StoreFeedbackController extends Controller
{
    /**
     * Adds a new group question.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        /** @var \App\Group $group */
        $group = auth()->user()->activeGroup;

        $this->authorize('facilitate', $group);

        $input = $request->validate([
            'content' => 'required',
            'has_rating' => 'required|boolean',
            'when_asked' => 'required',
        ]);

        $group->questions()->create($input);

        auth()->user()->activeGroup->performAndResolve('group-updated-feedback');

        return response([], 204);
    }
}
