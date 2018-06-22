<?php

namespace App\Http\Controllers\Discussion;

use App\Discussion;
use App\Http\Controllers\Controller;

class DiscussionDestroyController extends Controller
{
    /**
     * Deletes a discussion.
     *
     * @param Discussion $discussion
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Discussion $discussion)
    {
        $discussion->delete();

        return response([], 204);
    }
}
