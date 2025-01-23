<?php

namespace Modules\Tasks\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Sanitizer
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        return $next($request);
    }
}
