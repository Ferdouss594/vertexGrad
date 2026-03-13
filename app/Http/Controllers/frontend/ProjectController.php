<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
public function index(Request $request)
{
    $query = Project::with(['media', 'student', 'investors'])
        ->where('status', 'active');

    $selectedCategory = trim((string) $request->get('category', ''));

    if ($selectedCategory !== '') {
        $query->whereRaw('LOWER(TRIM(category)) = ?', [mb_strtolower($selectedCategory)]);
    }

    if ($request->filled('budget_max')) {
        $query->where('budget', '<=', (float) $request->budget_max);
    }

    $projects = $query->latest('project_id')
        ->paginate(12)
        ->appends($request->all());

    $categories = Project::query()
        ->where('status', 'active')
        ->whereNotNull('category')
        ->whereRaw('TRIM(category) != ""')
        ->select('category')
        ->distinct()
        ->orderBy('category')
        ->pluck('category');

    return view('frontend.projects.index', compact('projects', 'categories'));
}

    public function show(Project $project)
    {
        $project->load(['media', 'student', 'files', 'investors']);

        $user = auth('web')->user();

        // Student can view only their own project
        if ($user && $user->role === 'Student') {
            if ($project->student_id !== $user->id) {
                abort(403);
            }
        } else {
            // Public/investor side: only active projects are viewable
            if ($project->status !== 'active') {
                abort(404);
            }
        }

        return view('frontend.projects.show', compact('project'));
    }

    public function mediaForm(Project $project)
    {
        if (!auth('web')->check() || auth('web')->id() !== $project->student_id) {
            abort(403);
        }

        if (!in_array($project->status, ['pending', 'active'])) {
            return back()->with('error', 'Media uploads are not allowed for this project status.');
        }

        return view('frontend.projects.media_upload', compact('project'));
    }

    public function mediaUpload(Request $request, Project $project)
    {
        if (!auth('web')->check() || auth('web')->id() !== $project->student_id) {
            abort(403);
        }

        if (!in_array($project->status, ['pending', 'active'])) {
            return back()->with('error', 'Media uploads are not allowed for this project status.');
        }

        $request->validate([
            'project_photos'   => 'nullable|array',
            'project_photos.*' => 'image|max:5120',
            'project_video'    => 'nullable|mimes:mp4,mov,ogg,qt|max:51200',
        ]);

        if ($request->hasFile('project_photos')) {
            foreach ($request->file('project_photos') as $img) {
                $project->addMedia($img)->toMediaCollection('images');
            }
        }

        if ($request->hasFile('project_video')) {
            $project->addMedia($request->file('project_video'))->toMediaCollection('videos');
        }

        return back()->with('success', 'Media uploaded successfully!');
    }

public function invest(Project $project)
{
    $user = Auth::guard('web')->user();

    if (!$user || $user->role !== 'Investor') {
        abort(403);
    }

    if ($project->status !== 'active') {
        return back()->with('error', 'This project is not open for investment.');
    }

    if ($project->investors()->where('users.id', $user->id)->exists()) {
        return back()->with('error', 'You already expressed interest in this project.');
    }

    $project->investors()->attach($user->id, [
        'status' => 'interested',
        'amount' => null,
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    // notify managers
    $managers = \App\Models\User::where('role', 'Manager')
        ->where('status', 'active')
        ->get();

    \Notification::send($managers, new \App\Notifications\InvestorInterestSubmittedNotification($project, $user));

    return back()->with('success', 'Your investment interest was submitted successfully.');
}

public function removeInterest(Project $project)
{
    $user = auth('web')->user();

    if (!$user || $user->role !== 'Investor') {
        abort(403);
    }

    $project->investors()->detach($user->id);

    return back()->with('success', 'Your interest was removed successfully.');
}

public function requestFunding(Request $request, Project $project)
{
    $user = auth('web')->user();

    if (!$user || $user->role !== 'Investor') {
        abort(403);
    }

    if ($project->status !== 'active') {
        return back()->with('error', 'This project is not open for funding requests.');
    }

    $data = $request->validate([
        'amount'  => 'required|numeric|min:1',
        'message' => 'required|string|max:2000',
    ]);

    $existing = $project->investors()->where('users.id', $user->id)->first();

    if ($existing && in_array($existing->pivot->status, ['requested', 'approved'])) {
        return back()->with('error', 'You already submitted a funding request for this project.');
    }

    $project->investors()->syncWithoutDetaching([
        $user->id => [
            'status'     => 'requested',
            'amount'     => $data['amount'] ?? null,
            'message'    => $data['message'] ?? null,
            'updated_at' => now(),
            'created_at' => $existing ? $existing->pivot->created_at : now(),
        ]
    ]);

    $managers = \App\Models\User::where('role', 'Manager')
        ->where('status', 'active')
        ->get();

    \Illuminate\Support\Facades\Notification::send(
        $managers,
        new \App\Notifications\FundingRequestSubmittedNotification($project, $user, $data['amount'] ?? null)
    );

    return back()->with('success', 'Your funding request was submitted successfully.');
}

}