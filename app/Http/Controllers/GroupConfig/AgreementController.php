<?php

namespace App\Http\Controllers\GroupConfig;

use App\Http\Controllers\Controller;

class AgreementController extends Controller
{
    /**
     * @return \Illuminate\Http\Response
     */
    public function __invoke()
    {
        $group = auth()->user()->activeGroup;
        $group->load('agreements');

        return view('groups.config.agreements', compact('group'));
    }
}
