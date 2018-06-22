<?php

namespace App\Http\Controllers\ManageMembers;

use App\Invite;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DestroyInvitedController extends Controller
{
    /**
     * @param Invite $invite
     * @return \Illuminate\Http\Response
     * @internal param Request $request
     */
    public function __invoke(Invite $invite)
    {
        $invite->delete();

        return response([], 204);
    }
}
