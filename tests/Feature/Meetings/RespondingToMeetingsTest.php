<?php

namespace Tests\Feature\Meetings;

use App\Jobs\NotifyActiveParticipantsOfMeeting;
use App\Jobs\NotifyFacilitatorOfUnacceptedParticipants;
use App\Meeting;
use App\Notifications\ParticipantAddedNotification;
use App\Notifications\ParticipantRemovedNotification;
use App\Notifications\UnacceptedParticipantsNotification;
use App\Notifications\UpcomingMeetingNotification;
use App\Participant;
use Carbon\Carbon;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Traits\WithGroupMembership;

class RespondingToMeetingsTest extends TestCase
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
    public function a_participant_is_notified_when_they_have_been_added_to_a_meeting()
    {
        Notification::fake();

        $newParticipant = $this->create(Participant::class, [
            'meeting_id' => $this->meeting->id,
        ]);

        Notification::assertSentTo($newParticipant->member->user, ParticipantAddedNotification::class);
    }

    /** @test */
    public function a_participant_is_notified_when_they_have_been_removed_from_a_meeting()
    {
        Notification::fake();

        $this->participant->delete();

        Notification::assertSentTo($this->participant->member->user, ParticipantRemovedNotification::class);
    }

    /** @test */
    public function a_participant_of_a_meeting_can_accept_an_invitation()
    {
        $this->givenLoggedInUser($this->participant->member->user);

        $this->get("/participants/{$this->participant->id}/accept")
            ->assertRedirect("/groups/{$this->participant->member->group->slug}/meetings/{$this->meeting->id}");

        $this->assertDatabaseHas('participants', [
            'meeting_id' => $this->meeting->id,
            'status' => Participant::ACCEPTED,
        ]);
    }

    /** @test */
    public function a_participant_of_a_meeting_can_reject_an_invitation()
    {
        $this->givenLoggedInUser($this->participant->member->user);

        $this->get("/participants/{$this->participant->id}/reject")
            ->assertRedirect("/groups/{$this->participant->member->group->slug}/meetings/{$this->meeting->id}");

        $this->assertDatabaseHas('participants', [
            'meeting_id' => $this->meeting->id,
            'status' => Participant::REJECTED,
        ]);
    }

    /** @test */
    public function a_participant_who_has_not_rejected_a_meeting_is_notified_if_a_reminder_time_is_set()
    {
        Notification::fake();

        $meetingNeedingReminding = $this->create(Meeting::class, ['reminds_at' => Carbon::now()]);
        $meetingNotYetNeedingReminding = $this->create(Meeting::class, ['reminds_at' => Carbon::now()->addDay()]);
        $meetingNeverMeetingReminding = $this->create(Meeting::class, ['reminds_at' => null]);

        $participantForMeetingNeedingReminding = $this->create(Participant::class, ['meeting_id' => $meetingNeedingReminding]);
        $participantForMeetingNotYetNeedingReminding = $this->create(Participant::class, ['meeting_id' => $meetingNotYetNeedingReminding]);
        $participantForMeetingNeverMeetingReminding = $this->create(Participant::class, ['meeting_id' => $meetingNeverMeetingReminding]);

        NotifyActiveParticipantsOfMeeting::dispatch();

        Notification::assertSentTo($participantForMeetingNeedingReminding->member->user, UpcomingMeetingNotification::class);
        Notification::assertNotSentTo($participantForMeetingNotYetNeedingReminding->member->user, UpcomingMeetingNotification::class);
        Notification::assertNotSentTo($participantForMeetingNeverMeetingReminding->member->user, UpcomingMeetingNotification::class);

        $this->assertDatabaseHas('meetings', ['id' => $meetingNeedingReminding->id, 'was_participants_reminded' => true]);
        $this->assertDatabaseHas('meetings', ['id' => $meetingNotYetNeedingReminding->id, 'was_participants_reminded' => false]);
        $this->assertDatabaseHas('meetings', ['id' => $meetingNeverMeetingReminding->id, 'was_participants_reminded' => false]);
    }

    /** @test */
    public function a_participant_who_has_rejected_a_meeting_is_not_notified_if_a_reminder_time_is_set()
    {
        Notification::fake();

        $meetingNeedingReminding = $this->create(Meeting::class, ['reminds_at' => Carbon::now()]);

        $participantWhoRejected = $this->create(Participant::class, [
            'meeting_id' => $meetingNeedingReminding,
            'status' => Participant::REJECTED,
        ]);

        NotifyActiveParticipantsOfMeeting::dispatch();

        Notification::assertNotSentTo($participantWhoRejected->member->user, UpcomingMeetingNotification::class);

        $this->assertDatabaseHas('meetings', ['id' => $meetingNeedingReminding->id, 'was_participants_reminded' => true]);
    }

    /** @test */
    public function non_participants_group_members_cannot_respond_to_a_meeting()
    {
        $this->givenLoggedInUser($this->member->user);

        $this->get("/participants/{$this->participant->id}/accept")
            ->assertStatus(403);
    }

    /** @test */
    public function unauthenticated_users_cannot_respond_to_a_meeting()
    {
        $this->get("/participants/{$this->participant->id}/accept")
            ->assertRedirect('/login');
    }
}
