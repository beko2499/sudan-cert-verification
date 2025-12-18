<?php

// app/Http/Middleware/RateLimitVerification.php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Cache\RateLimiter;
use Illuminate\Http\Request;

class RateLimitVerification
{
    protected $limiter;

    public function __construct(RateLimiter $limiter)
    {
        $this->limiter = $limiter;
    }

    public function handle(Request $request, Closure $next)
    {
        $key = 'verify:' . $request->ip();
        
        if ($this->limiter->tooManyAttempts($key, 10)) {
            return response()->json([
                'message' => 'تم تجاوز الحد المسموح لعمليات التحقق. الرجاء المحاولة لاحقاً.'
            ], 429);
        }
        
        $this->limiter->hit($key, 60); // 10 محاولات في الدقيقة
        
        return $next($request);
    }
}
