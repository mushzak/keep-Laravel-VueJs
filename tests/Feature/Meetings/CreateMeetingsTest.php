<?php

namespace Tests\Feature\Meetings;

use App\Meeting;
use App\Participant;
use Illuminate\Support\Carbon;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Traits\WithGroupMembership;

class CreateMeetingsTest extends TestCase
{
    use RefreshDatabase, WithGroupMembership;

    public function setUp()
    {
        parent::setUp();

        $this->addGroupMembership();
    }

    /** @test */
    public function a_group_facilitator_can_schedule_a_meeting()
    {
        $newMeetingDetails = array_merge(
            $this->make(Meeting::class)->toArray(),
            ['members' => [
                $this->member->id => '1',
            ]]
        );

        $this->givenLoggedInUser($this->group->facilitator)
            ->json('POST', "/groups/{$this->group->slug}/meetings", $newMeetingDetails)
            ->assertSuccessful();

        $this->assertDatabaseHas('meetings', [
            'group_id' => $this->group->id,
            'subject' => $newMeetingDetails['subject'],
            'reminds_at' => $newMeetingDetails['reminds_at'],
            'starts_at' => $newMeetingDetails['starts_at'],
            'ends_at' => $newMeetingDetails['ends_at'],
        ]);

        $this->assertDatabaseHas('participants', [
            'member_id' => $this->member->id,
            'status' => Participant::NOT_RESPONDED,
        ]);
    }

    /** @test */
    public function a_new_meeting_must_start_in_the_future()
    {
        $newMeetingDetails = array_merge(
            $this->make(Meeting::class, ['starts_at' => Carbon::now()->subSecond()])->toArray(),
            ['members' => [
                $this->member->id => '1',
            ]]
        );

        $this->givenLoggedInUser($this->group->facilitator)
            ->json('POST', "/groups/{$this->group->slug}/meetings", $newMeetingDetails)
            ->assertStatus(422);
    }

    /** @test */
    public function a_new_meeting_must_end_in_the_future()
    {
        $newMeetingDetails = array_merge(
            $this->make(Meeting::class, ['ends_at' => Carbon::now()->subSecond()])->toArray(),
            ['members' => [
                $this->member->id => '1',
            ]]
        );

        $this->givenLoggedInUser($this->group->facilitator)
            ->json('POST', "/groups/{$this->group->slug}/meetings", $newMeetingDetails)
            ->assertStatus(422);
    }

    /** @test */
    public function a_new_meeting_must_be_reminded_in_the_future()
    {
        $newMeetingDetails = array_merge(
            $this->make(Meeting::class, ['reminds_at' => Carbon::now()->subSecond()])->toArray(),
            ['members' => [
                $this->member->id => '1',
            ]]
        );

        $this->givenLoggedInUser($this->group->facilitator)
            ->json('POST', "/groups/{$this->group->slug}/meetings", $newMeetingDetails)
            ->assertStatus(422);
    }

    /** @test */
    public function non_group_facilitators_cannot_schedule_a_meeting()
    {
        $this->givenLoggedInUser($this->member->user);

        $this->json('POST', "/groups/{$this->group->slug}/meetings")
            ->assertStatus(403);
    }

    /** @test */
    public function unauthenticated_users_cannot_schedule_a_meeting()
    {
        $this->json('POST', "/groups/{$this->group->slug}/meetings")
            ->assertStatus(401);
    }
}
