<?php

namespace Tests\Feature\Meetings;

use App\Meeting;
use App\Participant;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Traits\WithGroupMembership;

class DeleteMeetingTest extends TestCase
{
    use RefreshDatabase, WithGroupMembership;

    /** @var Meeting */
    public $meeting;

    /** @var Participant */
    public $participant;

    public function setUp()
    {
        parent::setUp();

        $this->addGroupMembership();

        $this->meeting = $this->create(Meeting::class, [
            'group_id' => $this->group->id,
        ]);

        $this->participant = $this->create(Participant::class, [
            'meeting_id' => $this->meeting->id,
        ]);
    }

    /** @test */
    public function a_group_facilitator_can_cancel_a_meeting()
    {
        Notification::fake();

        $this->givenLoggedInUser($this->group->facilitator);

        $this->json('DELETE', "/groups/{$this->group->slug}/meetings/{$this->meeting->id}")
            ->assertSuccessful();

        $this->assertSoftDeleted('meetings', [
            'id' => $this->meeting->id,
        ]);

        $this->assertSoftDeleted('participants', [
            'id' => $this->participant->id,
        ]);
    }

    /** @test */
    public function non_group_facilitators_cannot_cancel_a_meeting()
    {
        $this->givenLoggedInUser($this->member->user);

        $this->json('DELETE', "/groups/{$this->group->slug}/meetings/{$this->meeting->id}")
            ->assertStatus(403);
    }

    /** @test */
    public function unauthenticated_users_cannot_cancel_a_meeting()
    {
        $this->json('DELETE', "/groups/{$this->group->slug}/meetings/{$this->meeting->id}")
            ->assertStatus(401);
    }
}
