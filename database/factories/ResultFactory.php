<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Race;
use App\Result;
use App\Driver;
use App\Constructor;
use Faker\Generator as Faker;
use App\Http\Controllers\Controller;

$factory->define(Result::class, function (Faker $faker) {
    $controller = new Controller();
    $createdAt = $faker->optional()->datetime();
    $updatedAt = $faker->optional()->datetime();

    return [
        'race_id' => factory(Race::class)->create(),
        'driver_id' => factory(Driver::class)->create(),
        'constructor_id' => factory(Constructor::class)->create(),

        'position' => $faker->randomNumber,
        'points' => $faker->randomNumber,
        'time' => $controller->convertMillisToStandard($faker->randomNumber),
        'fastestlaptime' => $controller->convertMillisToStandard($faker->randomNumber),
        'status' => $faker->numberBetween(-2, 1) + $faker->randomFloat(2, 0, 0.5),

        'grid' => $faker->optional()->randomNumber,
        'stops' => $faker->optional()->randomNumber,
        'created_at' => ($createdAt != null) ? $createdAt->format('Y-m-d H:i:s') : $createdAt,
        'updated_at' => ($updatedAt != null) ? $updatedAt->format('Y-m-d H:i:s') : $updatedAt
    ];
});
