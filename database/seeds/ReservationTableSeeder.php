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

        $usbs = App\Usb::where('status_id', '=', App\Status::active())->get();

        $professorUsers = App\User::where('role_id', '=', App\Role::professor())->pluck("id");

        $files = App\File::all()->pluck("id");
        $files->push(null);

        $i = 0;
        foreach ($usbs as $usb) {
            $randomFile = $faker->randomElement($files);
            $randomProfessor = $faker->randomElement($professorUsers);

            $dateThisMonth = $faker->dateTimeThisMonth;

            $dateReturned = $faker->randomElement(
                [
                    null,
                    date('Y-m-d H:i:s', strtotime($faker->randomElement(["+1 day", "+2 days", "+3 days", "+4 days"]),
                        strtotime($dateThisMonth->format('Y-m-d H:i:s'))))
                ]);

            if ($dateReturned == null) {
                $dateThisMonth = date("Y-m-d H:i:s", strtotime(
                    $faker->randomElement(
                        [
                            "-1 day", "-2 days", "-3 days",
                            "-4 days", "-5 days", "-10 days",
                            "-14 days", "-16 days", "-30 days", "-60 days"
                        ]),
                    strtotime($faker->dateTimeThisMonth->format("Y-m-d H:i:s"))));
            }

            DB::table('reservations')->insert([
                'name' => $faker->randomElement([
                        'Réservation: ', 'Classe ', 'Pour exa ', 'Examen ', 'Travaux exa ', 'Travaux ', 'TP '
                    ]) .
                    $faker->randomElement([
                        "GUI1", "PRW1", "CLD1", "GPR1", "SQL1", "UML1", "GUI2", "PRW2", "MAW", "XML1", "ITIL"
                    ]),
                'date_reserved' => $dateThisMonth,
                'date_returned' => $dateReturned,
                'user_id' => $randomProfessor,
                'file_id' => $randomFile,
                'created_at' => $dateThisMonth,
                'updated_at' => $dateThisMonth
            ]);

            if (($key = array_search($randomFile, $files->all())) !== false) {
                unset($files[$key]);
            }

            $i++;

            if ($i == count($usbs)/2) { // We make this so there is usbs keys that are not assigned to only one reservation but that could be reserved with others usbs at the same time
                break;
            }
        }
    }
}
