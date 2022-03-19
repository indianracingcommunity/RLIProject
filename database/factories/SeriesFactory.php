<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Series;
use Faker\Generator as Faker;

$factory->define(Series::class, function (Faker $faker) {
    return [
        'name' => $faker->company,
        'code' => $faker->unique()->bothify('***'),                             // unique 2 - 4 character alphanumeric
        'games' => $faker->optional()->company,                                             // group of 1, 10 companies
        'developer' => $faker->optional()->company,
        'discord_role' => $faker->optional()->regexify('[1-9][0-9]{17}'),       // 18 digit number - 687344291265118224
        'website' => $faker->company,
        'profile' => (int)$faker->boolean(90),                                      // 0 or 1
        'created_at' => $faker->optional()->datetime()->format('Y-m-d H:i:s'),
        'updated_at' => $faker->optional()->datetime()->format('Y-m-d H:i:s')
    ];
});
