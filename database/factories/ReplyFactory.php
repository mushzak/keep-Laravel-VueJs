<?php

use Faker\Generator as Faker;

/* @var Illuminate\Database\Eloquent\Factory $factory */

$factory->define(App\Reply::class, function (Faker $faker) {
    return [
        'discussion_id' => factory(App\Discussion::class),
        'author_id' => factory(App\Member::class),
        'body' => $faker->paragraphs(3, true),
        'is_urgent' => false,
    ];
});

$factory->state(App\Reply::class, 'urgent', [
    'is_urgent' => true,
]);