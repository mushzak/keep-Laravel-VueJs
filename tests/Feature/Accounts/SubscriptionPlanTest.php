<?php

namespace Tests\Feature\Groups;

use App\Account;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\Traits\WithAccountSetup;

class SubscriptionPlanTest extends TestCase
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

        $this->endpoint = "/account/subscriptions";
    }

    /** @test */
    public function an_account_manager_can_view_the_subscription_plan_form()
    {
        $this->givenLoggedInUser($this->manager)
            ->get($this->endpoint)
            ->assertStatus(200);
    }

    /** @test */
    public function a_non_manager_cannot_view_the_subscription_plan_form()
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
    public function an_account_manager_can_update_the_subscription_plan()
    {
        $this->givenLoggedInUser($this->manager)
            ->attemptPlanChange()
            ->assertRedirect();
    }
    
    /** @test */
    public function the_subscription_plan_is_required()
    {
        $this->givenLoggedInUser($this->manager)
            ->attemptPlanChange(['plan' => ''])
            ->assertSessionHasErrors('plan');
    }
    
    /** @test */
    public function the_subscription_plan_must_be_one_of_the_expected_values()
    {
        $this->givenLoggedInUser($this->manager)
            ->attemptPlanChange(['plan' => 'auburn'])
            ->assertSessionHasErrors('plan');
    }

    /** @test */
    public function non_managers_cannot_update_the_subscription_plan()
    {
        $this->givenLoggedInUser($this->member)
            ->attemptPlanChange()
            ->assertStatus(403);

        $this->givenLoggedInUser($this->facilitator)
            ->attemptPlanChange()
            ->assertStatus(403);

        $this->givenLoggedInUser($this->other_member)
            ->attemptPlanChange()
            ->assertStatus(403);
    }
    
    /**
     * Attempts to update account information
     *
     * @param array $overrides
     * @return \Illuminate\Foundation\Testing\TestResponse
     */
    protected function attemptPlanChange(array $overrides = [])
    {
        $account = $this->make(Account::class);

        $this->payload = array_merge([
            'plan' => $account->plan,
        ], $overrides);

        return $this->post($this->endpoint, $this->payload);
    }
}
