<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */


use Faker\Generator as Faker;

$factory->define(App\Domain\WaterManagement\Device\Sensor\Type\SensorType::class, function (Faker $faker) {
    return [
        'slug'=> $faker->slug,
        'name'=>$faker->name,
        'min_value'=>400,
        'max_value'=>2000,
        'interval'=>10,
        'is_exportable'=>1
    ];
});
