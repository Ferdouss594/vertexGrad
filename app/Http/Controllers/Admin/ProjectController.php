<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\User;
use App\Services\ProjectService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProjectController extends Controller
{
    public function __construct(private ProjectService $service) {}

    public function index(Request $request)
    {
        $query = Project::with(['student', 'files']);

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        if ($request->filled('budget_max')) {
            $query->where('budget', '<=', $request->budget_max);
        }

        $projects = $query->latest()->paginate(10)->appends($request->all());
        $totalProjects = Project::count();

        // ✅ backend view (your existing)
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
            'budget' => 'nullable|numeric',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'priority' => 'nullable|in:Low,Medium,High',
            'progress' => 'nullable|integer|min:0|max:100',
            'is_featured' => 'nullable|boolean',
            'tags' => 'nullable|array',

            // admin files
            'project_files.*' => 'nullable|file|max:51200',
        ]);

        $adminFiles = $request->file('project_files') ?? null;

        $this->service->create($data, $adminFiles, null);

        return redirect()->route('admin.projects.index')
            ->with('success', 'Project created successfully!');
    }

    public function show(Project $project)
    {
        $project->load(['student','files']);
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