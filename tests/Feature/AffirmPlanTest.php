<?php

namespace Tests\Feature;

use App\Goal;
use App\Process;
use App\Objective;
use App\User;
use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Traits\WithGroupMembership;

class AffirmPlanTest extends TestCase
{
    use RefreshDatabase, WithGroupMembership;

    /** @var Goal */
    protected $goal;

    /** @var Goal */
    protected $objective;

    public function setUp()
    {
        parent::setUp();

        $this->addGroupMembership();

        $this->goal = $this->create(Goal::class, [
            'member_id' => $this->member->id,
        ]);

        $this->objective = $this->create(Objective::class, [
            'goal_id' => $this->goal->id,
        ]);
    }

    /** @test */
    public function unauthenticated_users_cannot_affirm_their_plan()
    {
        $this->get("/groups/{$this->group->slug}/profiles/{$this->member->id}/plan")
            ->assertRedirect('/login');
    }

    /** @test */
    public function non_group_members_cannot_affirm_their_plan()
    {
        $this->givenLoggedInUser($this->create(User::class))
            ->get("/groups/{$this->group->slug}/plan")
            ->assertStatus(404);
    }

    /** @test */
    public function group_members_can_affirm_their_big_picture()
    {
        $this->givenLoggedInUser($this->user);

        $this->json('PATCH', "/members/{$this->member->id}/big-picture", [
            'vision' => 'veni',
            'values' => 'vidi',
            'mission' => 'vici',
        ]);

        $this->assertDatabaseHas('members', [
            'vision' => 'veni',
            'values' => 'vidi',
            'mission' => 'vici',
        ]);
    }

    /** @test */
    public function group_members_can_affirm_their_goals_and_objectives()
    {
        $this->givenLoggedInUser($this->user);

        $oneYearAgo = Carbon::now()->subYear();

        $this->goal->update([
            'created_at' => $oneYearAgo,
            'updated_at' => $oneYearAgo,
        ]);

        $this->json('PATCH', "/members/{$this->member->id}/goals/{$this->goal->id}", [
        ]);

        $this->assertDatabaseHas('goals', [
            'id' => $this->goal->id,
            'updated_at' => $oneYearAgo,
        ]);
    }

    /** @test */
    public function group_members_can_mark_objectives_as_complete()
    {
        $this->givenLoggedInUser($this->user);

        $this->objective->update([
            'completed_at' => null,
        ]);

        $this->json('PATCH', "/members/{$this->member->id}/objectives/{$this->objective->id}/completed", [
        ]);

        $this->assertTrue(!$this->objective->fresh()->completed_at==null);
    }

    /** @test */
    public function group_members_can_mark_objectives_as_not_complete()
    {
        $this->givenLoggedInUser($this->user);

        $this->objective->update([
            'completed_at' => \Carbon\Carbon::now(),
        ]);

        $this->json('PATCH', "/members/{$this->member->id}/objectives/{$this->objective->id}/completed", [

        ]);

        $this->assertDatabaseHas('objectives', [
            'id' => $this->objective->id,
            'completed_at' => null,
        ]);
    }

    /** @test */
    public function group_members_can_affirm_their_personal_motivations()
    {
        $this->givenLoggedInUser($this->user);

        $this->json('PATCH', "/members/{$this->member->id}/personal-motivation", [
            'why' => 'To beat Auburn in 2017',
            'consequences' => 'Auburn will lose',
        ]);

        $this->assertDatabaseHas('members', [
            'id' => $this->member->id,
            'why' => 'To beat Auburn in 2017',
            'consequences' => 'Auburn will lose',
        ]);
    }
}
