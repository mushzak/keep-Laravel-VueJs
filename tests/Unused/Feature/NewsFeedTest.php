<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Traits\WithGroupMembership;

class NewsFeedTest extends TestCase
{
    use RefreshDatabase, WithGroupMembership;

    public function setUp()
    {
        parent::setUp();

        $this->addGroupMembership();
    }

    /** @test */
    public function unauthenticated_users_cannot_view_a_newsfeed()
    {
        $this->get("/groups/{$this->group->id}/newsfeed")
            ->assertRedirect('/login');
    }

    /** @test */
    public function non_group_members_cannot_view_a_newsfeed()
    {
        $this->givenLoggedInUser($this->create(User::class))
            ->get("/groups/{$this->group->slug}/newsfeed")
            ->assertStatus(404);
    }

    /** @test */
    public function group_members_can_view_their_newsfeed()
    {
        $this->givenLoggedInUser($this->user)
            ->get("/groups/{$this->group->slug}/newsfeed")
            ->assertSuccessful();
    }
}
