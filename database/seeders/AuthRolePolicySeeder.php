<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\AuthRolePolicy;

class AuthRolePolicySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

public function run(): void
{
    $roles = ['Student', 'Investor', 'Supervisor', 'Manager'];

    foreach ($roles as $role) {
        AuthRolePolicy::updateOrCreate(
            ['role_name' => $role],
            [
                'email_verification_mode' => 'required',
                'otp_mode' => 'optional',
                'trusted_devices_enabled' => true,
                'recovery_codes_enabled' => true,
                'suspicious_login_alerts_enabled' => true,
                'remember_me_enabled' => true,
                'emergency_bypass_enabled' => false,
                'notes' => null,
            ]
        );
    }
}
}
