<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Driver;
use App\User;
use Faker\Generator as Faker;

$factory->define(Driver::class, function (Faker $faker) {

    $alias = $faker->userName;
    $aliasCount = $faker->numberBetween(0, 8);
    for ($i = 0; $i < $aliasCount; ++$i) {
        $alias .= "~$~" . $faker->userName;
    }

    $createdAt = $faker->optional()->datetime();
    $updatedAt = $faker->optional()->datetime();

    return [
        'user_id' => factory(User::class)->create(),
        'name' => $faker->userName,
        'drivernumber' => $faker->optional()->randomNumber,
        'tier' => $faker->optional()->randomNumber,
        'team' => $faker->optional()->randomNumber,
        'retired' => (int)$faker->boolean,
        'alias' => $alias,
        'created_at' => ($createdAt != null) ? $createdAt->format('Y-m-d H:i:s') : $createdAt,
        'updated_at' => ($updatedAt != null) ? $updatedAt->format('Y-m-d H:i:s') : $updatedAt
    ];
});
