<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

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

    public function settings()
    {
        $user = auth('web')->user();

        abort_unless($user && $user->role === 'Investor', 403);

        $myInvestments = $user->investments()->get();

        $approvedInvestments = $myInvestments->where('pivot.status', 'approved')->count();

        return view('frontend.settings.investor', compact(
            'user',
            'myInvestments',
            'approvedInvestments'
        ));
    }

    public function updateSettings(Request $request)
    {
        $user = auth('web')->user();

        abort_unless($user && $user->role === 'Investor', 403);

        $validated = $request->validate([
            'full_name' => ['nullable', 'string', 'max:255'],
            'email' => [
                'nullable',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user->id),
            ],
            'contact_name' => ['nullable', 'string', 'max:255'],
            'fund_name' => ['nullable', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'city' => ['nullable', 'string', 'max:100'],
            'min_investment' => ['nullable', 'numeric', 'min:0'],
            'investment_focus' => ['nullable', 'string', 'max:1000'],
            'profile_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        $userTable = $user->getTable();

        if (array_key_exists('full_name', $validated) && !empty($validated['full_name']) && Schema::hasColumn($userTable, 'name')) {
            $user->name = $validated['full_name'];
        }

        if (array_key_exists('email', $validated) && !empty($validated['email']) && Schema::hasColumn($userTable, 'email')) {
            $user->email = $validated['email'];
        }

        if (array_key_exists('contact_name', $validated) && Schema::hasColumn($userTable, 'contact_name')) {
            $user->contact_name = $validated['contact_name'];
        }

        if (array_key_exists('fund_name', $validated) && Schema::hasColumn($userTable, 'fund_name')) {
            $user->fund_name = $validated['fund_name'];
        }

        if (array_key_exists('phone', $validated) && Schema::hasColumn($userTable, 'phone')) {
            $user->phone = $validated['phone'];
        }

        if (array_key_exists('city', $validated) && Schema::hasColumn($userTable, 'city')) {
            $user->city = $validated['city'];
        }

        if (array_key_exists('min_investment', $validated) && Schema::hasColumn($userTable, 'min_investment')) {
            $user->min_investment = $validated['min_investment'];
        }

        if (array_key_exists('investment_focus', $validated) && Schema::hasColumn($userTable, 'investment_focus')) {
            $user->investment_focus = $validated['investment_focus'];
        }

        if ($request->hasFile('profile_image') && Schema::hasColumn($userTable, 'profile_image')) {
            if (!empty($user->profile_image) && Storage::disk('public')->exists($user->profile_image)) {
                Storage::disk('public')->delete($user->profile_image);
            }

            $user->profile_image = $request->file('profile_image')->store('profile-images', 'public');
        }

        $user->save();

        return redirect()
            ->route('settings.investor')
            ->with('success', 'Investor settings updated successfully.');
    }
}