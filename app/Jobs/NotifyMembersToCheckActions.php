<?php

namespace App\Jobs;

use App\Member;
use App\Notifications\NeedToCheckActionsNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;

class NotifyMembersToCheckActions
{
    use Dispatchable, Queueable;

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $members = Member::whereHas('flags', function ($query){
                            $query->whereNull('resolved_at');
                        })
                        ->whereHas('group')
                        ->with('flags')->get();

        foreach ($members as $member) {
            $member->user->notify(
                new NeedToCheckActionsNotification($member, $member->group)
            );
        }
    }
}