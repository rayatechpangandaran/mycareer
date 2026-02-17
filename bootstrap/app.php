<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function ($middleware) {
        $middleware->alias([
        'role' => \App\Http\Middleware\RoleMiddleware::class, 
        'block.role' => \App\Http\Middleware\BlockRole::class,
        ]);
        $middleware->append(\App\Http\Middleware\NgrokSkipBrowserWarning::class);
        $middleware->append(\App\Http\Middleware\ForceHttps::class);
    })

    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();