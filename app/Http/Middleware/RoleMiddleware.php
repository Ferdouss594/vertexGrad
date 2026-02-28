<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, $role)
    {
        // Use 'admin' guard for Manager/Supervisor, 'web' for others
        $guard = ($request->is('admin*') || $request->is('manager*') || $request->is('Supervisior*')) ? 'admin' : 'web';
        
        $user = Auth::guard($guard)->user();

        // Use strtolower to prevent "Manager" vs "manager" mistakes
        if (!$user || strtolower(trim($user->role)) !== strtolower(trim($role))) {
            abort(403, 'Unauthorized. This area is reserved for ' . $role);
        }

        return $next($request);
    }
}