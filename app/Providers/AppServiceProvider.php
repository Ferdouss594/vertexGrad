<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Blade; // 👈 الجديد
use App\Http\Middleware\RoleMiddleware;
use App\Models\Investor;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // 🔹 Route model binding
        Route::bind('investor', function ($value) {
            return Investor::where('user_id', $value)->firstOrFail();
        });

        // 🔹 Middleware alias
        Route::aliasMiddleware('role', RoleMiddleware::class);

        // 🔹 Load admin routes
        Route::middleware('web')
            ->group(base_path('routes/admin.php'));

        // 🔥 Permission Blade Directive (الأهم)
        Blade::if('permission', function ($permission) {
            $user = auth('admin')->user() ?? auth('web')->user();

            return $user && $user->hasPermission($permission);
        });
    }
}