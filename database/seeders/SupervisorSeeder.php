<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Project;
use Illuminate\Support\Facades\Hash;

class SupervisorSeeder extends Seeder
{
    public function run(): void
    {
        // إنشاء المشرف
        $supervisor = User::firstOrCreate(
            ['email' => 'supervisor@vertexgrad.com'],
            [
                'username' => 'supervisor1',
                'name' => 'Main Supervisor',
                'password' => Hash::make('12345678'),
                'role' => 'Supervisor',
                'status' => 'active',
            ]
        );

        // ربط بعض المشاريع بالمشرف
        $projects = Project::take(5)->get();

        foreach ($projects as $project) {
            $project->update([
                'supervisor_id' => $supervisor->id
            ]);
        }
    }
}