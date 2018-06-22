<?php

namespace Tests\Unit;

use App\Account;
use App\Group;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GroupTest extends TestCase
{
    use RefreshDatabase;

    /** @var Group */
    public $group;

    public function setUp()
    {
        parent::setUp();

        $this->group = factory(Group::class)->create();
    }

    /** @test */
    public function a_group_belong_to_an_account()
    {
        $this->assertInstanceOf(Account::class, $this->group->account);
    }

    /** @test */
    public function a_group_belongs_to_a_facilitator()
    {
        $this->assertInstanceOf(User::class, $this->group->facilitator);
    }

    /** @test */
    public function a_group_belongs_to_many_users()
    {
        $user = factory(User::class)->create();

        $this->group->users()->attach($user);

        $this->assertTrue($this->group->users->contains($user));
    }
}
