<?php

namespace App\Http\Controllers\Member;

use App\Member;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Carbon;

class UpdatePersonalMotivationController extends Controller
{
    /**
     * @param Request $request
     * @param Member $member
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, Member $member)
    {
        $member->update($request->validate([
            'why' => 'nullable',
            'consequences' => 'nullable',
        ]));

        $member->performAndResolve('updated-personal-motivation');

        return response([], 204);
    }
}
