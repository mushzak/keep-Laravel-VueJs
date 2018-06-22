<?php

namespace App\Http\Controllers\ManageMembers;

use App\Member;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UpdateMemberController extends Controller
{
    /**
     * @param Request $request
     * @param Member $member
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, Member $member)
    {
        $this->authorize('facilitate', $member->group);

        $input = $request->validate([
            'status' => 'required|in:active,inactivated,archived'
        ]);

        $member->update($input);

        return response([], 204);
    }
}
