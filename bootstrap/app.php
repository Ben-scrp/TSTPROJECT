<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Auth\AuthenticationException; // Tambahan
use Illuminate\Http\Request;                 // Tambahan

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'role' => \App\Http\Middleware\CekRoleMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        // 👇 Menangani error "Belum Login" agar return JSON, bukan redirect
        $exceptions->render(function (AuthenticationException $e, Request $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    'error' => 'Anda belum login atau token tidak valid.'
                ], 401);
            }
        });
    })
    ->withProviders([
        Tymon\JWTAuth\Providers\LaravelServiceProvider::class,
    ])
    ->create();