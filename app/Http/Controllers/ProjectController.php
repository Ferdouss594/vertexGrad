<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProjectController extends Controller
{
    // عرض كل المشاريع
    public function index()
    {
        $projects = Project::with(['student', 'supervisor', 'manager', 'investor'])->get();
        return view('projects.index', compact('projects'));
    }

    // عرض مشروع واحد مع التفاصيل
    public function show(Project $project)
    {
        $project->load(['tasks', 'evaluations', 'reports', 'files']);
        return view('projects.show', compact('project'));
    }

    // نموذج إضافة مشروع جديد
    public function create()
    {
        // جلب جميع المستخدمين حسب الفئة
        $students = User::where('role', 'Student')->get();
        $supervisors = User::where('role', 'Supervisor')->get();
        $managers = User::where('role', 'Manager')->get();
        $investors = User::where('role', 'Investor')->get();

        return view('projects.create', compact('students', 'supervisors', 'managers', 'investors'));
    }

    // حفظ المشروع الجديد
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
]);


        Project::create($data);

        return redirect()->route('projects.index')->with('success', 'Project created successfully!');
    }
}
