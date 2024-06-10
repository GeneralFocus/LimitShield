<?php

namespace App\RateLimiter;

use App\Contracts\RateLimiter;

class RateLimiterFactory
{
    /**
     * Make a rate limiter instance based on the configuration settings.
     *
     * @param  array  $config
     * @return RateLimiter
     */
    public static function make(array $config)
    {
        $driver = $config['driver'] ?? 'redis';

        switch ($driver) {
            case 'redis':
                return new RedisRateLimiter();
            // Add more cases for other rate limiter implementations if needed
            default:
                throw new \InvalidArgumentException("Invalid rate limiter driver: {$driver}");
        }
    }
}
