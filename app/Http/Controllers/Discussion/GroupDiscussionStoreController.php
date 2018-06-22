<?php

namespace App\Http\Controllers\Discussion;

use App\Events\DiscussionCreated;
use App\Group;
use App\Member;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GroupDiscussionStoreController extends Controller
{
    public function __invoke(Request $request, Group $group)
    {
        $author = Member::byGroupUser($group, auth()->user())->firstOrFail();

        $input = $request->validate([
            'title' => 'required',
            'body' => 'required',
            'is_urgent' => 'required|boolean',
        ]);

        $discussion = $group->discussions()->create([
            'author_id' => $author->id,
            'title' => $input['title'],
            'body' => $input['body'],
            'is_urgent' => $input['is_urgent'],
        ]);

        $members = $group->members()->with('user')->get();

        foreach ($members as $member){
            $discussion->subscribe($member->user);
        }

        //event(new DiscussionCreated($discussion));
        return $this->route('groups.discussions.show', [$group->slug, $discussion->id]);
    }
}
