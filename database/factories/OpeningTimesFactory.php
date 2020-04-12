<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\OpeningTimes;
use Faker\Generator as Faker;

$factory->define(OpeningTimes::class, function (Faker $faker) {
    return [
        'open_time' => '09:00am',
        'close_time' => '05:00pm'
    ];
});
