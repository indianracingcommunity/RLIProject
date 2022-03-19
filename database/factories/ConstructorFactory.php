<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Constructor;
use Faker\Generator as Faker;

$factory->define(Constructor::class, function (Faker $faker) {
    return [
        'name' => $faker->company,
        'official' => $faker->optional()->hexcolor,
        'game' => $faker->optional()->word,
        'logo' => $faker->optional()->url,
        'car' => $faker->optional()->url,
        'created_at' => $faker->optional()->datetime()->format('Y-m-d H:i:s'),
        'updated_at' => $faker->optional()->datetime()->format('Y-m-d H:i:s')
    ];
});
