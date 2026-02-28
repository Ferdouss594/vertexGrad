<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Foundation\Configuration\Exceptions;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {

        // ✅ Alias Middleware
        $middleware->alias([
            'role' => \App\Http\Middleware\RoleMiddleware::class,
        ]);

        // ✅ FIX: Redirect guests correctly based on URL area
        $middleware->redirectGuestsTo(function ($request) {

            // Treat ALL of these as dashboard/admin area
            if (
                $request->is('admin*') ||
                $request->is('manager*') ||
                $request->is('Supervisior*') ||
                $request->is('supervisior*') ||
                $request->is('supervisor*')
            ) {
                return route('admin.login.show');
            }

            return route('login.show');
        });

        $middleware->statefulApi();
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })
    ->create();