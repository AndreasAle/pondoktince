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
    ->withMiddleware(function (Middleware $middleware): void {
        // Redirect manager runs early on every web request (cached lookup).
        $middleware->web(prepend: [
            \App\Http\Middleware\HandleRedirects::class,
        ]);

        // The WhatsApp click beacon is fire-and-forget and carries no state.
        $middleware->validateCsrfTokens(except: [
            'track/whatsapp-click',
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
