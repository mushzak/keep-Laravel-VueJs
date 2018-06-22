<?php

use Faker\Generator as Faker;

$factory->define(App\Account::class, function (Faker $faker) {
    return [
        'manager_id' => factory(App\User::class),
        'name' => $faker->company,
        'phone' => $faker->phoneNumber,
        'email' => $faker->safeEmail,
        'is_current' => true,
    ];
});
