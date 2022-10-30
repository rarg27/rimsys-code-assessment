<?php

namespace App\Providers;

use App\Domain\Documents\Models\Document;
use App\Domain\Users\Models\User;
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
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/home';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     *
     * @return void
     */
    public function boot()
    {
        $this->configureRateLimiting();

        $this->routes(function () {
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));

            Route::middleware('web')
                ->group(base_path('routes/web.php'));
        });

        $this->configureRouteModels();
    }

    /**
     * Configure the rate limiters for the application.
     *
     * @return void
     */
    protected function configureRateLimiting()
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });
    }

    protected function configureRouteModels()
    {
        $this->bindRouteModel('user', User::class);
        $this->bindRouteModel('document', Document::class);
    }

    private function bindRouteModel(string $key, string $class, ?\Closure $callback = null) {
        Route::bind($key, function ($value) use ($class, $callback) {
            $model = $callback ? $callback($value) : call_user_func(array($class, 'findOrFail'), $value);
            app()->bind($class, fn ($app) => $model);
            return $model;
        });
    }
}
