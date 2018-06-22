<?php

namespace Tests\Feature\Groups;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\Traits\WithAccountSetup;

class GroupsManagementTest extends TestCase
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

        $this->endpoint = "/account/groups";
    }

    /** @test */
    public function an_account_manager_can_view_the_group_management_form()
    {
        $this->givenLoggedInUser($this->manager)
            ->get($this->endpoint)
            ->assertStatus(200);
    }

    /** @test */
    public function a_non_manager_cannot_view_the_group_management_form()
    {
        $this->givenLoggedInUser($this->member)
            ->get($this->endpoint)
            ->assertStatus(403);

        $this->givenLoggedInUser($this->facilitator)
            ->get($this->endpoint)
            ->assertStatus(403);

        $this->givenLoggedInUser($this->other_member)
            ->get($this->endpoint)
            ->assertStatus(403);
    }

    /** @test */
    public function an_account_manager_can_add_a_group()
    {
        $payload = ['name' => 'Best Group Ever', 'facilitator_id' => $this->facilitator->id];

        $this->givenLoggedInUser($this->manager)
            ->json('POST', $this->endpoint, $payload)
            ->assertSuccessful();

        $this->assertDatabaseHas('groups', $payload);
    }

    /** @test */
    public function a_non_manager_cannot_add_a_new_group()
    {
        $payload = ['name' => 'Best Group Ever', 'facilitator_id' => $this->facilitator->id];

        $this->givenLoggedInUser($this->member)
            ->json('POST', $this->endpoint, $payload)
            ->assertStatus(403);

        $this->givenLoggedInUser($this->facilitator)
            ->json('POST', $this->endpoint, $payload)
            ->assertStatus(403);

        $this->givenLoggedInUser($this->other_member)
            ->json('POST', $this->endpoint, $payload)
            ->assertStatus(403);
    }

    /** @test */
    public function an_account_manager_can_update_an_existing_group()
    {
        $payload = ['name' => 'Best Group Ever', 'facilitator_id' => $this->facilitator->id];

        $this->givenLoggedInUser($this->manager)
            ->json('POST', $this->endpoint, $payload)
            ->assertSuccessful();

        $this->assertDatabaseHas('groups', $payload);
    }

    /** @test */
    public function a_non_manager_cannot_update_an_existing_group()
    {
        $payload = ['name' => 'Best Group Ever', 'facilitator_id' => $this->facilitator->id];

        $this->givenLoggedInUser($this->member)
            ->json('PATCH', "/account/groups/{$this->group->slug}", $payload)
            ->assertStatus(403);

        $this->givenLoggedInUser($this->facilitator)
            ->json('PATCH', "/account/groups/{$this->group->slug}", $payload)
            ->assertStatus(403);

        $this->givenLoggedInUser($this->other_member)
            ->json('PATCH', "/account/groups/{$this->group->slug}", $payload)
            ->assertStatus(403);
    }

    /** @test */
    public function an_account_manager_can_delete_an_existing_group()
    {
        $this->givenLoggedInUser($this->manager)
            ->json('DELETE', "/account/groups/{$this->group->slug}")
            ->assertSuccessful();

        $this->assertDatabaseMissing('groups', [
            'slug' => $this->group->slug,
            'deleted_at' => null,
        ]);
    }

    /** @test */
    public function a_non_manager_cannot_delete_an_existing_group()
    {
        $this->givenLoggedInUser($this->member)
            ->json('DELETE', "/account/groups/{$this->group->slug}")
            ->assertStatus(403);

        $this->givenLoggedInUser($this->facilitator)
            ->json('DELETE', "/account/groups/{$this->group->slug}")
            ->assertStatus(403);

        $this->givenLoggedInUser($this->other_member)
            ->json('DELETE', "/account/groups/{$this->group->slug}")
            ->assertStatus(403);
    }
}
