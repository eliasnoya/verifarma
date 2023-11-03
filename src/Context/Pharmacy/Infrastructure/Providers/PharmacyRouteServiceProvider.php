<?php

namespace Src\Context\Pharmacy\Infrastructure\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;
use Src\Context\Pharmacy\Infrastructure\Controllers\PharmacyController;

class PharmacyRouteServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

        $this->routes(function () {
            Route::middleware('api')->prefix('farmacia')->group(function () {
                Route::post('/', [PharmacyController::class, 'create']);
                Route::get('/{id}', [PharmacyController::class, 'findId']);
                Route::get('/', [PharmacyController::class, 'searchNearbyOnes']);
            });
        });
    }
}
