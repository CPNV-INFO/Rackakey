<?php

use Faker\Generator as Faker;

$factory->define(App\Usb::class, function (Faker $faker) {
    $status = App\Status::all();

    $dateThisMonth = $faker->dateTimeThisMonth();

    return [
        'name' => $faker->randomElement(
                ["USB_CPNV", "EXA_USB", "USB_EXA", "EXA", "SAMSUNG", "SANDISK", "KINGSTON", "STORAGE", "HP", "TOSHIBA",
                    "STORAGE", "STORAGE", "STORAGE", "DEFAULT", "DEFAULT", "SECRETARIAT_CPNV", "CPNV_CLE", "CPNV_001",
                    "CPNV_002", "CPNV_STE_CROIX", "CPNV", "CPNV_USB", "USB_GUI1", "GUI1_USB", "USB_PRW", "PRW1_USB", "CLD1",
                    "GPR1", "SQL1_PROF1", "UML1", "GUI2", "PRW2", "MAW", "XML1", "ITIL", "PROF1_EXA", "PROF2_EXA", "EXA_PROF",
                    "EXA_CLE", "DOSSIERS_ELEVES", "RENDU_ELEVES", "EXAMEN_PROF_CLE"])
            . join($faker->randomElements(['', '', "$faker->randomNumber"])),
        'uuid' => $faker->uuid(),
        'freeSpaceInBytes' => $faker->numberBetween(0, 34359738368), // Between 0 and 31142707 kbyte available
        'status_id' => $faker->randomElement(
            [
                \App\Status::active(),
                \App\Status::active(),
                \App\Status::active(),
                \App\Status::notActive()
            ]),
        'rack_number' => $faker->numberBetween(0, 4), // rack number 0 = Not in a rack
        'port_number' => $faker->numberBetween(0, 15),
        'created_at' => $dateThisMonth,
        'updated_at' => $dateThisMonth,
    ];
});

$factory->afterMaking(App\Usb::class, function ($usb, $faker) {
    // Be sure that when the key is no more here (rack number = 0), the port is 0 too.
    // If the key is not here
    if ($usb->rack_number == 0) {
        $usb->port_number = 0;
    }
});
