<?php

namespace App\Http\Controllers\Discussion;

use App\Member;
use App\Http\Controllers\Controller;

class PrivateDiscussionListingController extends Controller
{
    /**
     * Display a listing of private discussions for a given user.
     *
     * @param Member $member
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function __invoke(Member $member)
    {
        $authedMember = auth()->user()->activeGroupMember;

        $discussions_received = $member->discussionsReceived()
            ->whereAuthorId($authedMember->id)
            ->where('target_type','=','App\Member');

        $discussions_received = $discussions_received
            ->withHasUserSubscribed(auth()->user())
            ->withCount('replies')
            ->with(['author.user', 'replies.author.user'])
            ->orderBy('id')
            ->get();

        $discussions_sent = $member->discussionsSent()
            ->whereTargetId($authedMember->id)
            ->where('target_type','=','App\Member');

        $discussions_sent = $discussions_sent
            ->withHasUserSubscribed(auth()->user())
            ->withCount('replies')
            ->with(['author.user', 'replies.author.user'])
            ->orderBy('id')
            ->get();

        $discussions=$discussions_received->merge($discussions_sent);

        $group = $member->group()->with(['meetings', 'members.user', 'facilitator'])->firstOrFail();

        $list_read_discussions=\DB::table('acknowledgements')
                                ->where('acknowledgements.member_id', '=', $authedMember->id)
                                ->join('discussions', 'discussions.id', '=', 'acknowledgements.discussion_id')
                                ->where('discussions.target_type','=','App\Member')
                                ->whereNotExists( function($q){
                                    $q->select(\DB::raw(1))
                                    ->from('replies')
                                    ->where('acknowledgements.discussion_id','=','replies.discussion_id')
                                    ->whereColumn('replies.updated_at', '>','acknowledgements.updated_at');
                                    })
                                ->distinct('acknowledgements.discussion_id')
                                ->pluck('acknowledgements.discussion_id');

        //Group Menus
        $group_discussions_count = $group->discussions()
            ->withHasUserSubscribed(auth()->user())
            ->count();

        $group_read_discussions=\DB::table('members')
                                ->where('member_id', '=', $authedMember->id)
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

        $unreadGroupCount=max(0,$group_discussions_count - $group_read_discussions->count());

        $facilitatorId = optional($group->facilitator)->id;

        //Private Menus
        $members = $group->members()->with('user')->get();
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
      
        return view('groups.discussions.member-index', compact('group', 'member', 'members', 'discussions', 'type','list_read_discussions', 'unreadGroupCount','facilitatorId'));
    }
}
