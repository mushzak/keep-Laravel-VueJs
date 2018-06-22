<?php

namespace App\Http\Controllers\Member;

use App\Member;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Carbon;

class UpdateContactInfoController extends Controller
{
    /**
     * @param Request $request
     * @param Member $member
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, Member $member)
    {
        $member->update($request->validate([
            'email' => 'nullable|email',
            'other' => 'nullable',
            'phone_1' => 'nullable',
            'phone_2' => 'nullable',
        ]));

        $member->performAndResolve('updated-contact-info');

        return response([], 204);
    }
}
