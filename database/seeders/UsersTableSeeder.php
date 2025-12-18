<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('users')->insert([
            'username' => 'manager',
            'name' => 'Manager',
            'email' => 'manager@example.com',
            'password' => Hash::make('Manager123'),
            'role' => 'Manager',
            'status' => 'active',
        ]);
    }
}

