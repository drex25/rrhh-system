<?php

namespace App\Http\Middleware;

use App\Services\CurrentCompanyResolver;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetCurrentCompany
{
    public function __construct(private CurrentCompanyResolver $resolver) {}

    public function handle(Request $request, Closure $next): Response
    {
        $company = $this->resolver->resolve();
        if ($company) {
            app()->instance('currentCompany', $company);
        }
        // Si requieres que siempre exista, podrías abortar aquí si no hay company.
        return $next($request);
    }
}
