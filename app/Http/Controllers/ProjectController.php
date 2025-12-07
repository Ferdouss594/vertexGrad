<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    // عرض كل المشاريع
    public function index()
    {
        $projects = Project::with(['student','supervisor','manager','investor'])->get();
        return view('projects.index', compact('projects'));
    }

    // عرض مشروع واحد مع التفاصيل
    public function show(Project $project)
    {
        $project->load(['tasks','evaluations','reports','files']);
        return view('projects.show', compact('project'));
    }

    // نموذج إضافة مشروع جديد
    public function create()
    {
        return view('projects.create');
    }

    // حفظ المشروع الجديد
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:150',
            'description' => 'nullable|string',
            'category' => 'nullable|string|max:50',
            'status' => 'required|in:Pending,Active,Completed',
            'student_id' => 'required|exists:students,student_id',
            'supervisor_id' => 'nullable|exists:supervisors,supervisor_id',
            'manager_id' => 'nullable|exists:managers,manager_id',
            'investor_id' => 'nullable|exists:investors,investor_id',
            'budget' => 'nullable|numeric',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
            'priority' => 'nullable|in:Low,Medium,High',
            'progress' => 'nullable|integer|min:0|max:100',
            'is_featured' => 'nullable|boolean',
            'tags' => 'nullable|array',
        ]);

        Project::create($data);

        return redirect()->route('projects.index')->with('success', 'Project created successfully!');
    }
}
