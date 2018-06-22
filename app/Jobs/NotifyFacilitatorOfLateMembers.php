<?php

namespace App\Jobs;

use App\Group;
use App\Notifications\LateMembersListNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;

class NotifyFacilitatorOfLateMembers
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
            $query->lateForCheckIn();
        }])->get();

        /** @var Group $group */
        foreach ($groups as $group) {
            if ($group->members->count()) {
                $group->facilitator->notify(
                    new LateMembersListNotification($group, $group->members)
                );
            }
        }
    }
}
