<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'firstName' => 'pro',
            'lastName' => 'fessor',
            'email' => 'professor@cpnv.ch',
            'email_verified_at' => now(),
            'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
            'role_id' => App\Role::professor(),
            'remember_token' => str_random(10),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('users')->insert([
            'firstName' => 'pro',
            'lastName' => 'fessor2',
            'email' => 'professor2@cpnv.ch',
            'email_verified_at' => now(),
            'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
            'role_id' => App\Role::professor(),
            'remember_token' => str_random(10),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('users')->insert([
            'firstName' => 'pro',
            'lastName' => 'fessor3',
            'email' => 'professor3@cpnv.ch',
            'email_verified_at' => now(),
            'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
            'role_id' => App\Role::professor(),
            'remember_token' => str_random(10),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('users')->insert([
            'firstName' => 'secret',
            'lastName' => 'ary',
            'email' => 'secretary@cpnv.ch',
            'email_verified_at' => now(),
            'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
            'role_id' => App\Role::secretary(),
            'remember_token' => str_random(10),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('users')->insert([
            'firstName' => 'ad',
            'lastName' => 'min',
            'email' => 'admin@cpnv.ch',
            'email_verified_at' => now(),
            'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
            'role_id' => App\Role::admin(),
            'remember_token' => str_random(10),
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
