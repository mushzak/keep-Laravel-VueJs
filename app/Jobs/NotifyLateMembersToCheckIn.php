<?php

namespace App\Jobs;

use App\Member;
use App\Notifications\NeedToCheckInNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;

class NotifyLateMembersToCheckIn
{
    use Dispatchable, Queueable;

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $members = Member::lateForCheckIn()->get();

        foreach ($members as $member) {
            $member->user->notify(
                new NeedToCheckInNotification($member)
            );
        }
    }
}
