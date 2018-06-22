<?php

namespace App\Http\Controllers\GroupConfig;

use App\Expectation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UpdateAboutController extends Controller
{
    /**
     * Updates a group expectation.
     *
     * @param Request $request
     * @param Expectation $expectation
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, Expectation $expectation)
    {
        $this->authorize('facilitate', auth()->user()->activeGroup);

        $input = $request->validate([
            'content' => 'required',
        ]);

        $expectation->update($input);

        auth()->user()->activeGroup->performAndResolve('group-updated-expectations');

        return response([], 204);
    }
}
