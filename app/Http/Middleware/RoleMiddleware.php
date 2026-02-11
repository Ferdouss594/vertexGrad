<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
public function handle(Request $request, Closure $next, $role)
{
    // Check if the user is logged in via the 'admin' guard
    if (!Auth::guard('admin')->check()) {
        return redirect()->route('admin.login.show');
    }

    $user = Auth::guard('admin')->user();

    // Check the role (Case Sensitive match with your Seeder)
    if ($user->role !== $role) {
        abort(403, 'Unauthorized access.');
    }

    return $next($request);
}
}
