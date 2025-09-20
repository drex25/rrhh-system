<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Company;
use App\Models\Department;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MultiTenancyIsolationTest extends TestCase
{
    use RefreshDatabase;

    public function test_department_isolation_between_companies(): void
    {
        $c1 = Company::factory()->create(['slug' => 'c1']);
        $c2 = Company::factory()->create(['slug' => 'c2']);

        app()->instance('currentCompany', $c1);
        Department::create(['name' => 'Dept A', 'code' => 'DA']);

        app()->instance('currentCompany', $c2);
        Department::create(['name' => 'Dept B', 'code' => 'DB']);

        app()->instance('currentCompany', $c1);
        $this->assertEquals(['DA'], Department::pluck('code')->all());
    }
}
