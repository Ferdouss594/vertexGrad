<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Jenssegers\Agent\Agent;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

class UserApproveController extends Controller
{
    /* ---------------------------------------------------------
     * 🟢 Dashboard صفحة المدير
     * --------------------------------------------------------- */
    public function dashboard()
    {
        $totalUsers   = User::count();
        $pendingUsers = User::where('status', 'pending')->count();
        $activeUsers  = User::where('status', 'active')->count();

        $this->logActivity('View', 'Dashboard', 'Accessed Manager Dashboard');

        return view('manager.dashboard', compact('totalUsers', 'pendingUsers', 'activeUsers'));
    }

    /* ---------------------------------------------------------
     * 🟢 عرض المستخدمين المعلقين
     * --------------------------------------------------------- */
public function pendingUsers()
{
    $allUsers      = User::all(); // ← جميع المستخدمين
    $allCount      = $allUsers->count(); // ← العدد الإجمالي

    $pendingUsers  = User::where('status', 'pending')->get();
    $activeUsers   = User::where('status', 'active')->get();
    $inactiveUsers = User::where('status', 'inactive')->get();
    $disabledUsers = User::where('status', 'disabled')->get();

    // احصائيات الحالات
    $pendingCount  = $pendingUsers->count();
    $activeCount   = $activeUsers->count();
    $inactiveCount = $inactiveUsers->count();
    $disabledCount = $disabledUsers->count();

    $this->logActivity('View', 'PendingUsers', 'Viewed pending users list');

    return view('manager.pending_users', compact(
        'allUsers',      
        'pendingUsers',
        'activeUsers',
        'inactiveUsers',
        'disabledUsers',
         'allCount', 
        'pendingCount',
        'activeCount',
        'inactiveCount',
        'disabledCount'
    ));
}



    /* ---------------------------------------------------------
     * 🟢 تغيير حالة المستخدم (active, inactive, disabled)
     * --------------------------------------------------------- */
    public function approve(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'status' => 'required|in:active,inactive,disabled'
        ]);

        $oldStatus = $user->status;
        $user->status = $request->status;
        $user->save();

        $this->logActivity(
            'Update',
            'User',
            "Changed status of user {$user->username} from {$oldStatus} to {$user->status}"
        );

        return back()->with('status', 'تم تحديث حالة المستخدم.');
    }

    /* ---------------------------------------------------------
     * 🟢 تفعيل مباشر AJAX
     * --------------------------------------------------------- */
    public function approveDirect($id)
    {
        try {
            $user = User::findOrFail($id);
            $oldStatus = $user->status;
            $user->status = 'active';
            $user->save();

            $this->logActivity(
                'Update',
                'User',
                "Activated user {$user->username} (Status: {$oldStatus} → active)"
            );

            return response()->json(['status' => 'success']);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }

    /* ---------------------------------------------------------
     * 🟢 تعطيل المستخدم
     * --------------------------------------------------------- */
    public function reject($id)
    {
        try {
            $user = User::findOrFail($id);
            $oldStatus = $user->status;
            $user->status = 'disabled';
            $user->save();

            $this->logActivity(
                'Update',
                'User',
                "Disabled user {$user->username} (Status: {$oldStatus} → disabled)"
            );

            return response()->json(['status' => 'success']);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }

    /* ---------------------------------------------------------
     * 🔹 تسجيل النشاط
     * --------------------------------------------------------- */
    private function logActivity($action, $model, $description = null)
    {
        if (Auth::check()) {

            $user = Auth::user();
            $agent = new Agent();

            // تحديث آخر نشاط
            $user->update(['last_activity' => now()]);

            // تسجيل النشاط
            ActivityLog::create([
                'user_id' => $user->id,
                'action'  => $action,
                'model'   => $model,
                'description' => $description,
                'ip'      => request()->ip(),
                'device'  => $agent->device(),
                'browser' => $agent->browser(),
                'os'      => $agent->platform(),
            ]);
        }
    }

    /* ---------------------------------------------------------
     * 🟢 عرض فورم إنشاء مستخدم جديد
     * --------------------------------------------------------- */
    public function create()
    {
        return view('manager.create_user');
    }

    /* ---------------------------------------------------------
     * 🟢 حفظ المستخدم الجديد
     * --------------------------------------------------------- */
    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:50|unique:users,username',
            'name'     => 'required|string|max:150',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'role'     => 'required|in:Manager,Supervisor,Student',
        ]);

        $user = User::create([
            'username' => $request->username,
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => bcrypt($request->password),
            'role'     => $request->role,
            'status'   => 'pending',
        ]);

        $this->logActivity(
            'Create',
            'User',
            "Created new user {$user->username} with role {$user->role}"
        );

        return redirect()->route('manager.pending.users')
            ->with('success', 'User created successfully!');
    }
public function index()
{
    // جميع المستخدمين
    $allUsers = User::latest()->get();

    // حسب الحالة
    $pendingUsers  = User::where('status', 'pending')->latest()->get();
    $activeUsers   = User::where('status', 'active')->latest()->get();
    $inactiveUsers = User::where('status', 'inactive')->latest()->get();
    $disabledUsers = User::where('status', 'disabled')->latest()->get();

    // العدّادات
    $allCount      = $allUsers->count();
    $pendingCount  = $pendingUsers->count();
    $activeCount   = $activeUsers->count();
    $inactiveCount = $inactiveUsers->count();
    $disabledCount = $disabledUsers->count();

    return view('manager.pending_users', compact(
        'allUsers',
        'pendingUsers',
        'activeUsers',
        'inactiveUsers',
        'disabledUsers',
        'allCount',
        'pendingCount',
        'activeCount',
        'inactiveCount',
        'disabledCount'
    ));
}

    /* ---------------------------------------------------------
     * 🟢 تحرير مستخدم
     * --------------------------------------------------------- */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('manager.edit_user', compact('user'));
    }

    /* ---------------------------------------------------------
     * 🟢 تحديث بيانات المستخدم
     * --------------------------------------------------------- */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $user->update($request->only([
            'name',
            'email',
            'status'
        ]));

        return redirect()->route('manager.pending.users')
            ->with('success', 'User updated successfully.');
    }
}
