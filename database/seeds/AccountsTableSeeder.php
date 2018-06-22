<?php

use Illuminate\Database\Seeder;

class AccountsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $manager = factory(\App\User::class)->create([
            'email' => 'account.manager@example.com',
        ]);

        factory(\App\Account::class)->create([
            'manager_id' => $manager->id,
        ]);
    }
}
