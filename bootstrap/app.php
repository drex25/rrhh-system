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
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'role' => \App\Http\Middleware\CheckRole::class,
            'company' => \App\Http\Middleware\SetCurrentCompany::class,
            'demo_read_only' => \App\Http\Middleware\DemoReadOnly::class,
        ]);
        $middleware->web([
            \Illuminate\Cookie\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
            \App\Http\Middleware\ForcePasswordChange::class,
            // Bootstrap user->company_id & last_active_company_id si faltan
            \App\Http\Middleware\EnsureCompanyContext::class,
            // Inyectar company para peticiones web autenticadas
            \App\Http\Middleware\SetCurrentCompany::class,
        ]);
        $middleware->api(prepend: [
            // Read-only para demo antes de procesar mutaciones
            \App\Http\Middleware\DemoReadOnly::class,
            // Resolver company antes de bindings en API
            \App\Http\Middleware\EnsureCompanyContext::class,
            \App\Http\Middleware\SetCurrentCompany::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
