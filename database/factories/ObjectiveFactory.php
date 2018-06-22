<?php

use Faker\Generator as Faker;

/* @var Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Objective::class, function (Faker $faker) {
    return [
        'goal_id' => factory(\App\Goal::class),
        'name' => $faker->sentence,
        'due_at' => $faker->dateTimeBetween('+2 weeks', '+6 months'),
        'completed_at' => null,
    ];
});

/* @var Illuminate\Database\Eloquent\Factory $factory */
$factory->state(App\Objective::class, 'completed', function (Faker $faker) {
    return [
        'completed_at' => $faker->dateTimeBetween('-6 months', '-2 weeks'),
    ];
});

/* @var Illuminate\Database\Eloquent\Factory $factory */
$factory->state(App\Objective::class, 'overdue', function (Faker $faker) {
    return [
        'due_at' => $faker->dateTimeBetween('-6 months', '-2 weeks'),
    ];
});