<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * This is used by Laravel authentication to redirect users after login.
     *
     * @var string
     */
    public const HOME = '/home';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        $this->configureRateLimiting();

        $this->routes(function () {
            Route::middleware('web')
                ->group(base_path('routes/web.php'));

            Route::prefix('api')
                ->middleware('api')
                ->group(base_path('routes/api.php'));

            Route::prefix('admin')
                ->middleware(['auth:sanctum', 'role:admin'])
                ->namespace($this->namespace)
                ->name('admin.')
                ->group(base_path('routes/api/v1/admin/users.php'));

            Route::prefix('admin')
                ->middleware(['auth:sanctum', 'role:admin|chef'])
                ->namespace($this->namespace)
                ->name('admin.')
                ->group(base_path('routes/api/v1/admin/food.php'));

            Route::prefix('admin')
                ->middleware(['auth:sanctum', 'role:admin|chef'])
                ->namespace($this->namespace)
                ->name('admin.')
                ->group(base_path('routes/api/v1/admin/chef.php'));

            Route::prefix('admin')
                ->middleware(['auth:sanctum', 'role:admin'])
                ->namespace($this->namespace)
                ->name('admin.')
                ->group(base_path('routes/api/v1/admin/reservation.php'));

             Route::prefix('customer')
                ->middleware(['auth:sanctum', 'role:admin|customer'])
                ->namespace($this->namespace)
                ->name('customer.')
                ->group(base_path('routes/api/v1/customer/cart.php'));

             Route::prefix('customer')
                ->middleware(['auth:sanctum', 'role:admin|customer'])
                ->namespace($this->namespace)
                ->name('customer.')
                ->group(base_path('routes/api/v1/customer/cartitem.php'));

             Route::prefix('customer')
                ->middleware(['auth:sanctum', 'role:admin|customer'])
                ->namespace($this->namespace)
                ->name('customer.')
                ->group(base_path('routes/api/v1/customer/order.php'));

            Route::prefix('customer')
                ->middleware(['auth:sanctum', 'role:admin|customer'])
                ->namespace($this->namespace)
                ->name('customer.')
                ->group(base_path('routes/api/v1/customer/profile.php'));
        });
    }

    /**
     * Configure the rate limiters for the application.
     *
     * @return void
     */
    protected function configureRateLimiting()
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60);
        });
    }
}
