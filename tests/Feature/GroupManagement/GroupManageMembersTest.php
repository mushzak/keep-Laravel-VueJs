<?php

namespace Tests\Feature\Groups;

use App\Group;
use App\Member;
use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\Traits\WithAccountSetup;

class GroupManageMembersTest extends TestCase
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

        $this->editingUrl = "/manage-members";
        $this->updatingUrl = "/manage-members/";
    }

    /** @test */
    public function a_facilitator_can_edit_the_group_profile_form()
    {
        $this->givenLoggedInUser($this->facilitator)
            ->get($this->editingUrl)
            ->assertSuccessful();
    }

    /** @test */
    public function non_facilitators_cannot_manage_members_form()
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
    public function a_facilitator_can_change_the_status_of_a_member()
    {

        $this->givenLoggedInUser($this->facilitator)
            ->attemptMemberChange()
            ->assertStatus(204);

        $this->assertDatabaseHas('members', [
            'id' => $this->member->activeGroupMember->id ,
            'status' => 'inactivated',
            ]);

    }

    /** @test */
    public function non_facilitators_cannot_change_the_status_of_a_member()
    {
        $this->givenLoggedInUser($this->member)
            ->attemptMemberChange()
            ->assertStatus(403);

        $this->givenLoggedInUser($this->manager)
            ->attemptMemberChange()
            ->assertStatus(403);

        $this->givenLoggedInUser($this->other_member)
            ->attemptMemberChange()
            ->assertStatus(403);
    }

    /** @test */
    public function a_facilitator_can_delete_a_member()
    {
        $this->givenLoggedInUser($this->facilitator)
            ->attemptMemberDelete($this->member->activeGroupMember)
            ->assertStatus(302);

            $this->assertDatabaseMissing('members', [
            'id' => $this->member->activeGroupMember->id ,
            'deleted_at'=>null,
            ]);
    }

    /** @test */
    public function active_group_resets_when_member_is_deleted()
    {
        //member starts out with 2 groups
        $user_of_member=$this->member;

        $active_group_id=$user_of_member->active_group_id;

        //remove from first group
        $this->givenLoggedInUser($this->facilitator)
            ->attemptMemberDelete($this->member->activeGroupMember)
            ->assertStatus(302);

        $this->assertDatabaseMissing('users', [
            'id' => $user_of_member->id ,
            'active_group_id'=>$active_group_id,
            ]);
    }

    /** @test */
    public function member_can_be_deleted_from_last_group()
    {

        $active_group_id=$this->member->active_group_id;
        $member_1=$this->member->members->first();
        $member_2=$this->member->members->last();

        //remove from first group
        $this->givenLoggedInUser($this->facilitator)
            ->attemptMemberDelete($member_1)
            ->assertStatus(302);

        $this->givenLoggedInUser($this->other_facilitator)
            ->get($this->editingUrl)
            ->assertSuccessful();

        //remove member from other group
        $this->givenLoggedInUser($this->other_facilitator)
            ->attemptMemberDelete($this->other_member->activeGroupMember)
            ->assertStatus(302);

        //remove from second group
        $this->givenLoggedInUser($this->other_facilitator)
            ->attemptMemberDelete($member_2)
            ->assertStatus(302);

        //NOTE this only removes from database, the events are not fired in unit tests and the active group is not being updated
    }

    /** @test */
    public function non_facilitators_cannot_delete_a_member()
    {
        $this->givenLoggedInUser($this->member)
            ->attemptMemberDelete($this->member->activeGroupMember)
            ->assertStatus(403);

        $this->givenLoggedInUser($this->manager)
            ->attemptMemberDelete($this->member->activeGroupMember)
            ->assertStatus(403);

        $this->givenLoggedInUser($this->other_member)
            ->attemptMemberDelete($this->member->activeGroupMember)
            ->assertStatus(403);
    }

    /**
     * Attempts to update member 
     *
     * @param array $overrides
     * @return \Illuminate\Foundation\Testing\TestResponse
     */
    protected function attemptMemberChange()
    {
        $payload = [
                'status' => 'inactivated',
            ];

        return $this->patch($this->updatingUrl.$this->member->activeGroupMember->id, $payload);

    }

    /**
     * Attempts to delete member 
     *
     * @param array $overrides
     * @return \Illuminate\Foundation\Testing\TestResponse
     */
    protected function attemptMemberDelete(Member $member)
    {
        return $this->delete($this->updatingUrl.$member->id);
    }
}
