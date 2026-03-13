<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // مستخدم مدير
        // User::create([
        //     'username' => 'manager1',
        //     'name' => 'Manager',
        //     'email' => 'manager@example.com',
        //     'password' => Hash::make('Manager123'),  // ✅ اخترنا هذا الإصدار (مع التشفير)
        //     'role' => 'Manager',
        //     'state' => 'active',
        //     'profile_image' => null,
        // ]);

        // // مستخدم طالب
        // User::create([
        //     'username' => 'student1',
        //     'name' => 'Student One',
        //     'email' => 'student1@example.com',
        //     'password' => Hash::make('Student123'),
        //     'role' => 'Student',
        //     'state' => 'active',
        //     'profile_image' => null,
        // ]);

        // // مستخدم مشرف
        // User::create([
        //     'username' => 'supervisor1',
        //     'name' => 'Supervisor One',
        //     'email' => 'supervisor1@example.com',
        //     'password' => Hash::make('Supervisor123'),
        //     'role' => 'Supervisor',
        //     'state' => 'active',
        //     'profile_image' => null,
        // ]);

        // // مستخدم مستثمر
        // User::create([
        //     'username' => 'investor1',
        //     'name' => 'Investor One',
        //     'email' => 'investor1@example.com',
        //     'password' => Hash::make('Investor123'),
        //     'role' => 'Investor',
        //     'state' => 'active',
        //     'profile_image' => null,
        // ]);

        // يمكن إضافة مستخدمين آخرين بنفس الطريقة
    }
}