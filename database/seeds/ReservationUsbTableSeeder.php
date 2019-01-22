<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class ReservationUsbTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        $presentOrUsedUsbs = App\Usb::where('status_id', '=', App\Status::active())->pluck("id");
        $reservations = App\Reservation::all()->pluck("id");

        foreach ($presentOrUsedUsbs as $usb) {

            $randomUsb = $faker->randomElement($presentOrUsedUsbs);

            DB::table('reservation_usb')->insert([
                'reservation_id' => $faker->randomElement($reservations),
                'usb_id' => $randomUsb,
                'created_at' => now(),
                'updated_at' => now()
            ]);

//            if (($key = array_search($randomUsb, $presentOrUsedUsbs->all())) !== false) {
//                unset($presentOrUsedUsbs[$key]);
//            }
        }
    }
}
