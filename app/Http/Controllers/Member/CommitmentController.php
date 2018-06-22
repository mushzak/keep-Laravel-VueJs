<?php

namespace App\Http\Controllers\Member;

use App\Commitment;
use App\Member;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Carbon;

class CommitmentController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @param  \App\Member $member
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Member $member)
    {
        $input = $request->validate([
            'process_number' => 'required|integer',
            'name' => 'nullable',
            'ask' => 'nullable',
            'backstory' => 'nullable',
            'outcome' => 'nullable',
        ]);

        Commitment::updateOrCreate(
            [
                'process_number' => $input['process_number'],
                'member_id' => $member->id,
            ],
            [
                'name' => $input['name'],
                'ask' => $input['ask'],
                'backstory' => $input['backstory'],
                'outcome' => $input['outcome'],
            ]
        );

        $member->performAndResolve('updated-action-plan');

        return response([], 204);
    }
}
