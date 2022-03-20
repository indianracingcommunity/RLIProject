<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Points;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\Schema;

// Only to be used with make()
$factory->define(Points::class, function (Faker $faker) {
    $faker->unique($reset = true);

    $points = array();
    for ($i = 0; $i < 30; ++$i) {
        $points[] = $faker->unique()->numberBetween(0, 115);
    }
    rsort($points);

    $createdAt = $faker->optional()->datetime();
    $updatedAt = $faker->optional()->datetime();

    $fact = array();
    $fact['created_at'] = $createdAt;
    $fact['updated_at'] = $updatedAt;
    for ($i = 1; $i < 31; ++$i) {
        $fact['P' . $i] = $points[$i - 1];
    }

    return $fact;
});
