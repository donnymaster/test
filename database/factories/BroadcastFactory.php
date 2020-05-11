<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Broadcast;
use Faker\Generator as Faker;

$factory->define(Broadcast::class, function (Faker $faker) {
    return [
        'name' => $faker->firstName(),
        'team_id_1' => rand(1, 15),
        'team_id_2' =>  rand(1, 15),
        'url_video' => 'url',
        'status' => 'procces',
        'video_start_date' => $faker->date(),
        'video_start_time' => $faker->time(),
        'logo' => 'url',
        'description' => $faker->text(300),
        'kind_sport_id' => rand(1,7)
    ];
});
