<?php

use Faker\Generator as Faker;

$factory->define(App\Meeting::class, function (Faker $faker) {
    $baseTime = \Carbon\Carbon::instance(
        $faker->dateTimeInInterval('+1 month', '+2 months')
    );

    return [
        'group_id' => factory(App\Group::class),
        'subject' => $faker->sentence,
        'reminds_at' => $baseTime->copy()->subHour(1),
        'starts_at' => $baseTime,
        'ends_at' => $baseTime->copy()->addHour(1),
    ];
});
