<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Manager;
use App\Models\ManagerPermission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ManagerController extends Controller
{
    // =================== قائمة المدراء ===================
    public function index(Request $request)
    {
        $query = Manager::with('user');

        if ($request->filled('search')) {
            $s = $request->search;
            $query->whereHas('user', function ($q) use ($s) {
                $q->where('name', 'like', "%{$s}%")
                  ->orWhere('email', 'like', "%{$s}%")
                  ->orWhere('username', 'like', "%{$s}%");
            });
        }

        if ($request->filled('status')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('status', $request->status);
            });
        }

        $sortBy  = $request->get('sort_by', 'created_at');
        $sortDir = $request->get('sort_dir', 'desc');

        $managers = $query->orderBy($sortBy, $sortDir)
            ->paginate(15)
            ->withQueryString();

        $stats = [
            'total'  => User::where('role', 'Manager')->count(),
            'active' => User::where('role', 'Manager')->where('status', 'active')->count(),
            'inactive' => User::where('role', 'Manager')->where('status', 'inactive')->count(),
        ];

        return view('manager.index', compact('managers', 'stats'));
    }

    // =================== تحويل كل مستخدمي role=Manager ===================
    public function migrateUsersToManagers()
    {
        $users = User::where('role', 'Manager')->get();

        foreach ($users as $user) {
            $exists = Manager::where('user_id', $user->id)->exists();
            if (!$exists) {
                Manager::create([
                    'user_id'    => $user->id,
                    'department' => null,   // يمكن تعديلها لاحقًا
                    'position'   => 'Manager', // أو أي قيمة
                ]);
            }
        }

        return redirect()->route('manager.index')->with('success', 'All Manager users have been migrated successfully.');
    }
public function sync()
{
    // جلب كل المستخدمين الذين دورهم Manager
    $users = User::where('role', 'Manager')->get();

    foreach ($users as $user) {
        // تحقق إذا لم يكن موجود بالفعل في جدول managers
        if (!Manager::where('user_id', $user->id)->exists()) {
            Manager::create([
                'user_id' => $user->id,
                'department' => null, // يمكن تعديلها لاحقًا
            ]);
        }
    }

    return redirect()->route('manager.index')->with('success', 'All manager users synced successfully.');
}

    // =================== صفحة إنشاء مدير ===================
    public function create()
    {
        $users = User::where('role', 'Manager')
                     ->whereNotIn('id', Manager::pluck('user_id'))
                     ->get();
        return view('manager.create', compact('users'));
    }

    // =================== حفظ مدير جديد ===================
    public function store(Request $request)
    {
        $request->validate([
            'user_id'    => 'required|exists:users,id|unique:managers,user_id',
            'department' => 'nullable|string|max:255',
            'position'   => 'nullable|string|max:255',
        ]);

        Manager::create($request->all());

        return redirect()->route('manager.index')->with('success', 'Manager created successfully.');
    }

    // =================== صفحة تعديل مدير ===================
    public function edit(Manager $manager)
    {
        return view('manager.edit', compact('manager'));
    }

    // =================== تحديث مدير ===================
    public function update(Request $request, Manager $manager)
    {
        $request->validate([
            'department' => 'nullable|string|max:255',
            'position'   => 'nullable|string|max:255',
        ]);

        $manager->update($request->all());

        return redirect()->route('manager.index')->with('success', 'Manager updated successfully.');
    }

    // =================== حذف مدير ===================
    public function destroy(Manager $manager)
    {
        $manager->delete();
        return redirect()->route('manager.index')->with('success', 'Manager deleted successfully.');
    }
}
