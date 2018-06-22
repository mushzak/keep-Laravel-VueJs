<?php

namespace App\Listeners;

use App\Events\MemberDeleting;

class DeletingMember
{
    /**
     * Update user active group when the member is deleted.
     *
     * @param  MemberDeleting  $event
     * @return void
     */
    public function handle(MemberDeleting $event)
    {
        $groups=$event->member->user->groups->pluck('id');
        $groups->pull($groups->search($event->member->group->id));

        if($groups->count()==0){
            $new_active_group=null;

        }else{
            $new_active_group=$groups->first();  
        }
        $event->member->user->active_group_id=$new_active_group;
        $event->member->user->save();
    }
}
