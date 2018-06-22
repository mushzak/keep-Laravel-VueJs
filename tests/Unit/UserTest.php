<?php

namespace Tests\Unit;

use App\Group;
use App\User;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /** @var  User */
    public $user;

    public function setUp()
    {
        parent::setUp();

        $this->user = factory(User::class)->create();
    }

    /** @test */
    public function setting_a_password_automatically_hashes_it()
    {
        $this->user->password = 'newpassword';

        $this->assertNotEquals('newpassword', $this->user->password);
        $this->assertTrue(Hash::check('newpassword', $this->user->password));
    }

    /** @test */
    public function a_user_can_facilitate_many_groups()
    {
        $group = factory(Group::class)->create(['facilitator_id' => $this->user->id]);

        $this->assertTrue($this->user->facilitating->contains($group));
    }

    /** @test */
    public function a_user_belongs_to_many_groups()
    {
        $group = factory(Group::class)->create();

        $this->user->groups()->attach($group);

        $this->assertTrue($this->user->groups->contains($group));
    }
}
