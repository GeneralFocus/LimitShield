<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Http\Middleware\LimitShieldMiddleware;
use App\Contracts\RateLimiter;
use App\RateLimiter\RateLimiterFactory;
use Illuminate\Contracts\Container\Container;

class LimitShieldServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(RateLimiter::class, function (Container $app) {
            return RateLimiterFactory::make($app['config']->get('limitshield'));
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // Register the middleware
        $this->app['router']->aliasMiddleware('limitshield', LimitShieldMiddleware::class);
        
        // Publish configuration file
        $this->publishes([
            __DIR__.'/../config/limitshield.php' => config_path('limitshield.php'),
        ], 'config');
    }
}
