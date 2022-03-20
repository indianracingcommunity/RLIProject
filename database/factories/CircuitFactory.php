<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Series;
use App\Circuit;
use Faker\Generator as Faker;

$factory->define(Circuit::class, function (Faker $faker) {
    $createdAt = $faker->optional()->datetime();
    $updatedAt = $faker->optional()->datetime();

    return [
        'name' => $faker->country . " Grand Prix",
        'location' => $faker->optional()->city,
        'country' => $faker->optional()->country,
        'official' => $faker->state,
        'display' => $faker->optional()->url,
        'track_length' => (string)$faker->randomFloat(3) . " km",
        'laps' => $faker->randomNumber,
        'flag' => $faker->optional()->url,
        'game' => $faker->optional()->word,
        'series' => factory(Series::class)->create(),
        'created_at' => ($createdAt != null) ? $createdAt->format('Y-m-d H:i:s') : $createdAt,
        'updated_at' => ($updatedAt != null) ? $updatedAt->format('Y-m-d H:i:s') : $updatedAt
    ];
});
