<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ManagerSeeder extends Seeder
{
    public function run()
    {
        // 1. Delete the old manager to ensure NO old hashes exist
        DB::table('users')->where('email', 'manager@example.com')->delete();

        // 2. Insert fresh using ONLY the DB Facade
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