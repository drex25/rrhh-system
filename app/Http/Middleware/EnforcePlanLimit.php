<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Services\PlanLimitService;

class EnforcePlanLimit
{
    public function __construct(private PlanLimitService $limits){}

    public function handle(Request $request, Closure $next, string $key, string $modelClass = null): Response
    {
        $company = $request->user()?->company; // Ajustar si usas currentCompany distinto
        if(!$company){
            return $next($request);
        }

        $limit = $this->limits->get($company, $key);
        if(!$limit){
            return $next($request); // sin límite configurado
        }

        $current = null;
        if($modelClass && class_exists($modelClass)){
            $current = $modelClass::where('company_id',$company->id)->count();
        }

        if($current !== null && $current >= $limit){
            if($request->expectsJson()){
                return response()->json([
                    'message' => 'Plan limit reached',
                    'limit_key' => $key,
                    'limit' => $limit
                ], 403);
            }
            return redirect()->back()->with('error','Has alcanzado el límite de tu plan (' . $key . '). Actualiza para continuar.');
        }

        return $next($request);
    }
}
