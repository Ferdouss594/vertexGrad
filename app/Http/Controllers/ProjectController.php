<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\ProjectFile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProjectController extends Controller
{
    // LIST (Admin / Frontend depending on URL)
    public function index(Request $request)
    {
        $query = Project::with(['student', 'files']);

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        if ($request->filled('budget_max')) {
            $query->where('budget', '<=', $request->budget_max);
        }

        $query->orderBy('created_at', 'desc');

        $projects = $query->paginate(10)->appends($request->all());
        $totalProjects = Project::count();

        // ✅ IMPORTANT: return the EXISTING backend view you already have
        // you said you have: resources/views/projects/index.blade.php
        if ($request->is('admin/*')) {
            return view('projects.index', compact('projects', 'totalProjects'));
        }

        // frontend marketplace (if you ever call index from frontend)
        return view('frontend.projects.index', compact('projects', 'totalProjects'));
    }

    // SHOW (Admin / Frontend depending on URL)
    public function show(Request $request, $id)
    {
        $project = Project::with(['student', 'files'])->findOrFail($id);

        // Safety: Ensure students only see their own projects
        if (auth()->check() && auth()->user()->role === 'Student' && $project->student_id !== auth()->id()) {
            abort(403, 'Unauthorized access to this project details.');
        }

        // ✅ Admin should NOT use frontend view
        if ($request->is('admin/*')) {
            // use your backend show if exists (resources/views/projects/show.blade.php)
            return view('projects.show', compact('project'));
        }

        return view('frontend.projects.show', compact('project'));
    }

    // CREATE
    public function create(Request $request)
    {
        $students = User::where('role', 'Student')->get();
        $supervisors = User::where('role', 'Supervisor')->get();
        $managers = User::where('role', 'Manager')->get();
        $investors = User::where('role', 'Investor')->get();

        // ✅ Admin create uses backend create view you already have
        if ($request->is('admin/*')) {
            return view('projects.create', compact('students', 'supervisors', 'managers', 'investors'));
        }

        // If you ever need a separate frontend create page later:
        return view('frontend.projects.create', compact('students', 'supervisors', 'managers', 'investors'));
    }

    // STORE
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
            'project_files.images.*' => 'nullable|file|mimes:jpg,jpeg,png,gif',
            'project_files.videos.*' => 'nullable|file|mimes:mp4,mov,avi,wmv',
            'project_files.pdfs.*'   => 'nullable|file|mimes:pdf',
            'project_files.ppts.*'   => 'nullable|file|mimes:ppt,pptx',
        ]);

        $project = Project::create($data);

        if ($request->hasFile('project_files')) {
            foreach ($request->file('project_files') as $file) {

                $path = $file->store('projects/'.$project->project_id, 'public');

                $mime = $file->getMimeType();
                if (str_contains($mime, 'image')) {
                    $type = 'image';
                } elseif (str_contains($mime, 'video')) {
                    $type = 'video';
                } elseif (str_contains($mime, 'pdf')) {
                    $type = 'pdf';
                } else {
                    $type = 'other';
                }

                $project->files()->create([
                    'file_path' => $path,
                    'file_type' => $type
                ]);
            }
        }

        // ✅ IMPORTANT: redirect to ADMIN projects if request came from /admin/*
        if ($request->is('admin/*')) {
            return redirect()->route('admin.projects.index')
                ->with('success', 'Project created successfully with files!');
        }

        return redirect()->route('frontend.projects.index')
            ->with('success', 'Project created successfully with files!');
    }
}