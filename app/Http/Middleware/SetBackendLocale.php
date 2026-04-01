<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class SetBackendLocale
{
    public function handle(Request $request, Closure $next)
    {
        $supportedLocales = ['en', 'ar'];

        $locale = session('backend_locale', config('app.locale'));

        if (! in_array($locale, $supportedLocales)) {
            $locale = config('app.locale');
        }

        App::setLocale($locale);

        return $next($request);
    }
}