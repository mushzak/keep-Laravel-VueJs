<?php

namespace App\Http\Controllers\GroupConfig;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StorePlanningController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        /** @var \App\Group $group */
        $group = auth()->user()->activeGroup;

        $this->authorize('facilitate', $group);

        $input = $request->validate([
            'is_using_ask' => 'required|boolean',
            'is_using_backstory' => 'required|boolean',
            'is_using_commitment' => 'required|boolean',
            'is_using_outcome' => 'required|boolean',
            'is_using_goal' => 'required|boolean',

            'ask_label' => 'required',
            'backstory_label' => 'required',
            'commitment_label' => 'required',
            'outcome_label' => 'required',
            'goal_label' => 'required',
            'objective_label' => 'required',
        ]);

        $group->update($input);

        auth()->user()->activeGroup->performAndResolve('group-updated-member-plan');

        return response([], 204);
    }
}
