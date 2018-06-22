<?php

namespace Tests\Traits;

use App\Group;
use App\Member;
use App\User;

trait WithGroupMembership
{
    /** @var  Group */
    protected $group;

    /** @var  User */
    protected $user;

    /** @var  Member */
    protected $member;

    /**
     * Adds factories for group membership to the given class.
     */
    public function addGroupMembership()
    {
        $this->group = factory(Group::class)->create();
        $this->user = factory(User::class)->create();
        $this->member = factory(Member::class)->create([
            'group_id' => $this->group->id,
            'user_id' => $this->user->id,
        ]);
    }
}