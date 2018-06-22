<?php

namespace Tests\Traits;

use App\Account;
use App\Group;
use App\Member;
use App\User;

trait WithAccountSetup
{
    /** @var  Account */
    protected $account;

    /** @var  Group */
    protected $group;

    /** @var  User */
    protected $member;

    /** @var  User */
    protected $facilitator;

    /** @var  User */
    protected $manager;

    /** @var  User */
    protected $other_manager;

    /** @var  Group */
    protected $other_group;

    /** @var  User */
    protected $other_member;

    /** @var  User */
    protected $other_facilitator;


    /**
     * Adds factories for group membership to the given class.
     */
    public function addAccount()
    {
        //setup an account, with a group, facilitator, manager, and member
        //also creates "other_group" and "other_member" for that other_group

        $this->manager = $this->create(User::class);
        $this->other_manager = $this->create(User::class);
        $this->facilitator = $this->create(User::class);
        $this->other_facilitator = $this->create(User::class);
        $this->member = $this->create(User::class);
        $this->other_member = $this->create(User::class);

        $this->account = $this->create(Account::class, 
                ['manager_id' => $this->manager->id,
                 'name'=>'New Account']);

        $this->other_account = $this->create(Account::class, 
                ['manager_id' => $this->other_manager->id,
                 'name'=>'Other Account']);

        $this->group = $this->create(Group::class, 
                ['facilitator_id' => $this->facilitator->id,
                 'account_id'=> $this->account->id,
                'name'=>'New Group']
        );

        //create other group
        $this->other_group = $this->create(Group::class, 
                ['facilitator_id' => $this->other_facilitator->id,
                 'account_id'=> $this->other_account->id,
                'name'=>'Other Group']);

        //adds persons to group
        \App\Member::create([
            'user_id' => $this->member->id,
            'group_id' => $this->group->id,]);

        \App\Member::create([
            'user_id' => $this->member->id,
            'group_id' => $this->other_group->id,]);

        \App\Member::create([
            'user_id' => $this->facilitator->id,
            'group_id' => $this->group->id,]);
        \App\Member::create([
            'user_id' => $this->manager->id,
            'group_id' => $this->group->id,]);

        \App\Member::create([
            'user_id' => $this->other_member->id,
            'group_id' => $this->other_group->id,]);

        \App\Member::create([
            'user_id' => $this->other_facilitator->id,
            'group_id' => $this->other_group->id,]);

        \App\Member::create([
            'user_id' => $this->other_manager->id,
            'group_id' => $this->other_group->id,]);


        //set active group
        $this->member->active_group_id=$this->group->id;
        $this->manager->active_group_id=$this->group->id;
        $this->facilitator->active_group_id=$this->group->id;
        $this->other_member->active_group_id=$this->other_group->id;
        $this->other_manager->active_group_id=$this->other_group->id;
        $this->other_facilitator->active_group_id=$this->other_group->id;
    }
}