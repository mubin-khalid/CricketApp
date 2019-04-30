<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Team;
use App\Player;
use Faker\Generator as Faker;


$factory->define(Team::class, function (Faker $faker) {
    return [
        'name' => $faker->unique()->city,
        'owner_name' => $faker->name,
        'sponsor' => $faker->company,
    ];
});

$factory->define(Player::class, function (Faker $faker) {
    return [
        'name' => $faker->unique()->name('male'),
        'team_id' => 0,
    ];
});
