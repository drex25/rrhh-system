<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PlanLimit;

class PlanLimitSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['plan'=>'standard','key'=>'employees','limit'=>100,'period'=>null],
            ['plan'=>'standard','key'=>'departments','limit'=>20,'period'=>null],
            ['plan'=>'standard','key'=>'positions','limit'=>200,'period'=>null],
            ['plan'=>'standard','key'=>'storage_mb','limit'=>1024,'period'=>'monthly'],
            ['plan'=>'premium','key'=>'employees','limit'=>500,'period'=>null],
            ['plan'=>'premium','key'=>'departments','limit'=>100,'period'=>null],
            ['plan'=>'premium','key'=>'positions','limit'=>1000,'period'=>null],
            ['plan'=>'premium','key'=>'storage_mb','limit'=>5120,'period'=>'monthly'],
        ];

        foreach ($data as $row) {
            PlanLimit::updateOrCreate([
                'plan' => $row['plan'],
                'key' => $row['key'],
            ], $row);
        }
    }
}
