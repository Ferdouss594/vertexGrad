<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Notifications\ProjectApprovedNotification;
use App\Notifications\ProjectRejectedNotification;

class ProjectController extends Controller
{
    public function index(Request $request)
    {
        $query = Project::with(['student', 'supervisor', 'manager', 'media', 'investors']);

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        if ($request->filled('budget_max')) {
            $query->where('budget', '<=', $request->budget_max);
        }

        $projects = $query->latest('project_id')->paginate(10)->appends($request->all());
        $totalProjects = Project::count();

        return view('projects.index', compact('projects', 'totalProjects'));
    }

    public function create()
    {
        $students = User::where('role', 'Student')->get();
        $supervisors = User::where('role', 'Supervisor')->get();
        $managers = User::where('role', 'Manager')->get();
        $investors = User::where('role', 'Investor')->get();

        return view('projects.create', compact('students', 'supervisors', 'managers', 'investors'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:150',
            'description' => 'nullable|string',
            'category' => 'nullable|string|max:50',
            'status' => 'required|in:pending,active,completed',

            'student_id' => ['required', Rule::exists('users', 'id')->where('role', 'Student')],
            'supervisor_id' => ['nullable', Rule::exists('users', 'id')->where('role', 'Supervisor')],
            'manager_id' => ['nullable', Rule::exists('users', 'id')->where('role', 'Manager')],
            'investor_id' => ['nullable', Rule::exists('users', 'id')->where('role', 'Investor')],

            'budget' => 'nullable|numeric|min:100',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'priority' => 'nullable|in:Low,Medium,High',
            'progress' => 'nullable|integer|min:0|max:100',

            'is_featured' => 'nullable|boolean',
            'tags' => 'nullable|array',

            'project_photos' => 'nullable|array',
            'project_photos.*' => 'image|max:5120',
            'project_video' => 'nullable|mimetypes:video/mp4,video/quicktime,video/ogg|max:51200',
        ]);

        $data['is_featured'] = $request->boolean('is_featured');

        $project = Project::create($data);

        if ($request->hasFile('project_photos')) {
            foreach ($request->file('project_photos') as $img) {
                $project->addMedia($img)->toMediaCollection('images');
            }
        }

        if ($request->hasFile('project_video')) {
            $project->addMedia($request->file('project_video'))->toMediaCollection('videos');
        }

        return redirect()->route('admin.projects.index')
            ->with('success', 'Project created successfully!');
    }

    public function show(Project $project)
    {
        $project->load([
            'student',
            'supervisor',
            'manager',
            'media',
            'files',
            'investors',
        ]);

        return view('projects.show', compact('project'));
    }

    public function edit(Project $project)
    {
        $students = User::where('role', 'Student')->get();
        $supervisors = User::where('role', 'Supervisor')->get();
        $managers = User::where('role', 'Manager')->get();
        $investors = User::where('role', 'Investor')->get();

        return view('projects.edit', compact('project', 'students', 'supervisors', 'managers', 'investors'));
    }

    public function update(Request $request, Project $project)
    {
        $data = $request->validate([
            'name' => 'required|string|max:150',
            'description' => 'nullable|string',
            'category' => 'nullable|string|max:50',
            'status' => 'required|in:pending,active,completed,rejected',
            'budget' => 'nullable|numeric',
        ]);

        $project->update($data);

        return redirect()->route('admin.projects.index')->with('success', 'Project updated.');
    }

    public function destroy(Project $project)
    {
        $project->delete();

        return redirect()->route('admin.projects.index')->with('success', 'Project deleted.');
    }

    public function approve(Project $project)
    {
        $user = auth('admin')->user();

        if ($project->status !== 'pending') {
            return back()->with('error', 'Only pending projects can be approved.');
        }

        $project->update([
            'status' => 'active',
            'manager_id' => $user->id,
        ]);

        if ($project->student) {
            $project->student->notify(new ProjectApprovedNotification($project));
        }

        $user->unreadNotifications()
            ->where('type', \App\Notifications\ProjectSubmittedNotification::class)
            ->get()
            ->filter(function ($notification) use ($project) {
                return ($notification->data['project_id'] ?? null) == $project->project_id;
            })
            ->each(function ($notification) {
                $notification->markAsRead();
            });

        return back()->with('success', 'Project approved and assigned to you.');
    }

    public function reject(Project $project)
    {
        $user = auth('admin')->user();

        if ($project->status !== 'pending') {
            return back()->with('error', 'Only pending projects can be rejected.');
        }

        $project->update([
            'status' => 'rejected',
            'manager_id' => $user->id,
        ]);

        if ($project->student) {
            $project->student->notify(new ProjectRejectedNotification($project));
        }

        $user->unreadNotifications()
            ->where('type', \App\Notifications\ProjectSubmittedNotification::class)
            ->get()
            ->filter(function ($notification) use ($project) {
                return ($notification->data['project_id'] ?? null) == $project->project_id;
            })
            ->each(function ($notification) {
                $notification->markAsRead();
            });

        return back()->with('success', 'Project rejected successfully.');
    }

public function approveInvestor(Project $project, User $user)
{
    if ($user->role !== 'Investor') {
        return back()->with('error', 'Selected user is not an investor.');
    }

    $relation = $project->investors()
        ->where('users.id', $user->id)
        ->first();

    if (! $relation || $relation->pivot->status !== 'requested') {
        return back()->with('error', 'This investor does not have a pending funding request.');
    }

    $project->investors()->updateExistingPivot($user->id, [
        'status' => 'approved',
        'updated_at' => now(),
    ]);

    $user->notify(new \App\Notifications\FundingRequestApprovedNotification($project));

    return back()->with('success', 'Funding request approved successfully.');
}

public function rejectInvestor(Project $project, User $user)
{
    if ($user->role !== 'Investor') {
        return back()->with('error', 'Selected user is not an investor.');
    }

    $relation = $project->investors()
        ->where('users.id', $user->id)
        ->first();

    if (! $relation || $relation->pivot->status !== 'requested') {
        return back()->with('error', 'This investor does not have a pending funding request.');
    }

    $project->investors()->updateExistingPivot($user->id, [
        'status' => 'rejected',
        'updated_at' => now(),
    ]);

    $user->notify(new \App\Notifications\FundingRequestRejectedNotification($project));

    return back()->with('success', 'Funding request rejected successfully.');
}



}