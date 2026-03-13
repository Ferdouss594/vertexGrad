<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Project;
use Illuminate\Support\Facades\DB;

class ProjectsSeeder extends Seeder
{
    public function run()
    {
        // جلب IDs موجودة من الجداول الصحيحة
        $students = DB::table('students')->pluck('id')->toArray();
        $supervisors = DB::table('supervisors')->pluck('id')->toArray();
        $managers = DB::table('managers')->pluck('id')->toArray();
        $investors = DB::table('investors')->pluck('id')->toArray();

        if(empty($students) || empty($supervisors) || empty($managers) || empty($investors)){
            $this->command->error('Please make sure students, supervisors, managers, and investors exist!');
            return;
        }

        $projects = [];

        for($i = 1; $i <= 20; $i++){
            $projects[] = [
                'name' => "Project $i",
                'description' => "Description for Project $i",
                'category' => "Category " . (($i % 5) + 1),
                'status' => ['Active','Completed','Pending'][array_rand(['Active','Completed','Pending'])],
                'student_id' => $students[ ($i-1) % count($students) ],
                'supervisor_id' => $supervisors[ ($i-1) % count($supervisors) ],
                'manager_id' => $managers[ ($i-1) % count($managers) ],
                'investor_id' => $investors[ ($i-1) % count($investors) ],
                'budget' => rand(1000,50000),
                'start_date' => now()->subDays(rand(0,365))->format('Y-m-d'),
                'end_date' => now()->addDays(rand(30,365))->format('Y-m-d'),
                'priority' => ['High','Medium','Low'][array_rand(['High','Medium','Low'])],
                'progress' => rand(0,100),
                'is_featured' => rand(0,1),
                'tags' => json_encode(['Tag'.rand(1,5),'Tag'.rand(6,10)]),
                'status_history' => json_encode([]),
            ];
        }

        foreach ($projects as $project) {
            Project::create($project);
        }

        $this->command->info('20 Projects have been seeded successfully!');
    }
}
