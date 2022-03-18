<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Season;
use App\Series;
use Faker\Generator as Faker;

$factory->define(Season::class, function (Faker $faker) {
    return [
        'game' => $faker->company,
        'season' => $faker->randomDigit,
        'tier' => $faker->randomDigit,
        'status' => $faker->randomDigit,
        'constructors' => $faker->randomDigit,
        'tiername' => $faker->company,
        'show' => 1,
        'year' => $faker->year,
        'name' => $faker->company,
        'series' => factory(Series::class)->create(),
    ];
});
