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
            'name' => $faker->randomElement(["USB_EXA_", "USB_EXA", "EXA_USB_", "EXA_USB", "EXA", ""])
                . $faker->randomElement(["GUI1", "PRW1", "CLD1", "GPR1", "SQL1", "UML1", "GUI2", "PRW2", "MAW", "XML1", "ITIL"]),
            'uuid' => $faker->uuid(),
            'freeKbyteSpace' => 0,
            'status_id' => App\Status::available(),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('usbs')->insert([
            'name' => $faker->randomElement(["USB_EXA_", "USB_EXA", "EXA_USB_", "EXA_USB", "EXA", ""])
                . $faker->randomElement(["GUI1", "PRW1", "CLD1", "GPR1", "SQL1", "UML1", "GUI2", "PRW2", "MAW", "XML1", "ITIL"]),
            'uuid' => $faker->uuid(),
            'freeKbyteSpace' => 31142707,
            'status_id' => App\Status::available(),
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
