<?php

namespace App\Http\Controllers\Member;

use App\Member;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Carbon;

class UpdateBigPictureController extends Controller
{
    /**
     * @param Request $request
     * @param Member $member
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, Member $member)
    {
        $member->update($request->validate([
            'vision' => 'nullable',
            'values' => 'nullable',
            'mission' => 'nullable',
        ]));

        $member->performAndResolve('updated-big-picture');

        return response([], 204);
    }
}
