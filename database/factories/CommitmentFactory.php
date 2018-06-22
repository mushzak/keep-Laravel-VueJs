<?php

use Faker\Generator as Faker;

/* @var Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Commitment::class, function (Faker $faker) {
    return [
        'member_id' => factory(\App\Member::class),
        'process_number' => function (array $commitment) {
            return \App\Member::findOrFail($commitment['member_id'])->group->process_number;
        },
        'name' => $faker->sentence,
        'completed_at' => $faker->boolean(50) ? $faker->dateTimeBetween('-6 months', '-2 weeks') : null,
    ];
});

/* @var Illuminate\Database\Eloquent\Factory $factory */
$factory->state(App\Commitment::class, 'completed', function (Faker $faker) {
    return [
        'completed_at' => $faker->dateTimeBetween('-6 months', '-2 weeks'),
    ];
});

/* @var Illuminate\Database\Eloquent\Factory $factory */
$factory->state(App\Commitment::class, 'incomplete', function (Faker $faker) {
    return [
        'completed_at' => null,
    ];
});