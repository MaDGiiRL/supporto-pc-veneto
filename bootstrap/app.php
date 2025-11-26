<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

// 👇 aggiungi questo use (e crea il middleware se non l'hai già fatto)
use App\Http\Middleware\AdminMiddleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Qui definisci gli alias per i middleware personalizzati

        $middleware->alias([
            // es: 'role' => \App\Http\Middleware\RoleMiddleware::class,
            'admin' => AdminMiddleware::class,   // 👈 adesso puoi usare ->middleware('admin')
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })
    ->create();
