<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Jenssegers\Agent\Agent;
use App\Models\LoginLog;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // 🟢 عرض صفحة تسجيل الدخول
    public function showLogin()
    {
        return view('auth.login');
    }

    // 🟢 تنفيذ تسجيل الدخول مع تتبع الجهاز والمتصفح والجلسة
    public function login(Request $request)
    {
        $fieldType = filter_var($request->login_id, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        // قواعد التحقق
        $rules = [
            'login_id' => 'required',
            'password' => 'required|min:6',
            'role'     => 'required|in:Manager,Supervisor',
        ];

        $messages = [
            'login_id.required' => $fieldType === 'email' ? 'Email is required.' : 'Username is required.',
            'password.required' => 'Password is required.',
            'password.min'      => 'Password must be at least 6 characters.',
            'role.required'     => 'Please select your role.',
            'role.in'           => 'Invalid role selected.',
        ];

        if ($fieldType === 'email') {
            $rules['login_id'] .= '|email|exists:users,email';
            $messages['login_id.email']  = 'Please enter a valid email address.';
            $messages['login_id.exists'] = 'No account found with this email.';
        } else {
            $rules['login_id'] .= '|exists:users,username';
            $messages['login_id.exists'] = 'No account found with this username.';
        }

        $request->validate($rules, $messages);

        // تحديد هل نبحث بالبريد او اليوزر
        $user = User::where($fieldType, $request->login_id)->first();

        // Debug temporary: تحقق من كلمة المرور المشفرة
        if ($user) {
             
        }

        // فحص وجود المستخدم + التحقق من كلمة المرور المشفرة
        if (!$user || $request->password !== $user->password) {
    return back()->withErrors([
        'login_id' => 'Email/Username or password is incorrect.'
    ]);
}

        // تسجيل الدخول
        Auth::login($user);

        $user = Auth::user();

        // مطابقة الدور
        if (strtolower($user->role) !== strtolower($request->role)) {
            Auth::logout();
            return back()->withErrors([
                'role' => 'The selected role does not match your account role.'
            ])->withInput();
        }

        // 🔥 تتبع معلومات الجهاز والمتصفح
        $agent = new Agent();

        $user->update([
            'last_login'    => now(),
            'last_activity' => now(),
            'login_ip'      => $request->ip(),
            'device'        => $agent->device(),
            'browser'       => $agent->browser(),
            'os'            => $agent->platform(),
        ]);

        // تسجيل الدخول في جدول login_logs
        LoginLog::create([
            'user_id'    => $user->id,
            'ip'         => $request->ip(),
            'device'     => $agent->device(),
            'browser'    => $agent->browser(),
            'os'         => $agent->platform(),
            'login_at'   => now(),
            'session_id' => session()->getId(),
        ]);

        // تجديد الجلسة
        $request->session()->regenerate();

        // توجيه حسب الدور والحالة
        switch (strtolower($user->status)) {
            case 'active':
                if ($user->role === 'Manager') {
                    return redirect()->intended('/manager/dashboard');
                }

                if ($user->role === 'Supervisor') {
                    return redirect()->intended('/Supervisior/supervisior_page');
                }

                Auth::logout();
                return back()->withErrors(['login_id' => 'Unknown role assigned.'])->withInput();

            case 'pending':
                Auth::logout();
                return back()->withErrors(['login_id' => 'Your account is pending approval.'])->withInput();

            case 'inactive':
                Auth::logout();
                return back()->withErrors(['login_id' => 'Your account is temporarily inactive.'])->withInput();

            case 'disabled':
                Auth::logout();
                return back()->withErrors(['login_id' => 'Your account has been disabled.'])->withInput();

            default:
                Auth::logout();
                return back()->withErrors(['login_id' => 'Your account status does not allow login.'])->withInput();
        }
    }


    public function showRegister()
    {
        return view('auth.register');
    }

    // 🟢 تنفيذ التسجيل
    public function register(Request $request)
    {
        $request->validate([
            'username'  => 'required|string|max:50|unique:users,username',
            'full_name' => 'nullable|string|max:150',
            'email'     => 'required|email|unique:users,email',
            'password'  => 'required|min:6|confirmed',
            'gender'    => 'nullable|in:male,female',
            'city'      => 'nullable|string|max:100',
            'state'     => 'nullable|string|max:100',
        ]);

        try {
            User::create([
                'username' => $request->username,
                'name'     => $request->full_name,
                'email'    => $request->email,
                'password' => Hash::make($request->password), // ✅ كلمة المرور مشفرة
                'role'     => 'Supervisor',
                'status'   => 'pending',
                'gender'   => $request->gender,
                'city'     => $request->city,
                'state'    => $request->state,
            ]);

            return response()->json([
                'status'  => 'success',
                'message' => 'تم تسجيل حسابك بنجاح.'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status'  => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }


    public function logout(Request $request)
    {
        $user = Auth::user();

        LoginLog::where('session_id', session()->getId())
            ->update(['logout_at' => now()]);

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login.show');
    }

    public function profile()
    {
        $user = auth()->user();
        return view('auth.profile', compact('user'));
    }
}
