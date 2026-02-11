<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\ProjectFile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProjectController extends Controller
{
    // عرض كل المشاريع
public function index(Request $request)
{
    $query = Project::with(['student', 'files']);

    // 1. Filter by Category (Matching 'category' name in Blade)
    if ($request->filled('category')) {
        $query->where('category', $request->category);
    }

    // 2. Filter by Budget (Matching 'budget_max' name in Blade)
    if ($request->filled('budget_max')) {
        $query->where('budget', '<=', $request->budget_max);
    }

    // 3. Sorting
    $query->orderBy('created_at', 'desc');

    // appends(request()->all()) ensures filters stay active when clicking page 2, 3, etc.
    $projects = $query->paginate(10)->appends($request->all());
    $totalProjects = Project::count();

    return view('frontend.projects.index', compact('projects', 'totalProjects'));
}

    // عرض مشروع واحد مع التفاصيل
public function show($id)
{
    // Eager load 'student' and 'files' to prevent extra database queries
    $project = Project::with(['student', 'files'])->findOrFail($id);

    // Safety: Ensure students only see their own projects
    if (auth()->user()->role === 'Student' && $project->student_id !== auth()->id()) {
        abort(403, 'Unauthorized access to this project details.');
    }

    return view('frontend.projects.show', compact('project'));
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

    // حفظ المشروع الجديد + رفع الملفات
    public function store(Request $request)
    {
        // 1️⃣ التحقق من صحة البيانات الأساسية
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
            'project_files.images.*' => 'nullable|file|mimes:jpg,jpeg,png,gif',  // الصور فقط
    'project_files.videos.*' => 'nullable|file|mimes:mp4,mov,avi,wmv',   // الفيديوهات فقط
    'project_files.pdfs.*'   => 'nullable|file|mimes:pdf',               // PDF
    'project_files.ppts.*'   => 'nullable|file|mimes:ppt,pptx',          // PPT / PPTX
        ]);

        // 2️⃣ إنشاء المشروع
        $project = Project::create($data);

        // 3️⃣ رفع الملفات إذا وُجدت
        if ($request->hasFile('project_files')) {
            foreach ($request->file('project_files') as $file) {

                // حفظ الملف في storage/app/public/projects/{project_id}
                $path = $file->store('projects/'.$project->project_id, 'public');

                // تحديد نوع الملف تلقائيًا
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

                // 4️⃣ إنشاء سجل الملف في قاعدة البيانات
                $project->files()->create([
                    'file_path' => $path,
                    'file_type' => $type
                ]);
            }
        }

        return redirect()->route('projects.index')
                         ->with('success', 'Project created successfully with files!');
    }
}
