<?php

namespace Tests\Feature\CheckIns;

use App\Group;
use App\Jobs\NotifyFacilitatorOfLateMembers;
use App\Jobs\NotifyLateMembersToCheckIn;
use App\Member;
use App\Notifications\NeedToCheckInNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;
use Tests\Traits\WithGroupMembership;

class CheckInTest extends TestCase
{
    use RefreshDatabase, WithGroupMembership;

    public function setUp()
    {
        parent::setUp();

        $this->addGroupMembership();
    }

    /** @test */
    public function each_user_will_be_tracked_when_they_access_the_platform()
    {
    	$this->givenLoggedInUser($this->member->user);

    	$now = Carbon::now();

    	$this->get("/groups/{$this->group->slug}/profile");

    	$this->assertTrue(
    	    $now->gte($this->member->user->fresh()->last_checked_in_at)
        );
    }

    /** @test */
    public function the_facilitator_can_define_the_interval_in_which_group_members_should_access_the_platform()
    {
        $this->givenLoggedInUser($this->group->facilitator);

        $this->json('POST', "/groups/{$this->group->slug}/check-in", ['check_in_interval' => 123])
            ->assertSuccessful();

        $this->assertDatabaseHas('groups', [
            'id' => $this->group->id,
            'check_in_interval' => 123,
        ]);
    }

    /** @test */
    public function non_facilitators_cannot_define_the_interval_in_which_group_members_should_access_the_platform()
    {
        $this->givenLoggedInUser($this->member->user);

        $this->json('POST', "/groups/{$this->group->slug}/check-in", ['check_in_interval' => 2])
            ->assertStatus(403);
    }

    /** @test */
    public function a_group_facilitator_should_be_notified_daily_with_a_listing_of_members_not_accessing_the_group_within_the_group_check_in_interval()
    {
        Notification::fake();

        $group = $this->create(Group::class, ['check_in_interval' => 7]);

        $justArrivedMember = $this->create(Member::class, ['group_id' => $group->id]);
        $onTimeMember = $this->create(Member::class, ['group_id' => $group->id]);
        $lateMember = $this->create(Member::class, ['group_id' => $group->id]);
        $neverArrivedMember = $this->create(Member::class, ['group_id' => $group->id]);

        $justArrivedMember->user->update(['last_checked_in_at' => Carbon::now()]);
        $onTimeMember->user->update(['last_checked_in_at' => Carbon::now()->subDays(7)]);
        $lateMember->user->update(['last_checked_in_at' => Carbon::now()->subDays(8)]);
        $neverArrivedMember->user->update(['last_checked_in_at' => null]);

        NotifyFacilitatorOfLateMembers::dispatch();

        Notification::assertNotSentTo($group->facilitator, NotifyFacilitatorOfLateMembers::class);
    }

    /** @test */
    public function a_group_member_should_be_notified_daily_if_they_have_not_accessed_the_site_within_the_group_check_in_interval()
    {
        Notification::fake();

        $group = $this->create(Group::class, ['check_in_interval' => 7]);

        $justArrivedMember = $this->create(Member::class, ['group_id' => $group->id]);
        $onTimeMember = $this->create(Member::class, ['group_id' => $group->id]);
        $lateMember = $this->create(Member::class, ['group_id' => $group->id]);
        $neverArrivedMember = $this->create(Member::class, ['group_id' => $group->id]);

        $justArrivedMember->user->update(['last_checked_in_at' => Carbon::now()]);
        $onTimeMember->user->update(['last_checked_in_at' => Carbon::now()->subDays(7)->addMinutes(1)]);
        $lateMember->user->update(['last_checked_in_at' => Carbon::now()->subDays(7)->subMinutes(2)]);
        $neverArrivedMember->user->update(['last_checked_in_at' => null]);

        NotifyLateMembersToCheckIn::dispatch();

        Notification::assertNotSentTo($justArrivedMember->user, NeedToCheckInNotification::class);
        Notification::assertNotSentTo($onTimeMember->user, NeedToCheckInNotification::class);
        Notification::assertSentTo($lateMember->user, NeedToCheckInNotification::class);
        Notification::assertSentTo($neverArrivedMember->user, NeedToCheckInNotification::class);
    }
}
