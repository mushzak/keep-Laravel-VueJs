<?php

namespace App\Http\Controllers\Account;

use App\Group;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;

class UpdateGroupController extends Controller
{
    /**
     * @param Request $request
     * @param Group $group
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, Group $group)
    {
        $this->authorize('manage', $group);

        $input = $request->validate([
            'name' => 'required',
            'facilitator_id' => ['required', Rule::exists('users', 'id')],
        ]);

        $group->update($input);

        return response([], 204);
    }
}
