<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Race;
use App\Season;
use App\Points;
use App\Circuit;
use Faker\Generator as Faker;

$factory->define(Race::class, function (Faker $faker) {
    $createdAt = $faker->optional()->datetime();
    $updatedAt = $faker->optional()->datetime();

    return [
        'season_id' => factory(Season::class)->create(),
        'circuit_id' => factory(Circuit::class)->create(),
        'round' => $faker->randomNumber,
        'distance' => $faker->randomFloat(2, 0, 1),
        'points' => factory(Points::class)->create(),
        'created_at' => ($createdAt != null) ? $createdAt->format('Y-m-d H:i:s') : $createdAt,
        'updated_at' => ($updatedAt != null) ? $updatedAt->format('Y-m-d H:i:s') : $updatedAt
    ];
});
