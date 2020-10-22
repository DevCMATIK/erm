<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */


use Faker\Generator as Faker;

$factory->define(App\Domain\WaterManagement\Device\Sensor\Sensor::class, function (Faker $faker) {
    return [
        'type_id'=>App\Domain\WaterManagement\Device\Sensor\Type\SensorType::inRandomOrder()->first()->id,
        'device_id'=>App\Domain\WaterManagement\Device\Device::inRandomOrder()->first()->id,
        'name'=>$faker-> name,
        'address_id'=>App\Domain\WaterManagement\Device\Address\Address::inRandomOrder()->first()->id,
        'address_number'=>$faker-> randomNumber(),
        'enabled'=>1,
        'has_alarm'=>1,
        'fix_values_out_of_range'=>1,
        'fix_values'=>1

    ];
});
