<?php

use Illuminate\Database\Seeder;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert(['name' => 'professor']);
        DB::table('roles')->insert(['name' => 'secretary']);
        DB::table('roles')->insert(['name' => 'admin']);
    }
}
