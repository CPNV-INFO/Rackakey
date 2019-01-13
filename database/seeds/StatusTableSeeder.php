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
            'name' => 'Disponible',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('statuses')->insert([
            'name' => 'Présente',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('statuses')->insert([
            'name' => 'Absente',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('statuses')->insert([
            'name' => 'Utilisée',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('statuses')->insert([
            'name' => 'Non Initialisée',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
