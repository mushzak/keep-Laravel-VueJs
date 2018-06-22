<?php

namespace App\Http\Controllers\Discussion;

use App\Discussion;
use App\Group;
use App\Member;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ReplyStoreController extends Controller
{
    /**
     * Stores a reply.
     *
     * @param Request $request
     * @param Discussion $discussion
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, Discussion $discussion)
    {
        if ($discussion->target instanceof Group)
            $author = Member::byGroupUser($discussion->target, auth()->user())->firstOrFail();
        else
            $author = Member::byGroupUser($discussion->target->group, auth()->user())->firstOrFail();

        $input = $request->validate([
            'body' => 'required',
            'is_urgent' => 'required|boolean',
        ]);

        $discussionLast = $discussion->replies()->create([
            'author_id' => $author->id,
            'body' => $input['body'],
            'is_urgent' => $input['is_urgent'],
        ]);

        return response()->json(['data'=>$discussionLast]);
    }
}
