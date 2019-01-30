<?php

use Illuminate\Database\Seeder;
use \Illuminate\Support\Facades\File;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        File::deleteDirectory(storage_path('app/reservations'));

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
