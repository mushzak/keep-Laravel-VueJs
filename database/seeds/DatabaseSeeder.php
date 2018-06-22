<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersTableSeeder::class);
        $this->call(AccountsTableSeeder::class);
        $this->call(GroupsTableSeeder::class);
        $this->call(MembersTableSeeder::class);
        $this->call(GoalsTableSeeder::class);
        $this->call(ObjectivesTableSeeder::class);
        $this->call(CommitmentTableSeeder::class);
        $this->call(DiscussionsTableSeeder::class);
        $this->call(RepliesTableSeeder::class);
    }
}
