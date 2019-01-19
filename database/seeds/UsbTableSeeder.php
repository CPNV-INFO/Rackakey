<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class UsbTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Usb::class, 30)->create();

        $faker = Faker::create();

        // To be sure to have usb with 0 space available and full space (31142707 kb) let's create those case
        DB::table('usbs')->insert([
            'name' => $faker->randomElement(
                    ["USB_CPNV", "EXA_USB", "USB_EXA", "EXA", "SAMSUNG", "SANDISK", "KINGSTON", "STORAGE", "HP", "TOSHIBA",
                        "STORAGE", "STORAGE", "STORAGE", "DEFAULT", "DEFAULT", "SECRETARIAT_CPNV", "CPNV_CLE", "CPNV_001",
                        "CPNV_002", "CPNV_STE_CROIX", "CPNV", "CPNV_USB", "USB_GUI1", "GUI1_USB", "USB_PRW", "PRW1_USB", "CLD1",
                        "GPR1", "SQL1_PROF1", "UML1", "GUI2", "PRW2", "MAW", "XML1", "ITIL", "PROF1_EXA", "PROF2_EXA", "EXA_PROF",
                        "EXA_CLE", "DOSSIERS_ELEVES", "RENDU_ELEVES", "EXAMEN_PROF_CLE"])
                . join($faker->randomElements(['', '', "$faker->randomNumber"])),
            'uuid' => $faker->uuid(),
            'freeSpaceInBytes' => 0,
            'status_id' => App\Status::available(),
            'rack_number' => $faker->numberBetween(0, 5),
            'port_number' => $faker->numberBetween(0, 14),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('usbs')->insert([
            'name' => $faker->randomElement(
                    ["USB_CPNV", "EXA_USB", "USB_EXA", "EXA", "SAMSUNG", "SANDISK", "KINGSTON", "STORAGE", "HP", "TOSHIBA",
                        "STORAGE", "STORAGE", "STORAGE", "DEFAULT", "DEFAULT", "SECRETARIAT_CPNV", "CPNV_CLE", "CPNV_001",
                        "CPNV_002", "CPNV_STE_CROIX", "CPNV", "CPNV_USB", "USB_GUI1", "GUI1_USB", "USB_PRW", "PRW1_USB", "CLD1",
                        "GPR1", "SQL1_PROF1", "UML1", "GUI2", "PRW2", "MAW", "XML1", "ITIL", "PROF1_EXA", "PROF2_EXA", "EXA_PROF",
                        "EXA_CLE", "DOSSIERS_ELEVES", "RENDU_ELEVES", "EXAMEN_PROF_CLE"])
                . join($faker->randomElements(['', '', "$faker->randomNumber"])),
            'uuid' => $faker->uuid(),
            'freeSpaceInBytes' => 34359738368,
            'status_id' => App\Status::available(),
            'rack_number' => $faker->numberBetween(0, 5),
            'port_number' => $faker->numberBetween(0, 14),
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
