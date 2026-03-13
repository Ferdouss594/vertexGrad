<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Project;

class HomeController extends Controller
{
    public function index()
    {
        $featuredProjects = Project::with(['media', 'student'])
            ->where('status', 'active')
            ->latest('project_id')
            ->take(6)
            ->get();

        $latestProjects = Project::with(['media', 'student'])
            ->where('status', 'active')
            ->latest('project_id')
            ->take(3)
            ->get();

        $stats = [
            'active_projects' => Project::where('status', 'active')->count(),
            'completed_projects' => Project::where('status', 'completed')->count(),
            'total_visible_projects' => Project::whereIn('status', ['active', 'completed'])->count(),
            'total_funding' => Project::whereIn('status', ['active', 'completed'])->sum('budget'),
        ];

        return view('frontend.pages.home', compact(
            'featuredProjects',
            'latestProjects',
            'stats'
        ));
    }
}