<?php

namespace App\Console;

use App\Jobs\FlagMembersIfNeeded;
use App\Jobs\NotifyActiveParticipantsOfMeeting;
use App\Jobs\NotifyMembersToAffirmPlan;
use App\Jobs\NotifyMembersToCheckActions;
use App\Jobs\NotifyFacilitatorOfLateMembers;
use App\Jobs\NotifyFacilitatorOfMeetingParticipants;
use App\Jobs\NotifyLateMembersToCheckIn;
use App\Jobs\NotifyFacilitatorOfLateMembersToAffirmPlan;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [

    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {


        if (\App::environment('local')){
            $schedule->job(new FlagMembersIfNeeded)->HourlyAt(1);
            $schedule->job(new NotifyActiveParticipantsOfMeeting)->HourlyAt(2);
            $schedule->job(new NotifyMembersToAffirmPlan)->HourlyAt(3);
            $schedule->job(new NotifyMembersToCheckActions)->HourlyAt(4);
            $schedule->job(new NotifyFacilitatorOfMeetingParticipants)->HourlyAt(5);
            $schedule->job(new NotifyFacilitatorOfLateMembers)->HourlyAt(6);
            $schedule->job(new NotifyLateMembersToCheckIn)->HourlyAt(7);
            $schedule->job(new NotifyFacilitatorOfLateMembersToAffirmPlan)->HourlyAt(8);
            $schedule->job(new NotifyFacilitatorOfMeetingParticipants)->HourlyAt(9);

            $schedule->job(new FlagMembersIfNeeded)->everyFiveMinutes();
            $schedule->job(new NotifyActiveParticipantsOfMeeting)->everyFiveMinutes();
            $schedule->job(new NotifyMembersToAffirmPlan)->everyFiveMinutes();
            $schedule->job(new NotifyMembersToCheckActions)->everyFiveMinutes();
            $schedule->job(new NotifyFacilitatorOfMeetingParticipants)->everyFiveMinutes();
            $schedule->job(new NotifyFacilitatorOfLateMembers)->everyFiveMinutes();
            $schedule->job(new NotifyLateMembersToCheckIn)->everyFiveMinutes();
            $schedule->job(new NotifyFacilitatorOfLateMembersToAffirmPlan)->everyFiveMinutes();
            $schedule->job(new NotifyFacilitatorOfMeetingParticipants)->everyFiveMinutes();
        }

        // Every 5 minutes
        $schedule->command('horizon:snapshot')->everyFiveMinutes();

        // Daily
        $schedule->job(new FlagMembersIfNeeded)->DailyAt('06:00');
        $schedule->job(new NotifyActiveParticipantsOfMeeting)->DailyAt('06:05');
        $schedule->job(new NotifyMembersToAffirmPlan)->DailyAt('06:10');
        $schedule->job(new NotifyMembersToCheckActions)->DailyAt('06:15');
        $schedule->job(new NotifyFacilitatorOfMeetingParticipants)->DailyAt('06:20');
        $schedule->job(new NotifyFacilitatorOfLateMembers)->DailyAt('06:25');
        $schedule->job(new NotifyLateMembersToCheckIn)->DailyAt('06:30');
        $schedule->job(new NotifyFacilitatorOfLateMembersToAffirmPlan)->DailyAt('06:35');
        $schedule->job(new NotifyFacilitatorOfMeetingParticipants)->DailyAt('06:40');

    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
