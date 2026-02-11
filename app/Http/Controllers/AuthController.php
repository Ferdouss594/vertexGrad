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
    // If the user is already logged in, don't show the login page
    if (Auth::check()) {
        $user = Auth::user();
        
        // Redirect them to their proper home based on role
        return redirect()->intended(match($user->role) {
            'Manager', 'Admin' => route('manager.dashboard'),
            'Supervisor'       => '/Supervisior/supervisior_page',
            default            => route('home'),
        });
    }

    return view('auth.login'); // Show the admin login form
}

    // 🟢 تنفيذ تسجيل الدخول مع تتبع الجهاز والمتصفح والجلسة
 public function login(Request $request)
{
    $fieldType = filter_var($request->login_id, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

    // 1. Validation Rules
    $rules = [
        'login_id' => 'required',
        'password' => 'required|min:6',
        'role'     => 'required|in:Manager,Supervisor',
    ];

    $messages = [
        'login_id.required' => $fieldType === 'email' ? 'Email is required.' : 'Username is required.',
        'role.required'     => 'Please select your role.',
    ];

    if ($fieldType === 'email') {
        $rules['login_id'] .= '|email|exists:users,email';
    } else {
        $rules['login_id'] .= '|exists:users,username';
    }

    $request->validate($rules, $messages);

    // 2. Fetch User (Already in your code)
    $user = User::where($fieldType, $request->login_id)->first();

    // 3. Check Role FIRST (Easier for you to see if the button selection is the problem)
    if ($user && trim(strtolower($user->role)) !== trim(strtolower($request->role))) {
        return back()->withErrors(['role' => 'This account is not registered as a ' . $request->role])->withInput();
    }

    // 4. Check Password & Status
    if (!$user || !Hash::check($request->password, $user->password)) {
        return back()->withErrors(['login_id' => 'Incorrect credentials. Please check your email/username and password.'])->withInput();
    }

    if ($user->status !== 'active') {
        return back()->withErrors(['login_id' => 'Your account is ' . $user->status . '.'])->withInput();
    }
    // 5. Track Login Data (Agent info)
    $agent = new Agent();
    $user->update([
        'last_login'    => now(),
        'last_activity' => now(),
        'login_ip'      => $request->ip(),
        'device'        => $agent->device(),
        'browser'       => $agent->browser(),
        'os'            => $agent->platform(),
    ]);

    LoginLog::create([
        'user_id'    => $user->id,
        'ip'         => $request->ip(),
        'device'     => $agent->device(),
        'browser'    => $agent->browser(),
        'os'         => $agent->platform(),
        'login_at'   => now(),
        'session_id' => session()->getId(),
    ]);

    // 6. Perform Login using the 'admin' guard
    Auth::guard('admin')->login($user, $request->has('remember'));
    $request->session()->regenerate();

    // 7. Professional Redirect based on Role
    return redirect()->intended(match($user->role) {
        'Manager'    => route('manager.dashboard'),
        'Supervisor' => '/Supervisior/supervisior_page', // Double check this URL spelling
        default      => route('home'),
    });
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
            'password' => $request->password, // Model handles hashing, so this is fine
            'role'     => 'Supervisor',
            'status'   => 'pending',
            'gender'   => $request->gender,
            'city'     => $request->city,
            'state'    => $request->state,
        ]);

        // FIX: Move the success response with redirect_url HERE
        return response()->json([
            'status'  => 'success',
            'message' => 'تم تسجيل حسابك بنجاح.',
            'redirect_url' => route('manager.dashboard') // This tells JS where to go
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
    Auth::guard('admin')->logout(); // Kill only the admin session

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
