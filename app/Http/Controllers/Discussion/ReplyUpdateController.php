<?php

namespace App\Http\Controllers\Discussion;

use App\Reply;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ReplyUpdateController extends Controller
{
    /**
     * Updates a reply.
     *
     * @param Request $request
     * @param Reply $reply
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, Reply $reply)
    {
        $reply->update($request->validate([
            'body' => 'required',
        ]));

        return response([], 204);
    }
}
