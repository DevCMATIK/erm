<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */


use Faker\Generator as Faker;

$factory->define(App\Domain\Data\Analogous\AnalogousReport::class, function (Faker $faker) {
    return [
        'device_id'=> App\Domain\WaterManagement\Device\Device::inRandomOrder()->first()->id,
        'register_type'=> rand (1,11),
        'address'=> $faker-> randomDigit,
        'sensor_id'=>App\Domain\WaterManagement\Device\Sensor\Sensor::inRandomOrder()->first()->id,
        'historical_type_id'=>App\Domain\WaterManagement\Historical\HistoricalType::inRandomOrder()->first()->id,
        'scale'=> $faker-> word,
        'scale_min'=> $faker->randomDigit,
        'scale_max'=> $faker->randomDigit,
        'ing_min'=> $faker->randomDigit,
        'ing_max'=> $faker->randomDigit,
        'unit'=>$faker->word,
        'value'=>$faker->randomFloat(2,400,2000),
        'result'=>$faker->randomFloat(2,400,2000),
        'date'=>$faker->dateTimeBetween('-10 weeks'),

    ];
});
