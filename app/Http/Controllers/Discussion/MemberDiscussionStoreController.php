<?php

namespace App\Http\Controllers\Discussion;

use App\Member;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MemberDiscussionStoreController extends Controller
{
    /**
     * Saves a private message.
     *
     * @param Request $request
     * @param Member $member
     * @return string
     */
    public function __invoke(Request $request, Member $member)
    {
        $author = Member::byGroupUser($member->group, auth()->user())->firstOrFail();

        $input = $request->validate([
            'title' => 'required',
            'body' => 'required',
            'is_urgent' => 'required|boolean',
        ]);

        $discussion = $member->discussionsReceived()->create([
            'author_id' => $author->id,
            'title' => $input['title'],
            'body' => $input['body'],
            'is_urgent' => $input['is_urgent'],
        ]);

        return $this->route('groups.discussions.show', [$member->group->slug, $discussion->id]);
    }
}
