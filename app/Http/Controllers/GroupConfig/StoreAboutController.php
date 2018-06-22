<?php

namespace App\Http\Controllers\GroupConfig;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StoreAboutController extends Controller
{
    /**
     * Add a new expectation to the group.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        /** @var \App\Group $group */
        $group = auth()->user()->activeGroup;

        $this->authorize('facilitate', $group);

        $input = $request->validate(['content' => 'required']);

        $group->expectations()->create($input);

        auth()->user()->activeGroup->performAndResolve('group-updated-expectations');

        return response([], 204);
    }
}
