<?php

use Illuminate\Database\Seeder;

class MembersTableSeeder extends Seeder
{
    /**
     * Gives every membership into the first group.
     *
     * @return void
     */
    public function run()
    {
        $users = \App\User::all();
        $group = \App\Group::findOrFail(1);

        foreach ($users as $user) {
            factory(\App\Member::class)->create([
                'group_id' => $group->id,
                'user_id' => $user->id,
            ]);
        }
    }
}
