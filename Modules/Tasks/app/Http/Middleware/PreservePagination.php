<?php

namespace Modules\Tasks\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class PreservePagination
{
    public function handle(Request $request, Closure $next)
    {
        $currentRouteName = Route::currentRouteName();

        $routesToPreserve = [
            'tasks.index',
            'tasks.update',
            'tasks.edit',
            'tasks.reorder',
            'tasks.create'
        ];

        if (in_array($currentRouteName, $routesToPreserve)) {

            if ($request->has('per_page')) {
                session(['pagination.per_page' => $request->query('per_page')]);
            }

            if ($request->has('page')) {
                session(['pagination.page' => $request->query('page')]);
            }
        }

        return $next($request);
    }
}
