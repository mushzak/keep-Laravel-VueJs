<?php

namespace App\Http\Controllers\GroupConfig;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StoreCheckInController extends Controller
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
            'check_in_interval' => 'required|integer|min:0|max:60',
            'pace' => 'required',
        ]);

        $group->update($input);

        auth()->user()->activeGroup->performAndResolve('group-updated-check-ins');

        return response([], 204);
    }
}
