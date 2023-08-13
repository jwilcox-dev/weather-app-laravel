<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;
use Laravel\Sanctum\PersonalAccessToken;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to your application's "home" route.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/home';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

        RateLimiter::for('authenticate-user', function (Request $request) {
            return Limit::perMinute(5)->by($request->ip());
        });

        RateLimiter::for('get-weather', function (Request $request) {

            if (!$request->bearerToken()) {
                return Limit::perMinute(5)->by($request->ip());
            }
            
            if ($request->bearerToken()) {

                $token = PersonalAccessToken::findToken($request->bearerToken());
                
                if (is_null($token)) {
                    return Limit::perMinute(5)->by($request->ip());
                }

                return Limit::perMinute(25)->by($request->bearerToken());

            }

        });

        RateLimiter::for('store-user', function (Request $request) {
            return Limit::perMinute(5)->by($request->ip());
        });

        $this->routes(function () {
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));

            Route::middleware('web')
                ->group(base_path('routes/web.php'));
        });
    }
}
