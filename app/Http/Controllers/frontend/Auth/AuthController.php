<?php

namespace App\Http\Controllers\Frontend\Auth;

use App\Http\Controllers\Controller;
use App\Models\Investor;
use App\Models\LoginOtp;
use App\Models\Student;
use App\Models\TrustedDevice;
use App\Models\User;
use App\Notifications\LoginOtpNotification;
use App\Services\SecurityActivityLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password as PasswordRule;

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
            SecurityActivityLogger::log(
                $user?->id,
                'password_login_failed',
                $request,
                false
            );

            return back()
                ->withErrors([
                    'login_id' => 'Invalid credentials. Please check your email/username and password.',
                ])
                ->withInput($request->only('login_id'));
        }

        if (! in_array($user->role, ['Student', 'Investor'], true)) {
            SecurityActivityLogger::log(
                $user->id,
                'password_login_blocked_role',
                $request,
                false
            );

            return back()
                ->withErrors([
                    'login_id' => 'This account is not allowed to sign in from the frontend portal.',
                ])
                ->withInput($request->only('login_id'));
        }

        if (($user->status ?? null) !== 'active') {
            SecurityActivityLogger::log(
                $user->id,
                'password_login_blocked_inactive',
                $request,
                false
            );

            return back()
                ->withErrors([
                    'login_id' => 'Your account is currently inactive. Please contact support.',
                ])
                ->withInput($request->only('login_id'));
        }

        $trustedToken = $request->cookie('trusted_device_token');

        if ($trustedToken) {
            $trustedDevice = TrustedDevice::where('user_id', $user->id)
                ->where('token_hash', hash('sha256', $trustedToken))
                ->where('expires_at', '>', now())
                ->first();

            if ($trustedDevice) {
                $trustedDevice->update([
                    'last_used_at' => now(),
                    'ip_address'   => $request->ip(),
                ]);

                Auth::guard('web')->login($user, $request->boolean('remember'));
                $request->session()->regenerate();

                SecurityActivityLogger::log(
                    $user->id,
                    'login_completed_trusted_device',
                    $request,
                    true,
                    ['trusted_device_id' => $trustedDevice->id]
                );

                if (! $user->hasVerifiedEmail()) {
                    return redirect()
                        ->route('verification.notice')
                        ->with('success', 'Login completed. Please verify your email to continue.');
                }

                return redirect()->to($this->redirectPathByRole($user->role));
            }
        }

        LoginOtp::where('user_id', $user->id)
            ->whereNull('verified_at')
            ->delete();

        $plainCode = str_pad((string) random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        LoginOtp::create([
            'user_id'    => $user->id,
            'code'       => Hash::make($plainCode),
            'expires_at' => now()->addMinutes(10),
            'attempts'   => 0,
            'ip_address' => $request->ip(),
            'user_agent' => Str::limit((string) $request->userAgent(), 1000),
        ]);

        $user->notify(new LoginOtpNotification($plainCode));

        SecurityActivityLogger::log(
            $user->id,
            'otp_sent',
            $request,
            true
        );

        $request->session()->put('otp_user_id', $user->id);
        $request->session()->put('otp_remember', $request->boolean('remember'));

        return redirect()
            ->route('login.otp.show')
            ->with('status', 'We sent a verification code to your email.');
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
            'username' => ['required', 'string', 'max:50', 'unique:users,username'],
            'name'     => ['required', 'string', 'max:150'],
            'email'    => ['required', 'email', 'max:150', 'unique:users,email'],
            'password' => ['required', 'confirmed', PasswordRule::min(8)->letters()->mixedCase()->numbers()],
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

            Auth::guard('web')->login($user);
            $request->session()->regenerate();

            $user->sendEmailVerificationNotification();

            return redirect()
                ->route('verification.notice')
                ->with('success', 'Investor account created successfully. We sent a verification link to your email.');
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
            'username' => ['required', 'string', 'max:50', 'unique:users,username'],
            'name'     => ['required', 'string', 'max:150'],
            'email'    => ['required', 'email', 'max:150', 'unique:users,email'],
            'password' => ['required', 'confirmed', PasswordRule::min(8)->letters()->mixedCase()->numbers()],
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

            \Notification::send($managers, new \App\Notifications\NewStudentRegisteredNotification($user));

            DB::commit();

            Auth::guard('web')->login($user);
            $request->session()->regenerate();

            $user->sendEmailVerificationNotification();

            return redirect()
                ->route('verification.notice')
                ->with('success', 'Student account created successfully. We sent a verification link to your email.');
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
        SecurityActivityLogger::log(
            auth('web')->id(),
            'logout',
            $request,
            true
        );

        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}