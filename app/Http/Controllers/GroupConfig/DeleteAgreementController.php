<?php

namespace App\Http\Controllers\GroupConfig;

use App\Agreement;
use App\Http\Controllers\Controller;

class DeleteAgreementController extends Controller
{
    /**
     * Deletes a group agreement.
     *
     * @param Agreement $agreement
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Agreement $agreement)
    {
        $this->authorize('facilitate', auth()->user()->activeGroup);

        $agreement->delete();

        auth()->user()->activeGroup->performAndResolve('group-updated-agreements');

        return response([], 204);
    }
}
