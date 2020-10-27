<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */


use Faker\Generator as Faker;

$factory->define(App\Domain\WaterManagement\Device\Type\DeviceType::class, function (Faker $faker) {
    return [
        'slug' => $faker->slug,
        'name'=> $faker-> name,
        'model'=>$faker->word,
        'brand'=>$faker->word
    ];
});
