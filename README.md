## LimitShield

**LimitShield** is a Laravel middleware package designed to efficiently manage and enforce API rate limiting. It offers customizable rate limits, supports IP-based and user-based limiting, integrates seamlessly with Redis for distributed rate limiting, and provides flexibility in crafting responses for rate limit breaches.

### Features

- Configurable rate limits
- IP-based and user-based limiting
- Redis integration for distributed rate limiting
- Customizable responses for rate limit breaches

### Installation

#### Requirements

- PHP ^7.4|^8.0
- Laravel ^8.0|^9.0|^10.0|^11.0
- Redis (for distributed rate limiting)

#### Step-by-Step Installation

1. **Require the Package**

   Add `LimitShield` to your Laravel project using Composer:

   ```bash
   composer require generalfocus/limitshield:*
   ```

2. **Publish Configuration**

   Publish the configuration file to customize the settings:

   ```bash
   php artisan vendor:publish --provider="GeneralFocus\LimitShield\Providers\PackageServiceProvider" --tag="config"
   ```

3. **Configure Middleware**

   Add the `RateLimitMiddleware` to your HTTP kernel. Edit `app/Http/Kernel.php`:

   ```php
   protected $routeMiddleware = [
       // Other middleware
       'rate.limit' => \GeneralFocus\LimitShield\Http\Middleware\RateLimitMiddleware::class,
   ];
   ```

### Usage

#### Applying Middleware to Routes

You can apply the rate limit middleware to specific routes or route groups:

```php
use Illuminate\Support\Facades\Route;

Route::middleware('rate.limit')->group(function () {
    Route::get('/api/resource', 'ApiResourceController@index');
});
```

Alternatively, you can apply the middleware directly in route definitions:

```php
use Illuminate\Support\Facades\Route;

Route::get('/api/resource', 'ApiResourceController@index')->middleware('rate.limit:limit=100,duration=60');
```

#### Configuring Limits

Edit the `config/limitshield.php` file to set your desired rate limits and other configurations:

```php
return [
    'limits' => [
        'global' => [
            'enabled' => true,
            'max_requests' => 100,
            'decay_minutes' => 1,
        ],
        'ip' => [
            'enabled' => true,
            'max_requests' => 50,
            'decay_minutes' => 1,
        ],
        'user' => [
            'enabled' => true,
            'max_requests' => 200,
            'decay_minutes' => 1,
        ],
    ],
    'redis' => [
        'connection' => 'default',
    ],
    'response' => [
        'message' => 'Too many requests, please try again later.',
        'retry_after' => 'Retry-After',
    ],
];
```

### Contributing

#### Guidelines

1. Fork the repository.
2. Create a new branch (`git checkout -b feature/YourFeature`).
3. Commit your changes (`git commit -am 'Add some feature'`).
4. Push to the branch (`git push origin feature/YourFeature`).
5. Create a new Pull Request.

This README provides comprehensive instructions on installing, configuring, and using LimitShield in your Laravel applications. Feel free to contribute to its development and improve its functionality!
```
