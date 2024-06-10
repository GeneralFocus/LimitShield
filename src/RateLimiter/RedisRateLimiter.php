<?php

namespace App\RateLimiter;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use App\Contracts\RateLimiter;

class RedisRateLimiter implements RateLimiter
{
    /**
     * Determine if the given request has exceeded the rate limit.
     *
     * @param  Request  $request
     * @param  int  $limit
     * @param  int  $decaySeconds
     * @return bool
     */
    public function tooManyAttempts(Request $request, $limit, $decaySeconds)
    {
        $key = $this->resolveRequestKey($request);

        return Redis::throttle($key)->allow($limit)->every($decaySeconds)->then(function () {
            return false;
        }, function () {
            return true;
        });
    }

    /**
     * Increment the counter for the given request.
     *
     * @param  Request  $request
     * @param  int  $decaySeconds
     * @return void
     */
    public function hit(Request $request, $decaySeconds)
    {
        $key = $this->resolveRequestKey($request);

        Redis::throttle($key)->hit($decaySeconds);
    }

    /**
     * Resolve the unique key for the given request.
     *
     * @param  Request  $request
     * @return string
     */
    protected function resolveRequestKey(Request $request)
    {
        // You can define the logic to generate a unique key for the request based on the endpoint, IP address, user, etc.
        // For example, you can use the request's IP address as the key along side few random numbers
        return 'rate_limit:' . $request->ip();
    }
}
