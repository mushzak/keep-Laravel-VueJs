<?php

use Illuminate\Database\Seeder;

class ObjectivesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $goals = \App\Goal::all();

        foreach ($goals as $goal) {
            // Create objectives
            factory(\App\Objective::class, 4)->create(['goal_id' => $goal->id]);

            // Create completed objectives
            factory(\App\Objective::class, 2)->states('completed')->create(['goal_id' => $goal->id]);

            // Create overdue objectives
            factory(\App\Objective::class, 2)->states('overdue')->create(['goal_id' => $goal->id]);
        }
    }
}
