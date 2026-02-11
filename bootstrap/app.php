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
        $middleware->alias([
            'role' => \App\Http\Middleware\RoleMiddleware::class,
        ]);

        // This ensures that 'auth' sends people to frontend login 
        // and 'auth:admin' sends people to backend login
        $middleware->authenticateSessions(); 
        
        $middleware->redirectTo(
            guests: '/auth/login', // Change this to your actual frontend login URL
            users: '/'
        );
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();