<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Location;
use Faker\Generator as Faker;

$factory->define(Location::class, function (Faker $faker) {
    return [
        'name' => $faker->company,
        'location' => $faker->address,
        'description' => $faker->paragraphs(1, true),
        'longitude' => $faker->longitude,
        'latitude' => $faker->latitude,
        'logo' => $faker->imageUrl(),
        'phone' => $faker->phoneNumber,
        'email' => $faker->safeEmail
    ];
});