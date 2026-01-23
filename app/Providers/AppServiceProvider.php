<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
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

    // الآن الـ route model binding يبحث عن investor بناءً على user_id
    Route::bind('investor', function ($value) {
        return Investor::where('user_id', $value)->firstOrFail();
    });
        // تسجيل Middleware باسم alias
        Route::aliasMiddleware('role', RoleMiddleware::class);
    }




}
