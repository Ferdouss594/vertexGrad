<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Requests\Admin\StoreProjectRequest;
use App\Http\Requests\Admin\UpdateProjectRequest;

class ProjectController extends Controller
{
    public function index(Request $request)
    {
        $query = Project::with(['student', 'supervisor', 'manager', 'investor', 'media']);

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

        return view('projects.create', compact('students','supervisors','managers','investors'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:150',
            'description' => 'nullable|string',
            'category' => 'nullable|string|max:50',
            'status' => 'required|in:Pending,Active,Completed',

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

            // ✅ Spatie-compatible media (same as frontend)
            'project_photos' => 'nullable|array',
            'project_photos.*' => 'image|max:5120',
            'project_video' => 'nullable|mimetypes:video/mp4,video/quicktime,video/ogg|max:51200',
        ]);

        $data['is_featured'] = $request->boolean('is_featured');

        $project = Project::create($data);

        // images -> "images"
        if ($request->hasFile('project_photos')) {
            foreach ($request->file('project_photos') as $img) {
                $project->addMedia($img)->toMediaCollection('images');
            }
        }

        // video -> "videos"
        if ($request->hasFile('project_video')) {
            $project->addMedia($request->file('project_video'))->toMediaCollection('videos');
        }

        return redirect()->route('admin.projects.index')
            ->with('success', 'Project created successfully!');
    }

    public function show(Project $project)
    {
        $project->load(['student','supervisor','manager','investor','media','files']);
        return view('projects.show', compact('project'));
    }

    public function edit(Project $project)
    {
        $students = User::where('role', 'Student')->get();
        $supervisors = User::where('role', 'Supervisor')->get();
        $managers = User::where('role', 'Manager')->get();
        $investors = User::where('role', 'Investor')->get();

        return view('projects.edit', compact('project','students','supervisors','managers','investors'));
    }

    public function update(Request $request, Project $project)
    {
        $data = $request->validate([
            'name' => 'required|string|max:150',
            'description' => 'nullable|string',
            'category' => 'nullable|string|max:50',
            'status' => 'required|in:Pending,Active,Completed',
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
}