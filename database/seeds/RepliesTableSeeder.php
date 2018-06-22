<?php

use Illuminate\Database\Seeder;

class RepliesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $publicDiscussions = \App\Discussion::where('target_type', \App\Group::class)
            ->with('target.members', 'author')
            ->get();

        $privateDiscussions = \App\Discussion::where('target_type', \App\Member::class)
            ->with('target', 'author')
            ->get();

        // For each public group discussion, have every member in that discussion's group respond.
        foreach ($publicDiscussions as $discussion) {
            foreach ($discussion->target->members as $member) {
                factory(\App\Reply::class)->create([
                    'discussion_id' => $discussion->id,
                    'author_id' => $member->id,
                ]);
            }
        }

        // For each private discussion, have the target then the author respond.
        foreach ($privateDiscussions as $discussion) {
            factory(\App\Reply::class)->create([
                'discussion_id' => $discussion->id,
                'author_id' => $discussion->target->id,
            ]);

            factory(\App\Reply::class)->create([
                'discussion_id' => $discussion->id,
                'author_id' => $discussion->author->id,
            ]);
        }
    }
}
