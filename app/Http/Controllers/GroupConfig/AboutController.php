<?php

namespace App\Http\Controllers\GroupConfig;

use App\Http\Controllers\Controller;

class AboutController extends Controller
{
    /**
     * @return \Illuminate\Http\Response
     */
    public function __invoke()
    {
        $group = auth()->user()->activeGroup;
        $group->load('expectations');

        return view('groups.config.about', compact('group'));
    }
}
