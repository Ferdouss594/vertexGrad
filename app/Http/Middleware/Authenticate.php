<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Authenticate
{
public function handle(Request $request, Closure $next)
{
    if (!Auth::check()) {
        // If the user is trying to access staff areas
        if ($request->is('manager/*') || $request->is('Supervisior/*') || $request->is('dashboard/*')) {
            return redirect()->route('admin.login.show'); // <--- Matches your web.php name
        }

        return redirect()->route('login.show'); // Goes to frontend login
    }

    return $next($request);
}
}
