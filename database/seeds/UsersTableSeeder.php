<?php

use Illuminate\Database\Seeder;
// use Hash;

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
            'username' => 'user1',
            'email' => 'user1@example.com',
            'password' => Hash::make(1234),
        ]);
    }
}
