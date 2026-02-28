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
            'login_id' => 'required',
            'password' => 'required',
            // ✅ Frontend must only allow Investor/Student (NOT Manager/Supervisor)
            'role'     => 'required|in:Investor,Student',
        ]);

        $fieldType = filter_var($request->login_id, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        $credentials = [
            $fieldType => $request->login_id,
            'password' => $request->password,
            'role'     => $request->role,
        ];

        if (Auth::guard('web')->attempt($credentials, $request->has('remember'))) {
            $request->session()->regenerate();

            return redirect()->intended(match(Auth::guard('web')->user()->role) {
                'Investor' => route('dashboard.investor'),
                'Student'  => route('dashboard.academic'),
                default    => route('home'),
            });
        }

        return back()
            ->withErrors(['login_id' => 'Invalid credentials. Please check your email/username and password.'])
            ->withInput();
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
                // ✅ FIX: MUST set role
                'role'     => 'Investor',
                'status'   => 'active',
            ]);

            Investor::create([
                'user_id' => $user->id,
                'status'  => 'active',
            ]);

            DB::commit();
            return redirect()->route('login.show')->with('success', 'Investor account created successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Registration failed: ' . $e->getMessage()]);
        }
    }

    public function registerStudent(Request $request)
    {
        $request->validate([
            'username' => 'required|unique:users',
            'name'     => 'required',
            'email'    => 'required|email|unique:users',
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

            DB::commit();
            return redirect()->route('login.show')->with('success', 'Student account created!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Registration failed: ' . $e->getMessage()]);
        }
    }


}