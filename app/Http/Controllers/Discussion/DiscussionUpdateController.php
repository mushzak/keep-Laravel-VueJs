<?php

namespace App\Http\Controllers\Discussion;

use App\Discussion;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DiscussionUpdateController extends Controller
{
    /**
     * Updates a discussion.
     *
     * @param Request $request
     * @param Discussion $discussion
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, Discussion $discussion)
    {
        $discussion->update($request->validate([
            'body' => 'required',
            'title' => '',
        ]));

        return response([], 204);
    }
}
