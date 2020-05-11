<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Teams;
use Faker\Generator as Faker;

$factory->define(Teams::class, function (Faker $faker) {
    return [
        'name' => $faker->firstName(),
        'kind_sport_id' => rand(1, 7),
        'abbr' => 'ABBR',
        'city' => $faker->city,
        'description' => $faker->text(300),
        'logo' => 'url'
    ];
});
