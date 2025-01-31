<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Modules\Tasks\Http\Middleware\PreservePagination;
use Modules\Tasks\Http\Middleware\Sanitizer;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->append(Sanitizer::class);
        // $middleware->append(PreservePagination::class);
        // $middleware->alias(['preserve_pagination' => PreservePagination::class]);
        $middleware->appendToGroup('web', [
            'preserve_pagination' => PreservePagination::class
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
