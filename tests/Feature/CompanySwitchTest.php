<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Company;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CompanySwitchTest extends TestCase
{
    use RefreshDatabase;

    public function test_current_company_endpoint_returns_data(): void
    {
        $company = Company::factory()->create();
        $user = User::factory()->create(['company_id' => $company->id]);
        Sanctum::actingAs($user);

        $this->getJson('/api/company/current')
            ->assertOk()
            ->assertJsonPath('data.id', $company->id);
    }

    public function test_switch_company_rejects_other_company(): void
    {
        $companyA = Company::factory()->create();
        $companyB = Company::factory()->create();
        $user = User::factory()->create(['company_id' => $companyA->id]);
        Sanctum::actingAs($user);

        $this->postJson('/api/company/switch', ['company_id' => $companyB->id])
            ->assertStatus(403);
    }

    public function test_switch_company_sets_last_active_company(): void
    {
        $company = Company::factory()->create();
        $user = User::factory()->create(['company_id' => $company->id]);
        Sanctum::actingAs($user);

        $this->postJson('/api/company/switch', ['company_id' => $company->id])
            ->assertOk()
            ->assertJsonPath('data.id', $company->id);

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'last_active_company_id' => $company->id,
        ]);
    }

    public function test_limits_endpoint_returns_usage_and_limits(): void
    {
        $company = Company::factory()->create();
        $user = User::factory()->create(['company_id' => $company->id]);
        Sanctum::actingAs($user);

        $this->getJson('/api/company/limits')
            ->assertOk()
            ->assertJsonStructure(['data' => ['plan','limits','usage','remaining']]);
    }
}