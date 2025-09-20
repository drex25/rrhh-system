<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Plan;
use App\Models\PlanLimit;

class PlanSeeder extends Seeder
{
    public function run(): void
    {
        $plans = [
            [
                'code' => 'free',
                'name' => 'Free',
                'description' => 'Para comenzar con lo esencial',
                'interval' => 'monthly',
                'price_cents' => 0,
                'yearly_price_cents' => 0,
                'currency' => 'USD',
                'features' => [
                    'Hasta 5 empleados',
                    '1 vacante activa',
                    'Soporte por email',
                ],
            ],
            [
                'code' => 'pro',
                'name' => 'Pro',
                'description' => 'Escala tu operación de RRHH',
                'interval' => 'monthly',
                'price_cents' => 4900, // 49.00 USD
                'yearly_price_cents' => (int) (4900 * 12 * 0.8), // 20% descuento aprox
                'currency' => 'USD',
                'features' => [
                    'Hasta 100 empleados',
                    'Vacantes ilimitadas',
                    'Automatizaciones básicas',
                    'Soporte prioritario',
                ],
            ],
            [
                'code' => 'enterprise',
                'name' => 'Enterprise',
                'description' => 'Máximo control y personalización',
                'interval' => 'monthly',
                'price_cents' => 19900,
                'yearly_price_cents' => (int) (19900 * 12 * 0.8),
                'currency' => 'USD',
                'features' => [
                    'Empleados ilimitados',
                    'Vacantes ilimitadas',
                    'Integraciones avanzadas',
                    'SLA y manager dedicado',
                ],
            ],
        ];

        foreach($plans as $p){
            Plan::updateOrCreate(['code'=>$p['code']], $p);
        }

        $limits = [
            // plan, key, limit, period(optional)
            ['free','employees_max',5,null],
            ['free','job_postings_max',1,null],
            ['free','storage_mb',200,null],
            ['pro','employees_max',100,null],
            ['pro','job_postings_max',999999,null],
            ['pro','storage_mb',2048,null],
            ['enterprise','employees_max',999999,null],
            ['enterprise','job_postings_max',999999,null],
            ['enterprise','storage_mb',10240,null],
        ];
        foreach($limits as [$plan,$key,$limit,$period]){
            PlanLimit::updateOrCreate([
                'plan'=>$plan,'key'=>$key
            ],[
                'limit'=>$limit,
                'period'=>$period
            ]);
        }
    }
}
