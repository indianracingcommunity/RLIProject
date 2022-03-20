<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\User;
use App\Season;
use App\Signup;
use Faker\Generator as Faker;

$factory->define(Signup::class, function (Faker $faker) {
    $createdAt = $faker->optional()->datetime();
    $updatedAt = $faker->optional()->datetime();

    return [
        'user_id' => factory(User::class)->create(),
        'speedtest' => 'https://www.speedtest.net/' . $faker->slug,
        'timetrial1' => '1:11.111',                     // Standard F1 Format time
        'timetrial2' => '1:11.111',
        'timetrial3' => '1:11.111',
        'ttevidence1' => 'timtrials/' . $faker->sha256,
        'ttevidence2' => 'timtrials/' . $faker->sha256,
        'ttevidence3' => 'timtrials/' . $faker->sha256,
        'carprefrence' => $faker->randomNumber . ',' . $faker->randomNumber . ',' . $faker->randomNumber,   // 3 Constructor IDs
        'attendance' => (int)$faker->boolean,
        'season' => factory(Season::class)->create(),
        'assists' => 'a:4:{i:0;s:8:"traction";i:1;s:3:"abs";i:2;s:4:"line";i:3;s:9:"autogears";}',
        'drivernumber' => $faker->optional()->randomNumber,
        'created_at' => ($createdAt != null) ? $createdAt->format('Y-m-d H:i:s') : $createdAt,
        'updated_at' => ($updatedAt != null) ? $updatedAt->format('Y-m-d H:i:s') : $updatedAt
    ];
});
