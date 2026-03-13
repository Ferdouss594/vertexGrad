<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_users'        => User::count(),
            'active_users'       => User::where('status', 'active')->count(),
            'students'           => User::where('role', 'Student')->count(),
            'investors'          => User::where('role', 'Investor')->count(),
            'managers'           => User::where('role', 'Manager')->count(),

            'total_projects'     => Project::count(),
            'pending_projects'   => Project::where('status', 'pending')->count(),
            'active_projects'    => Project::where('status', 'active')->count(),
            'completed_projects' => Project::where('status', 'completed')->count(),
            'rejected_projects'  => Project::where('status', 'rejected')->count(),

            'total_funding'      => Project::whereIn('status', ['active', 'completed'])->sum('budget'),
        ];

        $recentProjects = Project::with(['student', 'manager'])
            ->latest('project_id')
            ->take(6)
            ->get();

        $recentStudents = User::where('role', 'Student')
            ->latest('id')
            ->take(5)
            ->get();

        $recentInvestors = User::where('role', 'Investor')
            ->latest('id')
            ->take(5)
            ->get();

        return view('manager.dashboard', compact(
            'stats',
            'recentProjects',
            'recentStudents',
            'recentInvestors'
        ));
    }

    public function dashboard()
    {
        return $this->index();
    }
}