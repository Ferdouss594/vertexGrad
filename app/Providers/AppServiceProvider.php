<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\RoleMiddleware;
use App\Models\Investor;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Route::bind('investor', function ($value) {
            return Investor::withTrashed()
                ->where('user_id', $value)
                ->firstOrFail();
        });

        Route::aliasMiddleware('role', RoleMiddleware::class);

        Route::middleware('web')
            ->group(base_path('routes/admin.php'));
    }
}