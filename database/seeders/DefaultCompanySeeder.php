<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DefaultCompanySeeder extends Seeder
{
    public function run(): void
    {
        $company = Company::firstOrCreate([
            'slug' => 'demo'
        ], [
            'name' => 'Demo Company',
            'plan' => 'standard',
            'billing_email' => 'billing@demo.test',
        ]);

        // Asignar company a usuarios existentes que no tengan
        User::whereNull('company_id')->update(['company_id' => $company->id]);
    }
}
