<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Contracts\RateLimiter;
use Illuminate\Http\Response;

class LimitShieldMiddleware
{
    /**
     * The rate limiter implementation.
     *
     * @var RateLimiter
     */
    protected $limiter;

    /**
     * Create a new middleware instance.
     *
     * @param  RateLimiter  $limiter
     * @return void
     */
    public function __construct(RateLimiter $limiter)
    {
        $this->limiter = $limiter;
    }

    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @param  Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // Determine the rate limit based on the request
        $limit = $this->getRateLimit($request);

        // Check if the request exceeds the rate limit
        if ($this->limiter->tooManyAttempts($request, $limit['limit'], $limit['duration'])) {
            return $this->handleRateLimitExceeded();
        }

        // Increment the request counter
        $this->limiter->hit($request, $limit['duration']);

        return $next($request);
    }

    /**
     * Get the rate limit for the request.
     *
     * @param  Request  $request
     * @return array
     */
    protected function getRateLimit(Request $request)
    {
        // Logic to determine the rate limit based on the request (e.g., endpoint, IP address, user)
        // You can use the configuration settings to define rate limits for different scenarios
        // Default to the default rate limit if no specific limit is configured for the request which is 60
        
        return [
            'limit' => $request->route()->getAction('limit') ?? config('limitshield.default_limit.limit'),
            'duration' => $request->route()->getAction('duration') ?? config('limitshield.default_limit.duration'),
        ];
    }

    /**
     * Handle the case where the rate limit is exceeded.
     *
     * @return Response
     */
    protected function handleRateLimitExceeded()
    {
        // Get custom response message from configuration
        $message = config('limitshield.responses.too_many_requests');

        return response()->json(['error' => $message], 429); // 429 Too Many Requests status code
    }
}
