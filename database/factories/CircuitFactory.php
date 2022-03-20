<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Circuit;
use Faker\Generator as Faker;

$factory->define(Circuit::class, function (Faker $faker) {
    return [
        'name' => $faker->country . " Grand Prix",
        'location' => $faker->optional()->city,
        'country' => $faker->optional()->country,
        'official' => $faker->optional()->state,
        'display' => $faker->optional()->url,
        'track_length' => (string)$faker->randomFloat . " km",
        'laps' => $faker->randomNumber,
        'flag' => $faker->optional()->url,
        'game' => $faker->optional()->word,
        'series' => factory(Series::class)->create(),
        'created_at' => $faker->optional()->datetime()->format('Y-m-d H:i:s'),
        'updated_at' => $faker->optional()->datetime()->format('Y-m-d H:i:s')
    ];
});
