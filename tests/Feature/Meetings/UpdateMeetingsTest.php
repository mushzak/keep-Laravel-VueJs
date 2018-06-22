<?php

namespace Tests\Feature\Meetings;

use App\Meeting;
use App\Participant;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Traits\WithGroupMembership;

class UpdateMeetingsTest extends TestCase
{
    use RefreshDatabase, WithGroupMembership;

    /** @var Meeting */
    public $meeting;

    public function setUp()
    {
        parent::setUp();

        $this->addGroupMembership();

        $this->meeting = $this->create(Meeting::class, [
            'group_id' => $this->group->id,
        ]);
    }

    /** @test */
    public function a_group_facilitator_can_update_a_meeting()
    {
        $newMeetingDetails = array_merge(
            $this->make(Meeting::class)->toArray(),
            ['members' => [
                $this->member->id => '1',
            ]]
        );

        $this->givenLoggedInUser($this->group->facilitator)
            ->json('PATCH', "/groups/{$this->group->slug}/meetings/{$this->meeting->id}", $newMeetingDetails)
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
    public function non_group_facilitators_cannot_update_a_meeting()
    {
        $this->givenLoggedInUser($this->member->user);

        $this->json('PATCH', "/groups/{$this->group->slug}/meetings/{$this->meeting->id}")
            ->assertStatus(403);
    }

    /** @test */
    public function unauthenticated_users_cannot_update_a_meeting()
    {
        $this->json('PATCH', "/groups/{$this->group->slug}/meetings/{$this->meeting->id}")
            ->assertStatus(401);
    }
}
