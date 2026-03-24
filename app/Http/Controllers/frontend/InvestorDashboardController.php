<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\Project;

class InvestorDashboardController extends Controller
{
    public function index()
    {
        $user = auth('web')->user();

        abort_unless($user && $user->role === 'Investor', 403);

        $myInvestments = $user->investments()
            ->with(['student', 'media', 'investors'])
            ->orderByPivot('created_at', 'desc')
            ->get();

        $totalDeployed = $myInvestments
            ->where('pivot.status', 'approved')
            ->sum(function ($project) {
                return (float) ($project->pivot->amount ?? 0);
            });

        // Projects this investor already interacted with
        $interactedProjectIds = $user->investments()
            ->pluck('projects.project_id');

        // Preferred categories based on investor history
        $preferredCategories = $user->investments()
            ->whereNotNull('projects.category')
            ->pluck('projects.category')
            ->filter(function ($category) {
                return filled(trim($category));
            })
            ->map(function ($category) {
                return trim($category);
            })
            ->unique()
            ->values();

        // Suggested projects: same categories first, excluding already interacted projects
        $suggestedProjectsQuery = Project::with(['student', 'media', 'investors'])
            ->where('status', 'active')
            ->whereNotIn('project_id', $interactedProjectIds);

        if ($preferredCategories->isNotEmpty()) {
            $suggestedProjectsQuery->whereIn('category', $preferredCategories);
        }

        $suggestedProjects = $suggestedProjectsQuery
            ->latest('project_id')
            ->take(6)
            ->get();

        // Fallback: fill remaining slots with latest active projects
        if ($suggestedProjects->count() < 6) {
            $existingSuggestedIds = $suggestedProjects->pluck('project_id');

            $fallbackProjects = Project::with(['student', 'media', 'investors'])
                ->where('status', 'active')
                ->whereNotIn('project_id', $interactedProjectIds)
                ->whereNotIn('project_id', $existingSuggestedIds)
                ->latest('project_id')
                ->take(6 - $suggestedProjects->count())
                ->get();

            $suggestedProjects = $suggestedProjects->concat($fallbackProjects);
        }

        $marketplaceStats = [
            'active_projects'  => Project::where('status', 'active')->count(),
            'interested_count' => $myInvestments->where('pivot.status', 'interested')->count(),
            'requested_count'  => $myInvestments->where('pivot.status', 'requested')->count(),
            'approved_count'   => $myInvestments->where('pivot.status', 'approved')->count(),
        ];

        $announcements = Announcement::published()
            ->where(function ($query) {
                $query->where('audience', 'all')
                      ->orWhere('audience', 'investors');
            })
            ->ordered()
            ->get();

        return view('frontend.dashboard.investor', compact(
            'myInvestments',
            'totalDeployed',
            'suggestedProjects',
            'marketplaceStats',
            'announcements'
        ));
    }

    public function investments()
    {
        $user = auth('web')->user();

        abort_unless($user && $user->role === 'Investor', 403);

        $projects = $user->investments()
            ->with('student')
            ->orderByPivot('created_at', 'desc')
            ->get();

        return view('frontend.investor.investments', compact('projects'));
    }
}