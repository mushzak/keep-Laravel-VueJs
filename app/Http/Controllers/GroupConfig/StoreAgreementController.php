<?php

namespace App\Http\Controllers\GroupConfig;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StoreAgreementController extends Controller
{
    /**
     * Add a new agreement to the group.
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

        $group->agreements()->create($input);

        auth()->user()->activeGroup->performAndResolve('group-updated-agreements');

        return response([], 204);
    }
}
