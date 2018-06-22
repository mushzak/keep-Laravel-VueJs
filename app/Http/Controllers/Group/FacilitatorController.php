<?php

namespace App\Http\Controllers\Group;

use App\Group;
use App\Http\Controllers\Controller;

class FacilitatorController extends Controller
{
    /**
     * FacilitatorController constructor.
     */
    public function __construct()
    {
        $this->middleware('can:facilitate,group');
    }

    /**
     * Display a listing of the resource.
     *
     * @param Group $group
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Group $group)
    {
        return view('groups.facilitator.index', compact('group'));
    }
}
