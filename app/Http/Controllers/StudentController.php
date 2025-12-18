<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    // عرض كل الطلاب
    public function index(Request $request)
    {
        $query = User::where('role', 'Student')->with('student');

        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', "%{$request->search}%")
                  ->orWhere('email', 'like', "%{$request->search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $students = $query->paginate(15);

        return view('students.index', compact('students'));
    }

    // إنشاء صفحة إضافة طالب
    public function create()
    {
        return view('students.create');
    }

    // حفظ طالب جديد
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:150',
            'email' => 'required|email|unique:users,email',
            'status' => 'nullable|string|in:active,pending,inactive,disabled',
            'major' => 'nullable|string|max:50',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
        ]);

        $user = User::create([
    'username' => explode('@', $request->email)[0], // توليد تلقائي
    'name'     => $request->name,
    'email'    => $request->email,
    'role'     => 'Student',
    'status'   => $request->status ?? 'active',
    'password' => bcrypt('12345678'),
]);


        if ($request->filled('major') || $request->filled('phone') || $request->filled('address')) {
            $user->student()->create([
                'major' => $request->major,
                'phone' => $request->phone,
                'address' => $request->address,
            ]);
        }

        return redirect()->route('students.index')->with('success', 'Student created successfully.');
    }

    // عرض صفحة تعديل الطالب
    public function edit(User $student)
    {
        $student->load('student');
        return view('students.edit', compact('student'));
    }

    // تحديث بيانات الطالب والمستخدم
    public function update(Request $request, User $student)
    {
        $request->validate([
            'name' => 'required|string|max:150',
            'email' => 'required|email|unique:users,email,' . $student->id,
            'status' => 'required|string|in:active,pending,inactive,disabled',
            'major' => 'nullable|string|max:50',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
        ]);

        $student->update([
            'name' => $request->name,
            'email' => $request->email,
            'status' => $request->status,
        ]);

        if ($student->student) {
            $student->student->update([
                'major' => $request->major,
                'phone' => $request->phone,
                'address' => $request->address,
            ]);
        } else {
            if ($request->filled('major') || $request->filled('phone') || $request->filled('address')) {
                $student->student()->create([
                    'major' => $request->major,
                    'phone' => $request->phone,
                    'address' => $request->address,
                ]);
            }
        }

        return redirect()->route('students.index')->with('success', 'Student updated successfully.');
    }

    // حذف الطالب والمستخدم
    public function destroy(User $student)
    {
        $student->delete();
        return redirect()->route('students.index')->with('success', 'Student deleted successfully.');
    }

    // عرض تفاصيل الطالب
    public function show(User $student)
    {
        $student->load('student');
        return view('students.show', compact('student'));
    }
    public function updateStatus($id, $status)
{
    // التحقق أن الحالة صحيحة
    if (!in_array($status, ['active', 'inactive', 'pending', 'disabled'])) {
        return back()->with('error', 'Invalid status value.');
    }

    // جلب المستخدم الطالب
    $student = User::where('role', 'Student')->findOrFail($id);

    // تحديث الحالة
    $student->update(['status' => $status]);

    return redirect()->route('students.index')->with('success', 'Status updated successfully.');
}

}
