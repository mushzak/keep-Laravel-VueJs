<?php

namespace App\Http\Controllers\ManageMembers;

use App\Invite;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StoreInvitedController extends Controller
{
    /**
     * @param Request $request
     * @param Invite $invite
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, Invite $invite)
    {
        $input = $request->validate([
            'group_id' => 'required',
            'email' => 'required|email',
            'is_facilitator' => 'required|boolean',
            'is_manager' => 'required|boolean',
        ]);

        Invite::create($input);

        return response([], 204);
    }
}
