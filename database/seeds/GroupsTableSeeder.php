<?php

use Illuminate\Database\Seeder;

class GroupsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $accounts = \App\Account::all();

        foreach ($accounts as $account) {
            factory(\App\Group::class, 3)->create([
                'account_id' => $account->id,
                'facilitator_id' => 2,
            ]);
        }
    }
}
