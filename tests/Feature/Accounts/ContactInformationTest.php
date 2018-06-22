<?php

namespace Tests\Feature\Groups;

use App\Account;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\Traits\WithAccountSetup;

class ContactInformationTest extends TestCase
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

        $this->endpoint = "/account/contact";
    }

    /** @test */
    public function an_account_manager_can_view_the_contact_information_form()
    {
        $this->givenLoggedInUser($this->manager)
            ->get($this->endpoint)
            ->assertStatus(200);
    }

    /** @test */
    public function non_account_manager_cannot_view_the_contact_information_form()
    {
        // A member with no access rights cannot view the contact information form
        $this->givenLoggedInUser($this->member)
            ->get($this->endpoint)
            ->assertStatus(403);

        //  A user with only facilitator rights cannot view the contact information form
        $this->givenLoggedInUser($this->facilitator)
            ->get($this->endpoint)
            ->assertStatus(403);

        // A member of a different group cannot view the contact information form
        $this->givenLoggedInUser($this->other_member)
            ->get($this->endpoint)
            ->assertStatus(403);
    }

    /** @test */
    public function an_account_manager_can_update_the_accounts_contact_information()
    {
        $this->givenLoggedInUser($this->manager)
            ->attemptContactChange()
            ->assertSuccessful();
    }

    /** @test */
    public function a_non_account_manager_cannot_update_the_accounts_contact_information()
    {
        $this->givenLoggedInUser($this->member)
            ->attemptContactChange()
            ->assertStatus(403);

        $this->givenLoggedInUser($this->facilitator)
            ->attemptContactChange()
            ->assertStatus(403);

        $this->givenLoggedInUser($this->other_member)
            ->attemptContactChange()
            ->assertStatus(403);
    }

    /** @test */
    public function an_account_name_is_required()
    {
        $this->givenLoggedInUser($this->manager)
            ->attemptContactChange(['name' => ''])
            ->assertRedirect();
    }

    /** @test */
    public function an_accounts_business_name_is_optional()
    {
        $this->givenLoggedInUser($this->manager)
            ->attemptContactChange(['business_name' => ''])
            ->assertSuccessful();
    }

    /** @test */
    public function an_accounts_phone_is_optional()
    {
        $this->givenLoggedInUser($this->manager)
            ->attemptContactChange(['phone' => ''])
            ->assertSuccessful();
    }

    /** @test */
    public function an_accounts_email_is_optional()
    {
        $this->givenLoggedInUser($this->manager)
            ->attemptContactChange(['email' => ''])
            ->assertSuccessful();
    }

    /** @test */
    public function an_account_email_must_be_formatted_as_an_email()
    {
        $this->givenLoggedInUser($this->manager)
            ->attemptContactChange(['email' => 'not an email'])
            ->assertRedirect();
    }

    /**
     * Attempts to update account information
     *
     * @param array $overrides
     * @return \Illuminate\Foundation\Testing\TestResponse
     */
    protected function attemptContactChange(array $overrides = [])
    {
        $account = $this->make(Account::class);

        $this->payload = array_merge([
            'name' => $account->name,
            'business_name' => $account->business_name,
            'phone' => $account->phone,
            'email' => $account->email,
        ], $overrides);

        return $this->post($this->endpoint, $this->payload);
    }
}
