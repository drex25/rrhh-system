<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DemoReadOnly
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (config('demo.enabled') && config('demo.read_only')) {
            $user = $request->user();
            if ($user && $user->email === config('demo.user_email')) {
                // Sólo bloquear DELETE (destructive). Puedes añadir otras rutas sensibles si quieres.
                if ($request->method() === 'DELETE') {
                    if ($request->expectsJson()) {
                        return response()->json(['message' => 'Demo delete blocked (read-only mode)'], 403);
                    }
                    return redirect()->back()->withErrors('Demo delete blocked (read-only mode)');
                }
            }
        }
        return $next($request);
    }
}
