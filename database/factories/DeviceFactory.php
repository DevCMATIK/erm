<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */


use Faker\Generator as Faker;

$factory->define(App\Domain\WaterManagement\Device\Device::class, function (Faker $faker) {
    return [
        'device_type_id'=> App\Domain\WaterManagement\Device\Type\DeviceType::inRandomOrder()->first()->id,
        'check_point_id'=> App\Domain\Client\CheckPoint\CheckPoint::inRandomOrder()->first()->id,
        'internal_id'=>$faker->randomNumber(),
        'name' => $faker-> name,
        'from_bio'=>false
    ];
});
