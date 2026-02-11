<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class UsersTableSeeder extends Seeder
{

public function run(): void
{
    // Use the Model instead of DB::table
    User::create([
        'username' => 'manager',
        'name'     => 'Manager',
        'email'    => 'manager@example.com',
        'password' => '12345678', // Just write the string, User.php hashes it for you!
        'role'     => 'Manager',
        'status'   => 'active',
    ]);
}
}

