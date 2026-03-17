<?php

namespace App\Http\Controllers\Supervisor;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;

class SupervisorDashboardController extends Controller
{
    public function index()
    {
        $user = auth('admin')->user();
        abort_unless($user && $user->role === 'Supervisor', 403);

        $baseQuery = Project::query()->where('supervisor_id', $user->id);

        $stats = [
            'total_projects'      => (clone $baseQuery)->count(),
            'pending_reviews'     => (clone $baseQuery)->whereIn('status', ['pending', 'awaiting_manual_review', 'scan_requested'])->count(),
            'approved_projects'   => (clone $baseQuery)->where('status', 'approved')->count(),
            'revision_requested'  => (clone $baseQuery)->where('supervisor_status', 'revision_requested')->count(),
        ];

        $latestProjects = Project::with(['student', 'supervisor'])
            ->where('supervisor_id', $user->id)
            ->latest('updated_at')
            ->take(8)
            ->get();

        return view('supervisor.dashboard', compact('user', 'stats', 'latestProjects'));
    }
}