<?php

namespace Database\Factories;

use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CompanyFactory extends Factory
{
    protected $model = Company::class;

    public function definition(): array
    {
        $name = $this->faker->unique()->company();
        return [
            'name' => $name,
            'slug' => Str::slug($name) . '-' . Str::random(4),
            'plan' => 'standard',
            'billing_email' => $this->faker->companyEmail(),
            'is_active' => true,
        ];
    }
}
