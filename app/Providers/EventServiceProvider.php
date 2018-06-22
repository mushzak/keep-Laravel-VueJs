<?php

namespace App\Providers;

use App\Events\MemberCreated;
use App\Listeners\TagNotifiedUsersInReply;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        \App\Events\AccountCreated::class => [
            \App\Listeners\CreateFlagsForNewAccount::class,
            \App\Listeners\NotifyEmailOfNewAccount::class,
        ],
        \App\Events\DiscussionCreated::class => [
            \App\Listeners\TagNotifiedUsersInDiscussion::class,
            \App\Listeners\NotifyTargetIfPrivateDiscussion::class,
            \App\Listeners\NotifyTargetsIfUrgentDiscussion::class,
        ],
        \App\Events\GroupCreating::class => [
            \App\Listeners\MakeGroupSlugIfNoneExists::class,
        ],
        \App\Events\GroupCreated::class => [
            \App\Listeners\CreateFlagsForNewGroup::class,
            \App\Listeners\AddDefaultValuesForNewGroup::class,
        ],
        \App\Events\GroupDeleting::class => [
            \App\Listeners\DeleteMembers::class,
        ],
        \App\Events\InviteCreating::class => [
            \App\Listeners\AddTokenToNewInvites::class,
        ],
        \App\Events\InviteCreated::class => [
            \App\Listeners\NotifyEmailOfNewInvite::class,
        ],
        \App\Events\MemberCreated::class => [
            \App\Listeners\UpdateUsersActiveGroupOnNewMember::class,
            \App\Listeners\CreateFlagsForNewMember::class,
            \App\Listeners\CreateGoalForNewMember::class,
            \App\Listeners\AddDefaultValuesForNewMember::class,
        ],
        \App\Events\MemberDeleting::class => [
            \App\Listeners\DeletingMember::class,
        ],

        \App\Events\MeetingCreated::class => [
            \App\Listeners\CreateDiscussionForNewMeeting::class,
        ],

        \App\Events\MeetingDeleted::class => [
            \App\Listeners\DeleteParticipants::class,
        ],
        \App\Events\ParticipantCreated::class => [
            \App\Listeners\NotifyParticipantOfInvite::class,
        ],
        \App\Events\ParticipantDeleted::class => [
            \App\Listeners\NotifyParticipantOfRemoval::class,
        ],
        \App\Events\ObjectiveUpdated::class => [
            \App\Listeners\NotifyFacilitatorMemberCompletedObjective::class,
        ],

        \App\Events\ReplyCreated::class => [
            \App\Listeners\TagNotifiedUsersInReply::class,
            \App\Listeners\NotifyTargetIfPrivateReply::class,
            \App\Listeners\NotifyTargetsIfUrgentReply::class,
            \App\Listeners\NotifyDiscussionSubscribersOnNewReply::class,
            \App\Listeners\SubscribeUsersToDiscussionsOnNewReply::class,
        ],
        \Illuminate\Auth\Events\Login::class => [
            \App\Listeners\CheckSuccessfulLoginForInvites::class,
            \App\Listeners\BlockInactiveMembers::class,
        ],
        \Illuminate\Auth\Events\Registered::class => [
            \App\Listeners\CreateAccountOnUserCreation::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
