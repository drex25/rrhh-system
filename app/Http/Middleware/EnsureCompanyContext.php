<?php

namespace App\Http\Middleware;

use App\Models\Company;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureCompanyContext
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();
        if ($user) {
            // Ensure user->company_id
            if (!$user->company_id) {
                $company = Company::firstOrCreate([
                    'name' => 'Demo Company',
                ], [
                    'plan' => 'free',
                ]);
                $user->company_id = $company->id;
                $user->save();
            }

            // Ensure last_active_company_id
            if (!$user->last_active_company_id) {
                $user->last_active_company_id = $user->company_id;
                $user->save();
            }
        }

        return $next($request);
    }
}
