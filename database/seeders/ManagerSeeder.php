<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ManagerSeeder extends Seeder
{
    public function run()
    {
        \App\Models\User::updateOrCreate(
            ['email' => 'manager@example.com'],
            [
                'username' => 'main_manager',
                'name'     => 'Main Manager',
                'password' => Hash::make('Manager123'), // كلمة المرور مشفرة
                'role'     => 'Manager',
                'status'   => 'active',
            ]
        );
    }
}
