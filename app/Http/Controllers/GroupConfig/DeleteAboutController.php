<?php

namespace App\Http\Controllers\GroupConfig;

use App\Expectation;
use App\Group;
use App\Http\Controllers\Controller;

class DeleteAboutController extends Controller
{
    /**
     * Deletes a group expectation.
     *
     * @param Expectation $expectation
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Expectation $expectation)
    {
        $this->authorize('facilitate', auth()->user()->activeGroup);

        $expectation->delete();

        auth()->user()->activeGroup->performAndResolve('group-updated-expectations');

        return response([], 204);
    }
}
