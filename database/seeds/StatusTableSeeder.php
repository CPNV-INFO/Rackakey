<?php

use Illuminate\Database\Seeder;

class StatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('statuses')->insert([
            'name' => 'Activée',
        ]);

        DB::table('statuses')->insert([
            'name' => 'Non activée',
        ]);

//        DB::table('statuses')->insert([
//            'name' => 'Supprimée',
//        ]);
//
//        DB::table('statuses')->insert([
//            'name' => 'Disponible',
//        ]);

//        DB::table('statuses')->insert([
//            'name' => 'Présente',
//        ]);
//
//        DB::table('statuses')->insert([
//            'name' => 'Utilisée',
//        ]);
//
//        DB::table('statuses')->insert([
//            'name' => 'Absente',
//        ]);
//
//        DB::table('statuses')->insert([
//            'name' => 'Non Initialisée',
//        ]);

    }
}
