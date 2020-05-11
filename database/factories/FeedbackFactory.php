<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Feedback;
use Faker\Generator as Faker;

$factory->define(Feedback::class, function (Faker $faker) {
    return [
        'user_name' => $faker->firstName(),
        'user_email' => $faker->email,
        'message' => $faker->text(400)
    ];
});
