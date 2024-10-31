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
    public function handle(Request $request, Closure $next)
    {
        // Get rate limit configurations for the request
        $limit = $this->getRateLimit($request);

        // Check if the request exceeds the rate limit
        if ($this->limiter->tooManyAttempts($request, $limit['limit'], $limit['duration'])) {
            return $this->rateLimitExceededResponse();
        }

        // Increment the rate limit counter
        $this->limiter->hit($request, $limit['duration']);

        return $next($request);
    }

    /**
     * Get the rate limit for the request.
     *
     * @param  Request  $request
     * @return array
     */
    protected function getRateLimit(Request $request): array
    {
        // Retrieve limit and duration from route or fall back to configuration defaults
        return [
            'limit' => $request->route()->getAction('limit') ?? config('limitshield.default_limit.limit', 60),
            'duration' => $request->route()->getAction('duration') ?? config('limitshield.default_limit.duration', 60),
        ];
    }

    /**
     * Response for when the rate limit is exceeded.
     *
     * @return Response
     */
    protected function rateLimitExceededResponse(): Response
    {
        $message = config('limitshield.responses.too_many_requests', 'Too many requests');
        return response()->json(['error' => $message], Response::HTTP_TOO_MANY_REQUESTS);
    }
}
