<?php

namespace Tests\Unit;

use App\Account;
use App\Group;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AccountTest extends TestCase
{
    use RefreshDatabase;

    public $account;

    public function setUp()
    {
        parent::setUp();

        $this->account = factory(Account::class)->create();
    }

    /** @test */
    public function an_account_has_many_groups()
    {
        $group = factory(Group::class)->create(['account_id' => $this->account->id]);

        $this->assertTrue($this->account->groups->contains($group));
    }

    /** @test */
    public function an_account_belongs_to_a_manager()
    {
        $this->assertInstanceOf(User::class, $this->account->manager);
    }
}
