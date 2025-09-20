<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Company;
use App\Services\BillingService;
use Illuminate\Support\Facades\Log;

class CheckTrials extends Command
{
    protected $signature = 'billing:check-trials';
    protected $description = 'Revisa trials expirados y desactiva companies.';

    public function handle(BillingService $billing): int
    {
        Company::query()
            ->whereNotNull('trial_ends_at')
            ->where('is_active', true)
            ->chunk(100, function($companies) use ($billing) {
                foreach ($companies as $company) {
                    if ($billing->isTrialExpired($company) && !$billing->isActive($company)) {
                        $company->is_active = false;
                        $company->save();
                        Log::info('Company trial expired', ['company_id'=>$company->id]);
                        $this->info("Trial expired: {$company->slug}");
                    }
                }
            });
        return self::SUCCESS;
    }
}
