<?php

namespace Tests\Feature;

use App\Feedback;
use App\Qna;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Traits\WithGroupMembership;

class GiveFeedbackTest extends TestCase
{
    use RefreshDatabase, WithGroupMembership;

    public function setUp()
    {
        parent::setUp();

        $this->addGroupMembership();
    }

    /** NOT BEING USED */
    public function unauthenticated_users_cannot_give_feedback()
    {
        $this->get("/groups/{$this->group->slug}/members/{$this->member->id}/give-feedback")
            ->assertRedirect('/login');
    }

    /** NOT BEING USED */
    public function non_group_members_cannot_give_feedback()
    {
        $this->givenLoggedInUser($this->create(User::class))
            ->get("/groups/{$this->group->slug}/members/{$this->member->id}/give-feedback")
            ->assertStatus(404);
    }

    /** NOT BEING USED */
    public function cannot_offer_to_give_feedback_if_group_only_has_one_member()
    {
        $this->givenLoggedInUser($this->user)
            ->get("/groups/{$this->group->slug}/give-feedback")
            ->assertStatus(404)
            ->assertSeeText('Unable to find a member to give feedback to, because this group only has one member');
    }

    /** NOT BEING USED */
    public function group_members_can_give_feedback_to_other_members()
    {
        $templateFeedback = $this->create(Feedback::class, [
            'group_id' => $this->group->id,
            'is_menu' => true,
            'author_id' => null,
            'member_id' => null,
            'comment' => null,
        ]);

        $templateQna = $this->create(Qna::class, [
            'feedback_id' => $templateFeedback->id,
            'question' => 'Overall',
            'response' => null,
        ]);

        $this->givenLoggedInUser($this->user);

        $this->json('POST', "/api/members/{$this->member->id}/feedbacks", [
            'new_qnas' => [
                "{$templateQna->id}" => '3',
            ],
            'comments' => 'Roll Tide > War Eagle',
        ]);

        $this->assertDatabaseHas('feedbacks', [
            'comment' => 'Roll Tide > War Eagle',
        ]);

        $this->assertDatabaseHas('qnas', [
            'response' => '3',
        ]);
    }
}
