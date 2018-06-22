<?php

namespace Tests\Feature;

use App\User;
use App\Group;
use App\Member;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Traits\WithGroupMembership;

class ProfileTest extends TestCase
{
    use RefreshDatabase, WithGroupMembership;

    public function setUp()
    {
        parent::setUp();

        $this->addGroupMembership();

        $this->other_group = $this->create(Group::class);
        $this->other_user = $this->create(User::class);
        $this->other_member = $this->create(Member::class, [
            'group_id' => $this->other_group->id,
            'user_id' => $this->other_user->id
        ]);
    }

    /** @test */
    public function unauthenticated_users_cannot_view_their_profile()
    {
        $this->get("/groups/{$this->group->slug}/profiles/{$this->member->id}")
            ->assertRedirect('/login');
    }

    /** @test */
    public function non_group_members_cannot_view_their_profile()
    {
        $this->givenLoggedInUser($this->other_user)
            ->get("/groups/{$this->group->slug}/profiles/{$this->member->id}")
            ->assertStatus(403);
    }

    /** @test */
    public function group_members_can_save_their_personal_background()
    {
        $this->givenLoggedInUser($this->user);

        $this->json('PATCH', "/members/{$this->member->id}/personal-background", [
            'personal_bio' => 'New personal bio 1234',
            'personal_avatar' => UploadedFile::fake()->image('asdf.jpg', 200, 200),
        ])->assertSuccessful();

        $this->assertDatabaseHas('members', [
            'personal_bio' => 'New personal bio 1234',
        ]);
    }

    /** @test */
    public function group_members_can_save_their_professional_background()
    {
        $this->givenLoggedInUser($this->user);

        $this->json('PATCH', "/members/{$this->member->id}/professional-background", [
            'company_name' => 'New Company Name',
            'business_bio' => 'New Professional Bio',
            'business_avatar' => UploadedFile::fake()->image('asdf.jpg', 200, 200),
        ]);

        $this->assertDatabaseHas('members', [
            'company_name' => 'New Company Name',
            'business_bio' => 'New Professional Bio',
        ]);
    }

    /** @test */
    public function group_members_can_save_their_contact_information()
    {
        $this->givenLoggedInUser($this->user);

        $this->json('PATCH', "/members/{$this->member->id}/contact", [
            'email' => 'newemail@example.com',
            'phone_1' => '256-555-1212',
            'phone_2' => '256-555-2323',
            'other' => 'Other POCs ...',
        ]);

        $this->assertDatabaseHas('members', [
            'email' => 'newemail@example.com',
        ]);

        $this->assertDatabaseHas('members', [
            'phone_1' => '256-555-1212',
            'phone_2' => '256-555-2323',
            'other' => 'Other POCs ...',
        ]);
    }
}
