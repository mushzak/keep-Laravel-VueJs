<?php

namespace Tests\Unit;

use App\Group;
use App\Member;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class MemberTest extends TestCase
{
    use DatabaseTransactions;

    public function setUp()
    {
        parent::setUp();

        /*
         * SQLITE does not have the DATE_ADD method, and so the test will incorrectly fail.
         * We need to use database transactions for the check in member unit test as a result and bolt up to a MySQL server.
         */
        //config(['database.default' => 'mysql']);
        //config(['database.connections.mysql.database' => 'gantry']);
    }

    /** @test */
    public function a_list_of_members_can_be_retrieved_each_where_the_associated_user_has_not_accessed_the_platform_within_a_given_period()
    {
        $group = $this->create(Group::class, ['check_in_interval' => 7]);

        $justArrivedMember = $this->create(Member::class, ['group_id' => $group->id]);
        $onTimeMember = $this->create(Member::class, ['group_id' => $group->id]);
        $lateMember = $this->create(Member::class, ['group_id' => $group->id]);
        $neverArrivedMember = $this->create(Member::class, ['group_id' => $group->id]);

        $justArrivedMember->user->update(['last_checked_in_at' => Carbon::now()]);
        $onTimeMember->user->update(['last_checked_in_at' => Carbon::now()->subDays(7)->addMinutes(1)]);
        $lateMember->user->update(['last_checked_in_at' => Carbon::now()->subDays(8)]);
        $neverArrivedMember->user->update(['last_checked_in_at' => null]);

        /** @var \Illuminate\Database\Eloquent\Collection $listOfLateMembers */
        $listOfLateMembers = $group->members()->lateForCheckIn()->get();

        /*
         * We want to see members in the list who are late or never showed up.
         * We don't want to see members who arrived now (and are above and beyond their requirements) or
         * are doing the absolute minimum asked of them (aka are "on time").
         */
        $this->assertFalse($listOfLateMembers->contains($justArrivedMember));
        $this->assertFalse($listOfLateMembers->contains($onTimeMember));
        $this->assertTrue($listOfLateMembers->contains($lateMember));
        $this->assertTrue($listOfLateMembers->contains($neverArrivedMember));
    }
}
