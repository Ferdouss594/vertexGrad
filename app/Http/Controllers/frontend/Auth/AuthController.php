<?php

namespace App\Http\Controllers\Frontend\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Investor;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    // 1. Show Home (fallback)
    public function showLogin() {
        return view('frontend.auth.login');
    }

    // 2. Login Logic
public function login(Request $request) {
    // 1. Validate based on your form input 'login_id'
    $request->validate([
        'login_id' => 'required',
        'password' => 'required',
    ]);

    // 2. Check if the input is an email or a username
    $fieldType = filter_var($request->login_id, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

    $credentials = [
        $fieldType => $request->login_id,
        'password' => $request->password,
    ];

    // 3. Attempt Login
    if (Auth::attempt($credentials, $request->has('remember'))) {
        $request->session()->regenerate();
        
      // After $request->session()->regenerate();
        return redirect()->intended(match(auth()->user()->role) {
            'Manager', 'Admin' => route('manager.dashboard'),
            'Investor'         => route('dashboard.investor'),
            'Student'          => route('dashboard.academic'),
            'Supervisor'       => '/Supervisior/supervisior_page',
            default            => route('home'),
        });
    }

    return back()->withErrors(['login_id' => 'Invalid credentials. Please check your email/username and password.'])->withInput();
}

    // 3. Register Investor (Dual Table)
public function registerInvestor(Request $request) {
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
            'password' => $request->password, // Correct: Model handles hashing
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

public function registerStudent(Request $request) {
    $request->validate([
        'username' => 'required|unique:users',
        'name'     => 'required',
        'email'    => 'required|email|unique:users',
        'password' => 'required|confirmed|min:6',
    ]);

    try {
        DB::beginTransaction();

        // 1. User gets the 'active' status
        $user = User::create([
            'username' => $request->username,
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => $request->password, 
            'role'     => 'Student',
            'status'   => 'active', 
        ]);

        // 2. Student record only takes what's in your $fillable: user_id
        \App\Models\Student::create([
            'user_id' => $user->id,
            // 'major', 'phone', 'address' are currently null/optional
        ]);

        DB::commit();
        return redirect()->route('login.show')->with('success', 'Student account created!');
    } catch (\Exception $e) {
        DB::rollBack();
        return back()->withErrors(['error' => 'Registration failed: ' . $e->getMessage()]);
    }
}
    
}