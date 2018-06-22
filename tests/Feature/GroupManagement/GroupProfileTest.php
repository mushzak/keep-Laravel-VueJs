<?php

namespace Tests\Feature\Groups;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\Traits\WithAccountSetup;

class GroupProfileTest extends TestCase
{
    use DatabaseMigrations, WithAccountSetup;

    /**
     * Setup the test environment.
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();

        $this->addAccount();

        $this->endpoint = "/groups/{$this->group->slug}/profile";
    }

    /** @test */
    public function a_member_can_view_the_group_profile_page()
    {
        $this->givenLoggedInUser($this->member)
            ->get($this->endpoint)
            ->assertSuccessful();
    }

    /** @test */
    public function non_group_members_cannot_view_group_profile_page()
    {
        $this->givenLoggedInUser($this->other_member)
            ->get($this->endpoint)
            ->assertStatus(403);
    }
}
