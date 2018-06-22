<?php

namespace App\Http\Controllers\GroupConfig;

use App\Agreement;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UpdateAgreementController extends Controller
{
    /**
     * Updates a group agreement.
     *
     * @param Request $request
     * @param Agreement $agreement
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, Agreement $agreement)
    {
        $this->authorize('facilitate', auth()->user()->activeGroup);

        $input = $request->validate([
            'content' => 'required',
        ]);

        $agreement->update($input);

        auth()->user()->activeGroup->performAndResolve('group-updated-agreements');

        return response([], 204);
    }
}
