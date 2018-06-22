<?php

use Faker\Generator as Faker;

/* @var Illuminate\Database\Eloquent\Factory $factory */

$factory->define(App\DiscussionSubscription::class, function (Faker $faker) {
    return [
        'discussion_id' => factory(App\Discussion::class),
        'user_id' => factory(App\User::class),
    ];
});