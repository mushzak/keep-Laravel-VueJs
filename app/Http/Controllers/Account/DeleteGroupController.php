<?php

namespace App\Http\Controllers\Account;

use App\Group;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DeleteGroupController extends Controller
{
    /**
     * @param Group $group
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Group $group)
    {
        $this->authorize('manage', $group);

        $group->delete();

        return response([], 204);
    }
}
