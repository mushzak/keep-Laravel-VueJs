<?php

namespace Tests\Feature\Groups;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\Traits\WithAccountSetup;

class CreateAccountTest extends TestCase
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

        $this->endpoint = "/register";
    }

    /** @test */
    public function authenticated_users_cannot_view_the_registration_form()
    {
        $this->givenLoggedInUser()
            ->get($this->endpoint)
            ->assertRedirect();
    }

    /** @test */
    public function unauthenticated_users_can_view_the_registration_form()
    {
    	$this->get($this->endpoint)
            ->assertSuccessful();
    }

    /** @test */
    public function unauthenticated_users_can_create_a_new_account()
    {
        $this->withoutExceptionHandling();

        $this->attemptRegistration()
            ->assertRedirect();

        $this->assertDatabaseHas('users', [
            'name' => $this->user->name,
            'email' => $this->user->email,
        ]);

        $this->assertDatabaseHas('groups', [
            'name' => $this->user->name . " Group",
        ]);

        $this->assertDatabaseHas('accounts', [
            'name' => $this->user->name,
        ]);
    }

    /** @test */
    public function authenticated_users_cannot_create_a_new_account()
    {
        $this
            ->givenLoggedInUser()
            ->attemptRegistration()
            ->assertRedirect();

        $this->assertDatabaseMissing('users', [
            'name' => $this->user->name,
            'email' => $this->user->email,
        ]);
    }

    /** @test */
    public function a_new_user_must_provide_a_name_during_registration()
    {
    	$this->attemptRegistration(['name' => ''])
            ->assertSessionHasErrors('name');
    }

    /** @test */
    public function a_new_user_must_provide_an_email_during_registration()
    {
        $this->attemptRegistration(['email' => ''])
            ->assertSessionHasErrors('email');
    }

    /** @test */
    public function a_new_users_email_must_be_formatted_as_an_email_during_registration()
    {
        $this->attemptRegistration(['email' => 'john@@doe.com'])
            ->assertSessionHasErrors('email');
    }

    /** @test */
    public function a_new_users_email_must_be_unique_during_registration()
    {
        $firstUser = $this->create(User::class, ['email' => 'notunique@example.com']);

        $this->attemptRegistration(['email' => 'notunique@example.com'])
            ->assertSessionHasErrors('email');
    }

    /** @test */
    public function a_new_user_must_provide_a_password_during_registration()
    {
        $this->attemptRegistration(['password' => ''])
            ->assertSessionHasErrors('password');
    }

    /** @test */
    public function a_new_users_password_must_be_at_least_8_characters_during_registration()
    {
        $this->attemptRegistration(['password' => '1234567', 'password_confirmation' => '1234567'])
            ->assertSessionHasErrors('password');
    }

    /** @test */
    public function a_new_user_must_provide_a_matching_password_confirmation_during_registration()
    {
        $this->attemptRegistration(['password_confirmation' => null])
            ->assertSessionHasErrors('password');
    }

    /**
     * Attempts to update account information
     *
     * @param array $overrides
     * @return \Illuminate\Foundation\Testing\TestResponse
     */
    protected function attemptRegistration(array $overrides = [])
    {
        $this->user = $this->make(User::class);

        $this->payload = array_merge([
            'name' => $this->user->name,
            'email' => $this->user->email,
            'password' => 'secretsecret',
            'password_confirmation' => 'secretsecret',
        ], $overrides);

        return $this->post($this->endpoint, $this->payload);
    }
}
