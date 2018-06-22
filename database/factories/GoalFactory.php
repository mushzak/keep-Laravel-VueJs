<?php

use Faker\Generator as Faker;

/* @var Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Goal::class, function (Faker $faker) {
    return [
        'member_id' => factory(\App\Member::class),
        'name' => $faker->sentence,
    ];
});