<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ResetImportantUsersSeeder extends Seeder
{
    public function run()
    {
        // تحديث المدير الرئيسي
        $manager = User::where('email', 'manager@example.com')->first();
        if ($manager) {
            $manager->password = Hash::make('Manager123');
            $manager->save();
            $this->command->info("Password updated for Manager: {$manager->email}");
        } else {
            $this->command->error("Manager not found!");
        }

        // مثال لمشرف رئيسي
        $supervisor = User::where('email', 'supervisor@example.com')->first();
        if ($supervisor) {
            $supervisor->password = Hash::make('Supervisor123');
            $supervisor->save();
            $this->command->info("Password updated for Supervisor: {$supervisor->email}");
        } else {
            $this->command->warn("Supervisor not found, skipped.");
        }

        // يمكن إضافة مستخدمين آخرين بنفس الطريقة إذا احتجت
    }
}
