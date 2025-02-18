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
        $input = $request->all();

        array_walk_recursive($input, function (&$input) {
            $input = strip_tags($input);
        });

        $request->merge($input);

        return $next($request);
    }
}
