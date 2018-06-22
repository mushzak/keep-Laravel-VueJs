<?php

namespace App\Http\Controllers\Group;

use App\Group;
use App\Http\Controllers\Controller;

class AdvanceProcessController extends Controller
{
    /**
     * Advance the current process for a group.
     *
     * @param Group $group
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Group $group)
    {
        $this->authorize('facilitate', $group);

        $group->current_process++;
        $group->save();

        return response([], 204);
    }
}
