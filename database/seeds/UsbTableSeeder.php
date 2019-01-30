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
        factory(App\Usb::class, 15)->create();

        $faker = Faker::create();

        // To be sure to have usb with 0 space available and full space (31142707 kb) let's create those case
        DB::table('usbs')->insert([
            'name' => 'CPNV_' . $faker->randomNumber,
            'uuid' => $faker->uuid(),
            'freeSpaceInBytes' => 0,
            'status_id' => App\Status::active(),
            'rack_number' => $faker->numberBetween(0, 5),
            'port_number' => $faker->numberBetween(0, 14),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('usbs')->insert([
            'name' => 'CPNV_' . $faker->randomNumber,
            'uuid' => $faker->uuid(),
            'freeSpaceInBytes' => 34359738368,
            'status_id' => App\Status::active(),
            'rack_number' => $faker->numberBetween(0, 5),
            'port_number' => $faker->numberBetween(0, 14),
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
