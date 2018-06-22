<?php

use Faker\Generator as Faker;

$factory->define(App\Participant::class, function (Faker $faker) {
    return [
        'meeting_id' => factory(App\Meeting::class),
        'member_id' => factory(App\Member::class),
        'status' => \App\Participant::NOT_RESPONDED,
    ];
});

$factory->state(App\Participant::class, 'accepted', [
    'status' => \App\Participant::ACCEPTED,
]);

$factory->state(App\Participant::class, 'rejected', [
    'status' => \App\Participant::REJECTED,
]);

$factory->state(App\Participant::class, 'maybe', [
    'status' => \App\Participant::MAYBE,
]);