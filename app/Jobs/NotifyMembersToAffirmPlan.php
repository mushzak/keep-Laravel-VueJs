<?php

namespace App\Jobs;

use App\Member;
use App\Notifications\NeedToAffirmPlanNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;

class NotifyMembersToAffirmPlan
{
    use Dispatchable, Queueable;

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $members = Member::hasFlagType('updated-action-plan')->get();

        foreach ($members as $member) {
            if($member->group){
                $member->user->notify(
                    //TODO replace 7 with variable to threshold
                    new NeedToAffirmPlanNotification($member,$member->group, 7)
                );
            }
        }
    }
}