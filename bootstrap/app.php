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
        // --- PERBAIKAN UTAMA: Trust Proxies ---
        // Ini memberitahu Laravel untuk mempercayai HTTPS dari Load Balancer Railway
        $middleware->trustProxies(at: '*');

        // Middleware alias bawaan Anda tetap ada di sini
        $middleware->alias([
            'ensureProfileCompleted' => \App\Http\Middleware\EnsureProfileCompleted::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
