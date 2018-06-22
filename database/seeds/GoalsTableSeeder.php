<?php

use Illuminate\Database\Seeder;

class GoalsTableSeeder extends Seeder
{
    /**
     * Run the database seeds for goals.
     *
     * @return void
     */
    public function run()
    {
        $members = \App\Member::all();

        foreach ($members as $member) {
            factory(\App\Goal::class)->create(['member_id' => $member->id]);
        }
    }
}
