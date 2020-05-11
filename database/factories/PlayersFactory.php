<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Players;
use Faker\Generator as Faker;

$factory->define(Players::class, function (Faker $faker) {
    return [
        'name' => $faker->firstName(),
        'surname' => $faker->lastName(),
        'date_birth' => $faker->dateTime(),
        'game_number' => 10,
        'team_id' => 1,
        'avatar' => 'url',
        'kind_sport_id' => 1,
        'city' => $faker->city(),
        'description' => $faker->text(300)
    ];
});
