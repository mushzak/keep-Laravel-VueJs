<?php

namespace App\Jobs;

use App\Group;
use App\Notifications\MembersLateToAffirmPlanNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;

class NotifyFacilitatorOfLateMembersToAffirmPlan
{
    use Dispatchable, Queueable;

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $groups = Group::with(['members' => function ($query) {
            $query->unaffirmedActionPlan()->upcomingMeeting();
        }])->get();

        /** @var Group $group */
        foreach ($groups as $group) {
            if ($group->members->count()) {
                $group->facilitator->notify(
                    new MembersLateToAffirmPlanNotification($group, $group->members)
                );
            }
        }
    }
}

