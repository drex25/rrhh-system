<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Company;
use App\Models\User;
use App\Models\Department;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;

class ApiDepartmentIsolationTest extends TestCase
{
    use RefreshDatabase;

    public function test_api_department_list_is_isolated_by_company(): void
    {
        $c1 = Company::factory()->create(['slug'=>'c1']);
        $c2 = Company::factory()->create(['slug'=>'c2']);

        $u1 = User::factory()->create(['company_id'=>$c1->id]);
        $u2 = User::factory()->create(['company_id'=>$c2->id]);

        app()->instance('currentCompany', $c1);
        Department::create(['name'=>'Dept A','code'=>'DA']);
        app()->instance('currentCompany', $c2);
        Department::create(['name'=>'Dept B','code'=>'DB']);

        // Usuario company 1
        Sanctum::actingAs($u1);
        app()->instance('currentCompany', $c1); // simulate middleware
        $resp1 = $this->getJson('/api/departments');
        $resp1->assertOk()->assertJsonMissing(['code'=>'DB'])->assertJsonFragment(['code'=>'DA']);

        // Usuario company 2
        Sanctum::actingAs($u2);
        app()->instance('currentCompany', $c2);
        $resp2 = $this->getJson('/api/departments');
        $resp2->assertOk()->assertJsonMissing(['code'=>'DA'])->assertJsonFragment(['code'=>'DB']);
    }
}
