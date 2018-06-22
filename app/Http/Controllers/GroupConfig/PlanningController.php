<?php

namespace App\Http\Controllers\GroupConfig;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PlanningController extends Controller
{
    /**
     * @return \Illuminate\Http\Response
     */
    public function __invoke()
    {
        $group = auth()->user()->activeGroup;

        return view('groups.config.planning', compact('group'));
    }
}
