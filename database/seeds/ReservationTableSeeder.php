<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class ReservationTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Let's create reservations for usb that are in present or used status

        $faker = Faker::create();

        $presentOrUsedUsbs    = App\Usb::where('status_id', '=', App\Status::present())->orWhere('status_id', '=', App\Status::used()) ->get();
        $professorUsers = App\User::where('role_id', '=', App\Role::professor())->pluck("id");
        $files          = App\File::all()->pluck("id");
        $files->push(null);

        foreach($presentOrUsedUsbs as $usb){
            $randomFile = $faker->randomElement($files);
            $randomProfessor = $faker->randomElement($professorUsers);

            DB::table('reservations')->insert([
                'date_reserved' => now(),
                'date_returned' => null,
                'user_id' => $randomProfessor,
                'file_id' => $randomFile,
                'created_at' => now(),
                'updated_at' => now()
            ]);

            if (($key = array_search($randomFile, $files->all())) !== false) {
                unset($files[$key]);
            }

            if($key == count($presentOrUsedUsbs)/2){ // We make this so there is usbs keys that are not assigned to only one reservation but that could be reserved with others usbs at the same time
                break;
            }
        }
    }
}
