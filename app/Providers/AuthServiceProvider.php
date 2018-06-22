<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Laravel\Horizon\Horizon;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        \App\Account::class => \App\Policies\AccountPolicy::class,
        \App\Discussion::class => \App\Policies\DiscussionPolicy::class,
        \App\Group::class => \App\Policies\GroupPolicy::class,
        \App\Meeting::class => \App\Policies\MeetingPolicy::class,
        \App\Member::class => \App\Policies\MemberPolicy::class,
        \App\Participant::class => \App\Policies\ParticipantPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // Only allow Laravel Horizon to be viewed in local/testing modes,
        // or if the user is an admin.
        Horizon::auth(function (Request $request) {
            if (in_array(app()->environment(), ['local', 'testing']))
                return true;

            if (optional($request->user())->is_admin)
                return true;

            return false;
        });
    }
}
