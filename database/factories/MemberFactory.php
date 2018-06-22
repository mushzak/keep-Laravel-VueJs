<?php

use Faker\Generator as Faker;

$factory->define(App\Member::class, function (Faker $faker) {
    return [
        'group_id' => factory(App\Group::class),
        'user_id' => factory(App\User::class),
        'personal_bio' => $faker->paragraph,
        'company_name' => $faker->company,
        'business_bio' => $faker->paragraph,
    ];
});
