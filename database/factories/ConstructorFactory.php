<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Constructor;
use Faker\Generator as Faker;

$factory->define(Constructor::class, function (Faker $faker) {
    $createdAt = $faker->optional()->datetime();
    $updatedAt = $faker->optional()->datetime();

    return [
        'name' => $faker->company,
        'official' => $faker->optional()->hexcolor,
        'game' => $faker->optional()->word,
        'logo' => $faker->optional()->url,
        'car' => $faker->optional()->url,
        'created_at' => ($createdAt != null) ? $createdAt->format('Y-m-d H:i:s') : $createdAt,
        'updated_at' => ($updatedAt != null) ? $updatedAt->format('Y-m-d H:i:s') : $updatedAt
    ];
});
