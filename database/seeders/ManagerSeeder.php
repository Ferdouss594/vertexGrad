<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ManagerSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('users')->where('email', 'manager@example.com')->delete();

        DB::table('users')->insert([
            'username'   => 'main_manager',
            'name'       => 'Main Manager',
            'email'      => 'manager@example.com',
            'password'   => Hash::make('12345678'),
            'role'       => 'Manager',
            'status'     => 'active',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}