<?php

namespace Tests\Feature\Groups;

use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\Traits\WithAccountSetup;

class BrandingTest extends TestCase
{
    use DatabaseMigrations;
    use WithAccountSetup;

    /**
     * Setup the test environment.
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();

        $this->addAccount();

        $this->endpoint = "/account/branding";
    }

    /** @test */
    public function an_account_manager_can_view_the_branding_form()
    {
        $this->givenLoggedInUser($this->manager)
            ->get($this->endpoint)
            ->assertStatus(200);
    }

    /** @test */
    public function a_non_manager_cannot_view_the_branding_form()
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
    public function an_account_manager_can_update_the_branding()
    {
        $this->givenLoggedInUser($this->manager)
            ->attemptBrandingChange()
            ->assertSuccessful();
    }

    /** @test */
    public function the_custom_branding_field_is_required()
    {
        $this->givenLoggedInUser($this->manager)
            ->attemptBrandingChange(['use_custom_branding' => ''])
            ->assertSessionHasErrors('use_custom_branding');
    }

    /** @test */
    public function the_custom_branding_field_must_be_boolean()
    {
        $this->givenLoggedInUser($this->manager)
            ->attemptBrandingChange(['use_custom_branding' => 'auburn'])
            ->assertSessionHasErrors('use_custom_branding');
    }

    /** @test */
    public function the_custom_logo_field_must_be_a_file()
    {
        $this->givenLoggedInUser($this->manager)
            ->attemptBrandingChange(['custom_logo' => 'auburn'])
            ->assertSessionHasErrors('custom_logo');
    }

    /** @test */
    public function non_managers_cannot_update_the_branding()
    {
        $this->givenLoggedInUser($this->member)
            ->attemptBrandingChange()
            ->assertStatus(403);

        $this->givenLoggedInUser($this->facilitator)
            ->attemptBrandingChange()
            ->assertStatus(403);

        $this->givenLoggedInUser($this->other_member)
            ->attemptBrandingChange()
            ->assertStatus(403);
    }

    /**
     * Attempts to update account information
     *
     * @param array $overrides
     * @return \Illuminate\Foundation\Testing\TestResponse
     */
    protected function attemptBrandingChange(array $overrides = [])
    {
        $this->payload = array_merge([
            'use_custom_branding' => true,
            'custom_logo' => UploadedFile::fake()->image('asdf.jpg', 200, 200),
        ], $overrides);

        return $this->post($this->endpoint, $this->payload);
    }
}
