<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Rate Limit
    |--------------------------------------------------------------------------
    |
    | Define the default rate limit for endpoints that do not have a specific
    | limit configured. Specify the limit and the duration (in seconds).
    |
    */

    'default_limit' => [
        'limit' => env('LIMITSHIELD_DEFAULT_LIMIT', 60), // Default: 60 requests
        'duration' => env('LIMITSHIELD_DEFAULT_DURATION', 60), // Default: 60 seconds
    ],

    /*
    |--------------------------------------------------------------------------
    | Rate Limits for Endpoints
    |--------------------------------------------------------------------------
    |
    | Define rate limits for specific endpoints. You can set limits based on
    | IP addresses or authenticated users. Use "*" to apply a limit to all
    | endpoints. Specify the limit and the duration (in seconds).
    |
    */

    'endpoints' => [
        // Example:
        // 'api/*' => [
        //     'limit' => 100,
        //     'duration' => 60,
        // ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Redis Configuration
    |--------------------------------------------------------------------------
    |
    | Configure the Redis connection settings for distributed rate limiting.
    |
    */

    'redis' => [
        'host' => env('REDIS_HOST', 'localhost'),
        'port' => env('REDIS_PORT', 6379),
        'password' => env('REDIS_PASSWORD', null),
        'database' => env('REDIS_DB', 0),
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Response Messages
    |--------------------------------------------------------------------------
    |
    | Define custom response messages for different rate limit scenarios.
    |
    */

    'responses' => [
        'too_many_requests' => 'Rate limit exceeded. Please try again later.',
        // Add more custom response messages as needed
    ],

];
