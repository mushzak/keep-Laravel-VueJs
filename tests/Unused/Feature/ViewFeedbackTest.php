<?php

namespace Tests\Feature;

use App\Feedback;
use App\Qna;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Traits\WithGroupMembership;

class ViewFeedbackTest extends TestCase
{
    use RefreshDatabase, WithGroupMembership;

    public function setUp()
    {
        parent::setUp();

        $this->addGroupMembership();
    }

    /** @test */
    public function unauthenticated_users_cannot_view_feedback()
    {
        $this->get("/groups/{$this->group->slug}/feedback")
            ->assertRedirect('/login');
    }

    /** @test */
    public function non_group_members_cannot_view_feedback()
    {
        $this->givenLoggedInUser($this->create(User::class))
            ->get("/groups/{$this->group->slug}/feedback")
            ->assertStatus(404);
    }

    /** @test */
    public function group_members_can_view_their_feedback()
    {
        $feedback = $this->create(Feedback::class, [
            'member_id' => $this->member->id,
            'author_id' => $this->member->id,
            'group_id' => $this->group->id,
            'comment' => 'this is a comment of a feedback'
        ]);

        $qna = $this->create(Qna::class, [
            'feedback_id' => $feedback->id,
            'question' => 'Overall',
        ]);

        $this->givenLoggedInUser($this->user)
            ->get("/groups/{$this->group->slug}/feedback")
            ->assertSeeText("Feedback from {$feedback->member->user->name}")
            ->assertSeeText('this is a comment of a feedback')
            ->assertSeeText($qna->question);
    }
}
