<?php

namespace App\Http\Controllers\Discussion;

use App\Http\Controllers\Controller;
use App\Reply;

class ReplyDestroyController extends Controller
{
    /**
     * Deletes a reply.
     * 
     * @param Reply $reply
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Reply $reply)
    {
        $reply->delete();

        return response([], 204);
    }
}
