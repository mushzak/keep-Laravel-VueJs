<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\User::class)->create([
            'email' => 'example@example.com'
        ]);

        factory(\App\User::class)->create([
            'email' => 'facilitator@example.com',
        ]);
 
        factory(\App\User::class, 5)->create();
    }
}
