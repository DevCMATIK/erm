<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */


use Faker\Generator as Faker;

$factory->define(App\Domain\WaterManagement\Historical\HistoricalType::class, function (Faker $faker) {
    return [
        'internal_id'=>$faker->unique()->randomDigit,
        'name'=> $faker->name
    ];
});
