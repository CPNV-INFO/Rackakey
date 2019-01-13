<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            RoleTableSeeder::class,
            UsersTableSeeder::class,
            StatusTableSeeder::class,
            UsbTableSeeder::class,
            FileTableSeeder::class,
            ReservationTableSeeder::class,
            ReservationUsbTableSeeder::class
        ]);
    }
}
