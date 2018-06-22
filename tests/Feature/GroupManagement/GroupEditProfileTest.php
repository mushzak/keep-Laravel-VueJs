<?php

namespace Tests\Feature\Groups;

use App\Group;
use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\Traits\WithAccountSetup;

class GroupEditProfileTest extends TestCase
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

        $this->editingUrl = "/groups/{$this->group->slug}/edit";
        $this->updatingUrl = "/groups/{$this->group->slug}";
    }

    /** @test */
    public function a_facilitator_can_edit_the_group_profile_form()
    {
        $this->givenLoggedInUser($this->facilitator)
            ->get($this->editingUrl)
            ->assertSuccessful();
    }

    /** @test */
    public function non_facilitators_cannot_edit_the_group_profile_form()
    {
        $this->givenLoggedInUser($this->member)
            ->get($this->editingUrl)
            ->assertStatus(403);

        $this->givenLoggedInUser($this->manager)
            ->get($this->editingUrl)
            ->assertStatus(403);

        $this->givenLoggedInUser($this->other_member)
            ->get($this->editingUrl)
            ->assertStatus(403);
    }

    /** @test */
    public function a_facilitator_can_update_the_group_profile()
    {
        $this->givenLoggedInUser($this->facilitator)
            ->attemptGroupProfileChange()
            ->assertSuccessful();
    }

    /** @test */
    public function non_facilitators_cannot_update_the_group_profile()
    {
        $this->givenLoggedInUser($this->member)
            ->attemptGroupProfileChange()
            ->assertStatus(403);

        $this->givenLoggedInUser($this->manager)
            ->attemptGroupProfileChange()
            ->assertStatus(403);

        $this->givenLoggedInUser($this->other_member)
            ->attemptGroupProfileChange()
            ->assertStatus(403);
    }

    /** @test */
    public function the_name_field_is_required_to_update_the_group_profile()
    {
        $this->givenLoggedInUser($this->facilitator)
            ->attemptGroupProfileChange(['name' => ''])
            ->assertSessionHasErrors('name');
    }

    /** @test */
    public function the_avatar_field_when_updating_the_group_profile_must_be_an_image()
    {
        $this->givenLoggedInUser($this->facilitator)
            ->attemptGroupProfileChange(['avatar' => 'auburn'])
            ->assertSessionHasErrors('avatar');
    }

    /**
     * Attempts to update account information
     *
     * @param array $overrides
     * @return \Illuminate\Foundation\Testing\TestResponse
     */
    protected function attemptGroupProfileChange(array $overrides = [])
    {
        $group = $this->make(Group::class);

        $this->payload = array_merge([
            'name' => $group->name,
            'avatar' => UploadedFile::fake()->image('asdf.jpg', 200, 200),
            'purpose' => $group->purpose,
            'slogan' => $group->slogan,
            'location' => $group->location,
            'contact' => $group->contact,
            'description' => $group->description,
        ], $overrides);

        return $this->patch($this->updatingUrl, $this->payload);
    }
}
