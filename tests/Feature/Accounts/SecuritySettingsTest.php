<?php

namespace Tests\Feature\Groups;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\Traits\WithAccountSetup;

class SecuritySettingsTest extends TestCase
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

        $this->endpoint = "/account/security";
    }

    /** @test */
    public function an_account_manager_can_view_the_security_settings_form()
    {
        $this->givenLoggedInUser($this->manager)
            ->get($this->endpoint)
            ->assertStatus(200);
    }

    /** @test */
    public function a_non_manager_cannot_view_the_security_settings_form()
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
    public function an_account_manager_can_update_the_security_settings()
    {
        $this->givenLoggedInUser($this->manager)
            ->attemptSettingsChange()
            ->assertSuccessful();
    }

    /** @test */
    public function the_security_settings_is_required()
    {
        $this->givenLoggedInUser($this->manager)
            ->attemptSettingsChange(['is_using_2fa' => ''])
            ->assertSessionHasErrors('is_using_2fa');
    }

    /** @test */
    public function the_security_settings_must_be_boolean()
    {
        $this->givenLoggedInUser($this->manager)
            ->attemptSettingsChange(['is_using_2fa' => 'auburn'])
            ->assertSessionHasErrors('is_using_2fa');
    }

    /** @test */
    public function non_managers_cannot_update_the_security_settings()
    {
        $this->givenLoggedInUser($this->member)
            ->attemptSettingsChange()
            ->assertStatus(403);

        $this->givenLoggedInUser($this->facilitator)
            ->attemptSettingsChange()
            ->assertStatus(403);

        $this->givenLoggedInUser($this->other_member)
            ->attemptSettingsChange()
            ->assertStatus(403);
    }

    /**
     * Attempts to update account information
     *
     * @param array $overrides
     * @return \Illuminate\Foundation\Testing\TestResponse
     */
    protected function attemptSettingsChange(array $overrides = [])
    {
        $this->payload = array_merge([
            'is_using_2fa' => true,
        ], $overrides);

        return $this->post($this->endpoint, $this->payload);
    }
}
