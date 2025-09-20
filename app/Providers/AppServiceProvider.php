<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Log\Logger;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $logger = $this->app['log'];
        if ($logger instanceof Logger) {
            $logger->getLogger()->pushProcessor(function (array $record) {
                if (function_exists('company_id') && company_id()) {
                    $record['extra']['company_id'] = company_id();
                }
                return $record;
            });
        }
    }
}
