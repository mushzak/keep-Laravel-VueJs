<?php

namespace App\Events;

use App\Discussion;
use App\Member;
use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Http\Response;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;


class DiscussionCreated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var Discussion
     */
    public $discussion;

    /**
     * Create a new event instance.
     *
     * @param Discussion $discussion
     */
    public function __construct(Discussion $discussion)
    {
        $this->discussion = $discussion;
    }

    public function broadcastOn()
    {
        return new PrivateChannel("group.{$this->discussion->author->group->id}");
    }

    public function broadcastWith()
    {
        $group = $this->discussion->author->group;
        $group->load(['meetings', 'facilitator']);
        $facilitatorId = optional($group->facilitator)->id;
        $members = $group->members()->with('user')->get();
        $discussion = $this->discussion;
        $member = Member::byGroupUser($group, auth()->user())->firstOrFail();

        $list_read_discussions=\DB::table('members')
            ->where('member_id', '=', $member->id)
            ->join('acknowledgements', 'members.id', '=', 'acknowledgements.member_id')
            ->join('discussions', 'discussions.id', '=', 'acknowledgements.discussion_id')
            ->where('discussions.target_type','=','App\Group')
            ->whereNotExists( function($q) {
                $q->select(\DB::raw(1))
                    ->from('replies')
                    ->where('acknowledgements.discussion_id','=','replies.discussion_id')
                    ->whereColumn('replies.updated_at', '>','acknowledgements.updated_at');
            })
            ->distinct('acknowledgements.discussion_id')
            ->pluck('acknowledgements.discussion_id');

        $group_discussions_count= $discussion->count();
        $group_read_discussions=$list_read_discussions;
        $unreadGroupCount=max(0,$group_discussions_count - $group_read_discussions->count());

        auth()->user()->activeGroupMember;
        $authedMemberId = auth()->id();

        //private menu section
        $authedMember = auth()->user()->activeGroupMember;
        foreach($members as $target){
            $discussions_to_target_count=\App\Discussion::
            where('target_type','=','App\Member')
                ->where('target_id','=',$target->id)
                ->Where('author_id','=',$authedMember->id)
                ->count();

            $discussions_from_target_count=\App\Discussion::
            where('target_type','=','App\Member')
                ->where('target_id','=',$authedMember->id)
                ->Where('author_id','=',$target->id)
                ->count();

            $read_discussions_to_target_count=\DB::table('acknowledgements')
                ->where('acknowledgements.member_id', '=', $authedMember->id)
                ->join('discussions', 'discussions.id', '=', 'acknowledgements.discussion_id')
                ->where('discussions.target_type','=','App\Member')
                ->where('discussions.target_id', '=', $target->id)
                ->where('discussions.author_id', '=', $authedMember->id)
                ->whereNotExists( function($q) {
                    $q->select(\DB::raw(1))
                        ->from('replies')
                        ->where('acknowledgements.discussion_id','=','replies.discussion_id')
                        ->whereColumn('replies.updated_at', '>','acknowledgements.updated_at');
                })

                ->distinct('acknowledgements.discussion_id')
                ->pluck('acknowledgements.discussion_id')
                ->count();

            $read_discussions_from_target_count=\DB::table('acknowledgements')
                ->where('acknowledgements.member_id', '=', $authedMember->id)
                ->join('discussions', 'discussions.id', '=', 'acknowledgements.discussion_id')
                ->where('discussions.target_type','=','App\Member')
                ->where('discussions.target_id', '=', $authedMember->id)
                ->where('discussions.author_id', '=', $target->id)
                ->whereNotExists( function($q) {
                    $q->select(\DB::raw(1))
                        ->from('replies')
                        ->where('acknowledgements.discussion_id','=','replies.discussion_id')
                        ->whereColumn('replies.updated_at', '>','acknowledgements.updated_at');
                })

                ->distinct('acknowledgements.discussion_id')
                ->pluck('acknowledgements.discussion_id')
                ->count();


            $target->unreadPrivateCount=max(0,$discussions_to_target_count
                +$discussions_from_target_count
                -$read_discussions_from_target_count
                -$read_discussions_to_target_count);
        }

        $this->discussion->replies = [];
        $this->discussion->replies_count = 0;
        $this->discussion->sort = $this->discussion->created_at->toDateTimeString();
        $this->discussion->has_user_subscribed = 1;

        return [
            'discussion' => $this->discussion->loadMissing('author.user'),
        ];

    }
}
