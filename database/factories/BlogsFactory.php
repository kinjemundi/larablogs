<?php

use Faker\Generator as Faker;

$factory->define(App\Blog::class, function (Faker $faker) {
    return [
        //
        'title' => $faker->sentence(10),
        'body' => $faker->sentence(100),
        'slug' => str_slug($faker->sentence(10)),
        'meta_title' => str_limit($faker->sentence(10)),
        'meta_description' => str_limit($faker->sentence(100)),
    ];
});
