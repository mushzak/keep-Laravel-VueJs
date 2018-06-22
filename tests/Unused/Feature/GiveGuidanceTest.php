<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Traits\WithGroupMembership;

class GiveGuidanceTest extends TestCase
{
    use RefreshDatabase, WithGroupMembership;

    public function setUp()
    {
        parent::setUp();

        $this->addGroupMembership();
    }

    /** NOT BEING USED */
    public function unauthenticated_users_cannot_give_guidance()
    {
        $this->get("/groups/{$this->group->slug}/members/{$this->member->id}/give-guidance")
            ->assertRedirect('/login');
    }

    /** NOT BEING USED */
    public function non_group_members_cannot_give_guidance()
    {
        $this->givenLoggedInUser($this->create(User::class))
            ->get("/groups/{$this->group->slug}/members/{$this->member->id}/give-guidance")
            ->assertStatus(404);
    }
}
