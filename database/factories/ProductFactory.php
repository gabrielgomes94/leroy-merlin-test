<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(App\Product::class, function (Faker $faker) {
    return [
        'lm' => $faker->randomNumber(4, false),
        'name' => $faker->name,
        'free_shipping' => true,
        'description' => $faker->paragraph(3, true),
        'price' => $faker->randomFloat(2, 0, 500),
        'category' => $faker->randomNumber(5, false)
    ];
});
