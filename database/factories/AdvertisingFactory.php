<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Advertising;
use Faker\Generator as Faker;

$factory->define(Advertising::class, function (Faker $faker) {
    return [
        'title' => $faker->text(),
        'description' => $faker->text(1000),
        'price' => $faker->numberBetween(1500, 6000)
    ];
});
