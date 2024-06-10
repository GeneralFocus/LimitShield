<?php

namespace GeneralFocus\LimitShield\Providers;

use Illuminate\Support\ServiceProvider;

class PackageServiceProvider extends ServiceProvider
{
    public function register()
    {
        // Register any package services
    }

    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/limitshield.php' => config_path('limitshield.php'),
        ]);
    }
}
