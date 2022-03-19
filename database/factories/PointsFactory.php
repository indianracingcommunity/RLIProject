<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Points;
use Faker\Generator as Faker;

// Only to be used with make()
$factory->define(Points::class, function (Faker $faker) {
    $points = array();
    for ($i = 0; i < 10; ++i) {
        $points[] = $faker->unique()->numberBetween(0, 25);
    }
    sort($points);

    $fact = array();
    $fact['created_at'] = $faker->optional()->datetime()->format('Y-m-d H:i:s');
    $fact['updated_at'] = $faker->optional()->datetime()->format('Y-m-d H:i:s');
    for ($i = 0; i < 10; ++i) {
        $fact[(string) $i] = $points[$i];
    }

    return $fact;
});
