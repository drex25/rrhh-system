<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ForcePasswordChange
{
    public function handle(Request $request, Closure $next): Response
    {
        if (
            Auth::check() &&
            Auth::user()->force_password_change &&
            !$request->is('password/change') &&
            !$request->is('logout')
        ) {
            return redirect()->route('password.change');
        }

        return $next($request);
    }
} 