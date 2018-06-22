<?php

namespace App\Http\Controllers\Group;

use App\Group;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StoreCheckInPeriodController extends Controller
{
    /**
     * StoreCheckInPeriodController constructor.
     */
    public function __construct()
    {
        $this->middleware('can:facilitate,group');
    }

    /**
     * Store the check-in period for the group.
     *
     * @param Request $request
     * @param Group $group
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, Group $group)
    {
        $group->update(
            $request->validate([
                'check_in_interval' => 'required|integer|min:0'
            ])
        );

        return response([], 204);
    }
}
