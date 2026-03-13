<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;

class AcademicDashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = auth('web')->user();

        abort_unless($user && $user->role === 'Student', 403);

        $projects = Project::where('student_id', $user->id)
            ->with('media')
            ->latest('project_id')
            ->get();

        $selectedId = (int) $request->query('project', 0);
        $currentProject = $selectedId ? $projects->firstWhere('project_id', $selectedId) : null;

        if (!$currentProject) {
            $currentProject = $projects->first();
        }

        $progress = 20;
        if ($currentProject) {
            if ($currentProject->status === 'active') {
                $progress = 60;
            } elseif ($currentProject->status === 'completed') {
                $progress = 100;
            } elseif ($currentProject->status === 'rejected') {
                $progress = 0;
            }
        }

        $currentImages = $currentProject ? $currentProject->getMedia('images') : collect();
        $currentVideoUrl = $currentProject ? $currentProject->getFirstMediaUrl('videos') : null;

        return view('frontend.dashboard.academic', compact(
            'user',
            'projects',
            'currentProject',
            'progress',
            'currentImages',
            'currentVideoUrl'
        ));
    }
}