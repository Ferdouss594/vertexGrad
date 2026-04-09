<?php

namespace App\Http\Controllers\Frontend\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Investor;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('frontend.auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'login_id' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        $fieldType = filter_var($request->login_id, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        $user = User::query()
            ->where($fieldType, $request->login_id)
            ->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            return back()
                ->withErrors([
                    'login_id' => 'Invalid credentials. Please check your email/username and password.',
                ])
                ->withInput($request->only('login_id'));
        }

        // Frontend login must only allow Student / Investor
        if (! in_array($user->role, ['Student', 'Investor'], true)) {
            return back()
                ->withErrors([
                    'login_id' => 'This account is not allowed to sign in from the frontend portal.',
                ])
                ->withInput($request->only('login_id'));
        }

        // Optional but professional: prevent inactive frontend accounts
        if (($user->status ?? null) !== 'active') {
            return back()
                ->withErrors([
                    'login_id' => 'Your account is currently inactive. Please contact support.',
                ])
                ->withInput($request->only('login_id'));
        }

        Auth::guard('web')->login($user, $request->boolean('remember'));
        $request->session()->regenerate();

        return redirect()->to($this->redirectPathByRole($user->role));
    }

    protected function redirectPathByRole(string $role): string
    {
        return match ($role) {
            'Investor' => route('dashboard.investor'),
            'Student'  => route('dashboard.academic'),
            default    => route('home'),
        };
    }

    public function registerInvestor(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:50|unique:users,username',
            'name'     => 'required|string|max:150',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
        ]);

        try {
            DB::beginTransaction();

            $user = User::create([
                'username' => $request->username,
                'name'     => $request->name,
                'email'    => $request->email,
                'password' => Hash::make($request->password),
                'role'     => 'Investor',
                'status'   => 'active',
            ]);

            Investor::create([
                'user_id' => $user->id,
                'status'  => 'active',
            ]);

            DB::commit();

            return redirect()
                ->route('login.show')
                ->with('success', 'Investor account created successfully!');
        } catch (\Throwable $e) {
            DB::rollBack();

            \Log::error('Investor registration failed', [
                'message' => $e->getMessage(),
                'file'    => $e->getFile(),
                'line'    => $e->getLine(),
            ]);

            return back()->withInput()->withErrors([
                'error' => 'Registration failed. Please try again.',
            ]);
        }
    }

    public function registerStudent(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:50|unique:users,username',
            'name'     => 'required|string|max:150',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:6',
        ]);

        try {
            DB::beginTransaction();

            $user = User::create([
                'username' => $request->username,
                'name'     => $request->name,
                'email'    => $request->email,
                'password' => Hash::make($request->password),
                'role'     => 'Student',
                'status'   => 'active',
            ]);

            Student::create([
                'user_id' => $user->id,
            ]);

            $managers = User::where('role', 'Manager')
                ->where('status', 'active')
                ->get();

            \Notification::send(
                $managers,
                new \App\Notifications\NewStudentRegisteredNotification($user)
            );

            DB::commit();

            return redirect()
                ->route('login.show')
                ->with('success', 'Student account created!');
        } catch (\Throwable $e) {
            DB::rollBack();

            \Log::error('Student registration failed', [
                'message' => $e->getMessage(),
                'file'    => $e->getFile(),
                'line'    => $e->getLine(),
            ]);

            return back()->withInput()->withErrors([
                'error' => 'Registration failed. Please try again.',
            ]);
        }
    }

    public function logout(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}