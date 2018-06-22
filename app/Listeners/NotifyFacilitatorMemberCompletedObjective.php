<?php

namespace App\Listeners;

use App\Events\ObjectiveUpdated;
use App\Notifications\MemberCompletedObjectiveNotification;
use App\Notifications\MemberCompletedAllObjectivesNotification;

class NotifyFacilitatorMemberCompletedObjective
{
    /**
     * Handle the event.
     *
     * @param  ReplyCreated  $event
     * @return void
     */
    public function handle(ObjectiveUpdated $event)
    {

        $objectives=$event->objective->goal->objectives;
        $objectives_uncompleted=$objectives->where('completed_at',null)->count();
        if($objectives_uncompleted==0){
            $event->objective
                ->goal
                ->member
                ->group
                ->facilitator
                ->notify(
                    new MemberCompletedAllObjectivesNotification($event->objective->goal->member,$event->objective->goal->member->group->facilitator)
                );
        }elseif(! is_null($event->objective->completed_at)){
            $event->objective
                ->goal
                ->member
                ->group
                ->facilitator
                ->notify(
                    new MemberCompletedObjectiveNotification($event->objective,$event->objective->goal->member->group->facilitator)
                );
        }
    }
}
