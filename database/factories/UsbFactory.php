<?php

use Faker\Generator as Faker;

$factory->define(App\Usb::class, function (Faker $faker) {
    $status = App\Status::pluck('id')->toArray();

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
        'status_id' => $faker->randomElement($status),
        'rack_number' => $faker->numberBetween(0, 5),
        'port_number' => $faker->numberBetween(0, 14),
        'created_at' => now(),
        'updated_at' => now()
    ];
});
