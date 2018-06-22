<?php

use Faker\Generator as Faker;

$factory->define(App\Group::class, function (Faker $faker) {
    return [
        'account_id' => factory(App\Account::class),
        'facilitator_id' => factory(App\User::class),
        'name' => $faker->unique()->company,
        'description' => $faker->sentence,
        'purpose' => $faker->sentence,
        'slogan' => $faker->sentence,
        'location' => $faker->sentence,
        'contact' => $faker->sentence,
        'current_process' => 20,
    ];
});
