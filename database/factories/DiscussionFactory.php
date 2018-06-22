<?php

use Faker\Generator as Faker;

/* @var Illuminate\Database\Eloquent\Factory $factory */

$factory->define(App\Discussion::class, function (Faker $faker) {
    return [
        'author_id' => factory(App\Member::class),
        'target_id' => factory(App\Group::class),
        'target_type' => App\Group::class,
        'title' => $faker->sentence,
        'body' => $faker->paragraphs(3, true),
        'is_urgent' => false,
    ];
});

$factory->state(App\Discussion::class, 'private', function (Faker $faker) {
    return [
        'target_id' => factory(App\Member::class),
        'target_type' => App\Member::class,
    ];
});

$factory->state(App\Discussion::class, 'for-meeting', function (Faker $faker) {
    return [
        'target_id' => factory(App\Meeting::class),
        'target_id' => App\Meeting::class,
    ];
});

$factory->state(App\Discussion::class, 'urgent', [
    'is_urgent' => true,
]);