<?php

namespace App\Services;

use App\Models\PlanLimit;
use App\Models\Subscription;
use App\Models\Company;
use Illuminate\Support\Facades\Cache;

class PlanLimitService
{
    public function currentPlanCode(Company $company): string
    {
        $sub = Subscription::where('company_id',$company->id)
            ->whereNull('ends_at')
            ->orderByDesc('id')
            ->first();
        return $sub?->plan_code ?? 'free';
    }

    public function limitsFor(Company $company): array
    {
        $plan = $this->currentPlanCode($company);
        return Cache::remember("plan_limits_{$plan}", 3600, function () use ($plan) {
            return PlanLimit::where('plan',$plan)
                ->get()
                ->mapWithKeys(fn($r)=>[$r->key => (int)$r->limit])
                ->toArray();
        });
    }

    public function get(Company $company, string $key, $default = null)
    {
        $limits = $this->limitsFor($company);
        return $limits[$key] ?? $default;
    }
}
