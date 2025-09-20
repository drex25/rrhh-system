<?php

namespace App\Services;

use App\Models\Company;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class CurrentCompanyResolver
{
    public function resolve(): ?Company
    {
        // 1. Subdominio: acme.app.test => acme
        $host = request()->getHost();
        // Ajustar dominio base según entorno. Podrías mover esto a config.
        $baseDomain = config('app.base_domain'); // ej: 'app.test'
        $subdomain = null;
        if ($baseDomain && Str::endsWith($host, $baseDomain)) {
            $maybe = str_replace('.' . $baseDomain, '', $host);
            if ($maybe !== $host) {
                $subdomain = $maybe;
            }
        }
        if ($subdomain && $subdomain !== 'www') {
            $company = Company::where('slug', $subdomain)->first();
            if ($company) return $company;
        }

        // 2. Header explícito
        if ($header = request()->header('X-Company')) {
            $company = Company::where('slug', $header)->first();
            if ($company) return $company;
        }

        // 3. Usuario autenticado: priorizar last_active_company_id
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->last_active_company_id) {
                $company = Company::find($user->last_active_company_id);
                if ($company) return $company;
            }
            if ($user->company_id) {
                if (!$user->last_active_company_id) {
                    $user->last_active_company_id = $user->company_id;
                    $user->save();
                }
                return Company::find($user->company_id);
            }
        }

        return null; // Público / landing / error controlado luego.
    }
}
