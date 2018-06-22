<?php

namespace App\Http\Controllers\GroupConfig;

use App\Http\Controllers\Controller;

class FeedbackController extends Controller
{
    /**
     * @return \Illuminate\Http\Response
     */
    public function __invoke()
    {
        $group = auth()->user()->activeGroup;
        $group->load('questions');
 
        return view('groups.config.feedback', compact('group'));
    }
}
