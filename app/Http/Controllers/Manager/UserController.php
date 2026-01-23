<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Exception;

class UserController extends Controller
{
    /** صفحة إنشاء مستخدم جديد */
    public function create()
    {
        return view('manager.create_user');
    }

    /** تخزين مستخدم جديد */
    public function store(Request $request)
{
     $existingUser = User::where('email', $request->email)
                            ->orWhere('username', $request->username)
                            ->first();

        if ($existingUser) {
            // إذا المستخدم موجود، رجع مع رسالة خطأ
            return redirect()->back()->with('error', 'User already exists!');
        }

    $request->validate([
        'username' => 'required|string|max:50',
        'name' => 'required|string|max:150',
        'email' => 'required|email|unique:users',
        'password' => 'required|confirmed|min:6',
        'role' => 'required|string',
        'status' => 'required|string',
    ]);

    try {
        $user = new User();
        $user->username = $request->username;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = $request->role;
        $user->status = $request->status;
        $user->gender = $request->gender ?? null;
        $user->city = $request->city ?? null;
        $user->state = $request->state ?? null;
        $user->password = bcrypt($request->password);

        // رفع الصورة
         if ($request->hasFile('profile_image')) {
            $image = $request->file('profile_image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            if (!is_dir(public_path('uploads/users'))) {
                mkdir(public_path('uploads/users'), 0777, true);
            }
            $image->move(public_path('uploads/users'), $imageName);
            $user->profile_image = 'uploads/users/' . $imageName;
        } else {
            // إذا لم يتم رفع صورة، ضع الصورة الافتراضية
            $user->profile_image = 'src/images/avatar.png';
        }

        $user->save(); // حفظ البيانات

        return redirect()->route('manager.pending.users')
                         ->with('success', '✔ تم إضافة المستخدم بنجاح');

    } catch (\Exception $e) {
        return redirect()->back()
                         ->with('error', '❌ حدث خطأ أثناء الإضافة: ' . $e->getMessage())
                         ->withInput();
    }
}

/** صفحة إدارة المستخدمين */

    // جميع المستخدمين
    
  

    /** تعديل مستخدم */
    public function edit(User $user)
    {
        return view('manager.edit_user', compact('user'));
    }

    /** تحديث بيانات مستخدم */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:150',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'status' => 'required|in:active,inactive,disabled,pending',
            'role' => 'nullable|string|max:50',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'status' => $request->status,
            'role' => $request->role ?? $user->role,
        ]);

        return redirect()->route('manager.pending.users')
            ->with('success', '✔ تم تحديث بيانات المستخدم بنجاح.');
    }

    /** حذف مستخدم */
    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->back()->with('success', '✔ تم حذف المستخدم بنجاح');
    }

    /** إجبار المستخدم على تسجيل الخروج */
    public function forceLogout($userId)
    {
        $user = User::findOrFail($userId);
        return redirect()->back()->with('success', "✔ تم تسجيل خروج {$user->name} بنجاح.");
    }

    /** عرض بيانات المستخدم JSON */
    public function show(User $user)
    {
        return response()->json($user);
    }
}
