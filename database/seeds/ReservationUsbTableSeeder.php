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

        $activeUsbs = App\Usb::where('status_id', '=', App\Status::active())->pluck("id");

        foreach (App\Reservation::all() as $reservation) {

            $randomUsb = $faker->randomElement($activeUsbs);

            DB::table('reservation_usb')->insert([
                'reservation_id' => $reservation->id,
                'usb_id' => $randomUsb,
                'created_at' => $reservation->created_at,
                'updated_at' => $reservation->updated_at
            ]);

            if (($key = array_search($randomUsb, $activeUsbs->all())) !== false) {
                unset($activeUsbs[$key]);
            }
        }

        foreach ($faker->randomElements(App\Reservation::all(),4) as $reservation) {

            $randomUsb = $faker->randomElement($activeUsbs);

            if($randomUsb == null)
                break;

            DB::table('reservation_usb')->insert([
                'reservation_id' => $reservation->id,
                'usb_id' => $randomUsb,
                'created_at' => $reservation->created_at,
                'updated_at' => $reservation->updated_at
            ]);

            if (($key = array_search($randomUsb, $activeUsbs->all())) !== false) {
                unset($activeUsbs[$key]);
            }
        }

    }
}
