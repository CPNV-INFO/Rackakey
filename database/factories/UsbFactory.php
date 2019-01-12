<?php

use Faker\Generator as Faker;

$factory->define(App\Usb::class, function (Faker $faker) {
    $status = App\Status::pluck('id')->toArray();

    return [
        'name' => $faker->randomElement(["USB_EXA_", "USB_EXA", "EXA_USB_", "EXA_USB", "EXA", ""])
            . $faker->randomElement(["GUI1", "PRW1", "CLD1", "GPR1", "SQL1", "UML1", "GUI2", "PRW2", "MAW", "XML1", "ITIL"]),
        'uuid' => $faker->uuid(),
        'freeKbyteSpace' => $faker->numberBetween(0, 31142707), // Between 0 and 31142707 kbyte available
        'status_id' => $faker->randomElement($status),
        'created_at' => now(),
        'updated_at' => now()
    ];
});

$factory->afterCreating(App\Usb::class, function ($usb, $faker) {
   Log::debug($usb);
   if($usb["status_id"] == App\Status::present()){ // The key is present so it should have been reserved by someone, let's fill the database for that

   }
});