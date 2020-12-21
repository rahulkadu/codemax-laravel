<?php

use Illuminate\Database\Seeder;

class AdminUsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admin_users')->insert([
            'username' => 'adminuser',
            'email' => 'adminuser@example.com',
            'password' => Hash::make(1234),
        ]);
    }
}
