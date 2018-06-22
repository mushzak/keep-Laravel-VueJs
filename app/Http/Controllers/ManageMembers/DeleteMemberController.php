<?php

namespace App\Http\Controllers\ManageMembers;

use App\Http\Controllers\Controller;
use App\Member;

class DeleteMemberController extends Controller
{
    /**
     * @param Member $member
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Member $member)
    {
        $this->authorize('facilitate', $member->group);

        $member->delete();

        flash()->success('The member has been removed successfully.');
        return $this->route('manage-members.index');
    }
}
