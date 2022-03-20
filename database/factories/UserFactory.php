<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\User;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'role_id' => $faker->numberBetween(1, 3),
        'discord_discrim' => $faker->numerify('####'),
        'avatar' => $faker->optional()->url,
        'discord_id' => $faker->unique()->regexify('[1-9][0-9]{17}'),
        'steam_id' => $faker->unique()->regexify('[1-9][0-9]{16}'),
        'remember_token' => $faker->regexify('[a-zA-Z0-9]{60}'),
        'created_at' => $faker->optional()->datetime()->format('Y-m-d H:i:s'),
        'updated_at' => $faker->optional()->datetime()->format('Y-m-d H:i:s'),
        'isadmin' => (int)$faker->boolean(1),
        'location' => $faker->city . "~" . $faker->state,
        'mothertongue' => $faker->languageCode,
        'motorsport' => $faker->company,
        'driversupport' => $faker->name,
        'games' => 'a:4:{i:0;s:2:"f1";i:1;s:2:"ac";i:2;s:3:"acc";i:3;s:2:"pc";}',
        'source' => $faker->sentence,
        'platform' => 'a:1:{i:0;s:2:"PC";}',
        'device' => 'a:2:{i:0;s:10:"Controller";i:1;s:5:"Wheel";}',
        'devicename' => $faker->optional()->word,
        'instagram' => $faker->optional()->randomElement(['https://www.instagram.com/' . $faker->slug]),
        'twitter' => $faker->optional()->randomElement([' https://twitter.com/' . $faker->slug]),
        'twitch' => $faker->optional()->randomElement(['https://www.twitch.tv/' . $faker->slug]),
        'youtube' => $faker->optional()->randomElement(['https://www.youtube.com/' . $faker->slug]),
        'xbox' => $faker->optional()->userName,
        'psn' => $faker->optional()->userName,
        'reddit' => $faker->optional()->randomElement(['https://www.reddit.com/user/' . $faker->slug]),
        'api_token' => $faker->unique()->regexify('[1-9][0-9]{16,24}')
    ];
});
