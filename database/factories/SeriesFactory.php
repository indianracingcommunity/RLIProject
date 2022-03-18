<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Series;
use Faker\Generator as Faker;

$factory->define(Series::class, function (Faker $faker) {
    return [
        'name' => $faker->company,
        'code' => $faker->tld,
        'games' => $faker->company,
        'developer' => $faker->company,
        'discord_role' => $faker->isbn13,
        'website' => $faker->company,
        'profile' => 1
    ];
});
