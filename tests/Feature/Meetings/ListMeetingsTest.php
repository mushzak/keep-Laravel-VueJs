<?php

namespace Tests\Feature\Meetings;

use App\Meeting;
use App\Participant;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Traits\WithGroupMembership;

class ListMeetingsTest extends TestCase
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
    public function a_group_member_can_view_a_list_of_meetings()
    {
        $this->givenLoggedInUser($this->member->user);

        $this->get("/groups/{$this->group->slug}/meetings/{$this->meeting->id}")
            ->assertSuccessful()
            ->assertSeeText($this->meeting->subject);
    }

    /** @test */
    public function non_group_members_cannot_view_a_list_of_meetings()
    {
        $this->givenLoggedInUser();

        $this->get("/groups/{$this->group->slug}/meetings/{$this->meeting->id}")
            ->assertStatus(403);
    }

    /** @test */
    public function unauthenticated_users_cannot_view_a_list_of_meetings()
    {
        $this->get("/groups/{$this->group->id}/meetings/{$this->meeting->id}")
            ->assertRedirect('/login');
    }
}
