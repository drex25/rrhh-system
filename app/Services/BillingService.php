<?php

namespace App\Services;

use App\Models\Company;
use Carbon\Carbon;

class BillingService
{
    public function startTrial(Company $company, int $days = 14): Company
    {
        $company->trial_ends_at = now()->addDays($days);
        $company->active_until = now()->addDays($days);
        $company->save();
        return $company;
    }

    public function isTrialExpired(Company $company): bool
    {
        return $company->trial_ends_at && now()->greaterThan($company->trial_ends_at);
    }

    public function markPaid(Company $company, Carbon $until): Company
    {
        $company->active_until = $until;
        if (!$company->trial_ends_at) {
            $company->trial_ends_at = now();
        }
        $company->save();
        return $company;
    }

    public function isActive(Company $company): bool
    {
        if ($company->active_until && now()->lessThanOrEqualTo($company->active_until)) return true;
        return false;
    }
}
