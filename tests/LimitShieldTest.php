<?php

namespace Tests\Unit;

use Illuminate\Http\Request;
use Tests\TestCase;
use App\Http\Middleware\LimitShieldMiddleware;
use App\RateLimiter\RedisRateLimiter;
use Mockery;

class LimitShieldTest extends TestCase
{
    /**
     * Test rate limiting functionality.
     *
     * @return void
     */
    public function testRateLimiting()
    {
        // Create a mock Request object
        $request = Mockery::mock(Request::class);

        $limiter = Mockery::mock(RedisRateLimiter::class);
        $limiter->shouldReceive('tooManyAttempts')->andReturn(false);

        $middleware = new LimitShieldMiddleware($limiter);
        $response = $middleware->handle($request, function () {
            return response()->json(['success' => true]);
        });

        // checking if middleware allows the request to pass through
        $this->assertEquals(200, $response->getStatusCode());
    }
}
