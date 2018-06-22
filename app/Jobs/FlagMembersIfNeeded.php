<?php

namespace App\Jobs;

use App\Factories\FlagFactory;
use App\Member;
use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Carbon;

class FlagMembersIfNeeded
{
    use Dispatchable, Queueable;

    /**
     * The number of days where a particular action should be considered.
     *
     * @var int
     */
    public static $daysToConsider = 7;

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $members = Member::all();

        foreach ($members as $member) {
            $factory = (new FlagFactory)->flaggable($member);
            $threshold = Carbon::now()->subDays(self::$daysToConsider);

            // Flags to create if the user is late.
            $factory->createIfLate('updated-action-plan', $threshold);
            $factory->createIfLate('updated-goals-and-objectives', $threshold);
            $factory->createIfLate('updated-big-picture', $threshold);
            $factory->createIfLate('updated-personal-motivation', $threshold);
            //Removed these from being flagged repeatedly
            //$factory->createIfLate('updated-personal-background', $threshold);
            //$factory->createIfLate('updated-professional-background', $threshold);
            //$factory->createIfLate('updated-contact-info', $threshold);
        }
    }
}

