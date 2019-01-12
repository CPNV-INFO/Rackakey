<?php

use Faker\Generator as Faker;
use Illuminate\Support\Facades\Log;

$factory->define(App\File::class, function (Faker $faker) {
    $compressedFileMd5Hash = $faker->md5;

    return [
        'nameOfCompressedFile' =>  $faker->dateTime()->format("Y-m-d_H_i_s_") .  $compressedFileMd5Hash . $faker->randomElement([".zip"]),
        'hash' => $compressedFileMd5Hash,
        'created_at' => now(),
        'updated_at' => now()
    ];
});
