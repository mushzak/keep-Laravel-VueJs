<?php

use Illuminate\Database\Seeder;

class CommitmentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $members = \App\Member::with('group')->get();

        foreach ($members as $member) {
            // Create commitments for process cycle leading up to and including
            // the current process cycle
            foreach (range(1, $member->group->current_process - 1) as $process_number) {
                factory(\App\Commitment::class)->create([
                    'member_id' => $member->id,
                    'process_number' => $process_number,
                ]);
            }

            // Make sure the last commitment is incomplete
            factory(\App\Commitment::class)->states(['incomplete'])->create([
                'member_id' => $member->id,
                'process_number' => $member->group->current_process,
            ]);
        }
    }
}
