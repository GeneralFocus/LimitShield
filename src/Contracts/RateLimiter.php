<?php

namespace App\Contracts;

use Illuminate\Http\Request;

interface RateLimiter
{
    /**
     * Determine if the given request has exceeded the rate limit.
     *
     * @param  Request  $request
     * @param  int  $limit
     * @param  int  $decaySeconds
     * @return bool
     */
    public function tooManyAttempts(Request $request, $limit, $decaySeconds);

    /**
     * Increment the counter for the given request.
     *
     * @param  Request  $request
     * @param  int  $decaySeconds
     * @return void
     */
    public function hit(Request $request, $decaySeconds);
}
