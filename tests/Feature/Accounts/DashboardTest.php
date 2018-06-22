<?php

namespace Tests\Feature\Groups;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\Traits\WithAccountSetup;

class DashboardTest extends TestCase
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

        $this->endpoint = "/account";
    }

    /** @test */
    public function an_account_manager_can_view_their_accounts_dashboard()
    {
        $this->givenLoggedInUser($this->manager)
            ->get($this->endpoint)
            ->assertSuccessful();
    }

    /** @test */
    public function a_non_account_manager_cannot_view_the_accounts_dashboard()
    {
        // A member with no access rights cannot view the account dashboard
        $this->givenLoggedInUser($this->member)
            ->get($this->endpoint)
            ->assertStatus(403);

        // A user with only facilitator rights cannot view the account dashboard
        $this->givenLoggedInUser($this->facilitator)
            ->get($this->endpoint)
            ->assertStatus(403);

        // A member of a different group cannot view the account dashboard
        $this->givenLoggedInUser($this->other_member)
            ->get($this->endpoint)
            ->assertStatus(403);
    }

    /** @test */
    public function the_account_dashboard_shows_the_account_name()
    {
        $this->givenLoggedInUser($this->manager)
            ->get($this->endpoint)
            ->assertSeeText(e($this->account->name));
    }

    /** @test */
    public function the_account_dashboard_shows_a_list_of_action_items()
    {
        $this->givenLoggedInUser($this->manager)
            ->get($this->endpoint)
            ->assertSeeText(e('You need to update'));
    }
}
