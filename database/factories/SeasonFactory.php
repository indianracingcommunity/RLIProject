<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Season;
use App\Series;
use Faker\Generator as Faker;

$factory->define(Season::class, function (Faker $faker) {
    $createdAt = $faker->optional()->datetime();
    $updatedAt = $faker->optional()->datetime();
    $reportWindow = $faker->optional()->datetime();

    return [
        'game' => $faker->optional()->company,
        'season' => $faker->randomFloat(2),
        'tier' => $faker->randomFloat(2),
        'year' => $faker->optional()->year,
        'status' => $faker->numberBetween(0, 2) + $faker->randomFloat(1, 0, 0.3),
        'constructors' => $faker->randomDigit,                  // List of comma separated Constructor IDs
        'tttracks' => $faker->randomDigit,                      // List of 3 Circuit IDs
        'tiername' => $faker->words(3, true),
        'year' => $faker->year,
        'created_at' => ($createdAt != null) ? $createdAt->format('Y-m-d H:i:s') : $createdAt,
        'updated_at' => ($updatedAt != null) ? $updatedAt->format('Y-m-d H:i:s') : $updatedAt,
        'name' => $faker->optional()->words(3, true),
        'series' => factory(Series::class)->create(),
        'show' => (int)$faker->boolean,
        'report_channel' => $faker->optional()->regexify('[1-9][0-9]{17}'),
        'verdict_channel' => $faker->optional()->regexify('[1-9][0-9]{17}'),
        'report_window' => ($reportWindow != null) ? $reportWindow->format('Y-m-d H:i:s') : $reportWindow
    ];
});
