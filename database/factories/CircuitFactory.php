<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Series;
use App\Circuit;
use Faker\Generator as Faker;

$factory->define(Circuit::class, function (Faker $faker) {
    $createdAt = $faker->optional()->datetime();
    $updatedAt = $faker->optional()->datetime();

    return [
        'series' => factory(Series::class)->create(),

        'name' => $faker->country . " Grand Prix",
        'official' => $faker->state,
        'laps' => $faker->randomNumber,
        'track_length' => (string)$faker->randomFloat(3) . " km",

        'location' => $faker->optional()->city,
        'country' => $faker->optional()->country,
        'display' => $faker->optional()->url,
        'flag' => $faker->optional()->url,
        'game' => $faker->optional()->word,
        'created_at' => ($createdAt != null) ? $createdAt->format('Y-m-d H:i:s') : $createdAt,
        'updated_at' => ($updatedAt != null) ? $updatedAt->format('Y-m-d H:i:s') : $updatedAt
    ];
});
