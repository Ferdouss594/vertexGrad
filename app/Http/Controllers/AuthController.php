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
  public function showLogin(Request $request)
{

    return view('auth.login');
}

    // 🟢 تنفيذ تسجيل الدخول مع تتبع الجهاز والمتصفح والجلسة
    public function login(Request $request)
    {
        $fieldType = filter_var($request->login_id, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        $request->validate([
            'login_id' => 'required|' . ($fieldType === 'email' ? 'email' : 'string'),
            'password' => 'required|min:6',
            'role'     => 'required|in:Manager,Supervisor',
        ]);

        $credentials = [
            $fieldType => $request->login_id,
            'password' => $request->password,
        ];

        $user = User::where($fieldType, $request->login_id)->first();

        if (!$user) {
            return back()->withErrors(['login_id' => 'User not found.'])->withInput();
        }

        if (trim(strtolower($user->role)) !== trim(strtolower($request->role))) {
            return back()->withErrors([
                'role' => 'This account is not registered as a ' . $request->role
            ])->withInput();
        }

        if (Auth::guard('admin')->attempt($credentials, $request->has('remember'))) {
            $request->session()->regenerate();

            session(['active_guard' => 'admin']);
            $request->session()->forget('url.intended');

            return redirect()->to(
                match ($user->role) {
                    'Manager', 'Admin' => route('manager.dashboard'),
                    'Supervisor' => route('supervisor.dashboard'),
                    default => route('home'),
                }
            );
        }

        return back()->withErrors(['login_id' => 'Incorrect credentials.'])->withInput();
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
                'password' => Hash::make($request->password),
                'role'     => 'Supervisor',
                'status'   => 'pending',
                'gender'   => $request->gender,
                'city'     => $request->city,
                'state'    => $request->state,
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'تم تسجيل حسابك بنجاح.',
                'redirect_url' => route('manager.dashboard'),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'حدث خطأ: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login.show');
    }

    public function profile()
    {
        $user = auth()->user();
        return view('auth.profile', compact('user'));
    }
}