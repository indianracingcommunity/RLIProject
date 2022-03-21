<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Race;
use App\Report;
use App\Driver;
use Faker\Generator as Faker;

$factory->define(Report::class, function (Faker $faker, $params) {
    $raceId = (array_key_exists('race_id', $params)) ? $params['race_id'] : factory(Driver::class)->create();
    $reportingId = (array_key_exists('reporting_driver', $params)) ? $params['reporting_driver'] : factory(Driver::class)->create();
    $reportedId = (array_key_exists('reported_against', $params)) ? $params['reported_against'] : factory(Driver::class)->create();

    $createdAt = $faker->optional()->datetime();
    $updatedAt = $faker->optional()->datetime();

    return [
        'race_id' => $raceId,
        'reporting_driver' => $reportingId,
        'reported_against' => $reportedId,

        'proof' => $faker->url,
        'lap' => $faker->randomNumber,
        'explanation' => $faker->paragraph,
        'report_game' => (int)$faker->boolean,
        'verdict_time' => $faker->randomFloat(2),
        'verdict_pp' => $faker->randomFloat(2, 0, 0.5),
        'resolved' => $faker->numberBetween(0, 3),

        'verdict_message' => $faker->optional()->sentence,
        'stewards_notes' => $faker->optional()->sentence,
        'message_id' => $faker->optional()->regexify('[1-9][0-9]{17}'),
        'created_at' => ($createdAt != null) ? $createdAt->format('Y-m-d H:i:s') : $createdAt,
        'updated_at' => ($updatedAt != null) ? $updatedAt->format('Y-m-d H:i:s') : $updatedAt,
    ];
});
