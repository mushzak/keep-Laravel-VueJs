<?php

use Illuminate\Database\Seeder;

class DiscussionsTableSeeder extends Seeder
{
    /**
     * Have each member send one discussion to the group and one to each member.
     *
     * @return void
     */
    public function run()
    {
        $members = \App\Member::with('group')->get();

        foreach ($members as $author) {
            // Send discussion to group.
            factory(\App\Discussion::class)->create([
                'author_id' => $author->id,
                'target_id' => $author->group->id,
                'target_type' => get_class($author->group),
            ]);

            // Send discussion to each member
            foreach ($members as $target) {
                factory(\App\Discussion::class)->create([
                    'author_id' => $author->id,
                    'target_id' => $target->id,
                    'target_type' => get_class($target),
                ]);
            }
        }
    }
}
