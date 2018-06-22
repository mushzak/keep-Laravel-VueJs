<?php

namespace App\Http\Controllers\Discussion;

use App\Discussion;
use App\Group;
use App\Http\Controllers\Controller;
use App\Member;
use GuzzleHttp\Psr7\Request;

class GroupDiscussionListingController extends Controller
{
    /**
     * Display a listing of all group discussions.
     *
     * @param Group $group
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function __invoke(Group $group,$disc = null)
    {
        $discussions = $group->discussions()
            ->withCount('replies')
            ->with(['author.user', 'replies.author.user'])
            ->withHasUserSubscribed(auth()->user())
            ->orderBy('id')
            ->get();
            foreach ($discussions as $key=>$discussion){
                $discussions[$key]['sort'] =  (isset($discussion['replies'][count($discussion['replies'])-1]))? $discussion['replies'][count($discussion['replies'])-1]->created_at->toDateTimeString() : $discussion->created_at->toDateTimeString();
            }
        $discussions = $discussions->sortByDesc('sort');

        $group->load(['meetings', 'facilitator']);

        $facilitatorId = optional($group->facilitator)->id;

        $members = $group->members()->with('user')->get();

        $member = Member::byGroupUser($group, auth()->user())->firstOrFail();

        $list_read_discussions=\DB::table('members')
                                ->where('member_id', '=', $member->id)
                                ->join('acknowledgements', 'members.id', '=', 'acknowledgements.member_id')
                                ->join('discussions', 'discussions.id', '=', 'acknowledgements.discussion_id')
                                ->where('discussions.target_type','=','App\Group')
                                ->where('discussions.deleted_at','=',null)
                                ->whereNotExists( function($q) {
                                    $q->select(\DB::raw(1))
                                    ->from('replies')
                                    ->where('acknowledgements.discussion_id','=','replies.discussion_id')
                                    ->whereColumn('replies.updated_at', '>','acknowledgements.updated_at');
                                    })
                                ->distinct('acknowledgements.discussion_id')
                                ->pluck('acknowledgements.discussion_id');
        

        //group menu section
        $group_discussions_count= $discussions->count();  
        $group_read_discussions=$list_read_discussions;
        $unreadGroupCount=max(0,$group_discussions_count - $group_read_discussions->count());


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

        $goToCommentDiscussionId = $disc;
        return view('groups.discussions.group-index', compact('group', 'members', 'member', 'discussions','list_read_discussions','unreadGroupCount', 'facilitatorId','goToCommentDiscussionId'));
    }
}
