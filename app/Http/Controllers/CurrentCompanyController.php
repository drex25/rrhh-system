<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Services\PlanLimitService;

class CurrentCompanyController extends Controller
{
    public function current(Request $request)
    {
    $company = \current_company();
        if (!$company) {
            return response()->json(['data' => null], 200);
        }
        return response()->json(['data' => [
            'id' => $company->id,
            'name' => $company->name,
            'plan' => $company->plan ?? 'basic',
            'trial_ends_at' => $company->trial_ends_at,
        ]]);
    }

    public function mine(Request $request)
    {
        $user = $request->user();
        // Actualmente asumimos 1 company por user (company_id). Futuro: relación many-to-many.
        $companies = [];
        if ($user->company_id) {
            $c = Company::find($user->company_id);
            if ($c) {
                $companies[] = ['id' => $c->id, 'name' => $c->name];
            }
        }
        // Fallback: si current_company() existe y no se agregó
        $current = \current_company();
        if ($current && !collect($companies)->firstWhere('id', $current->id)) {
            $companies[] = ['id' => $current->id, 'name' => $current->name];
        }
        return response()->json(['data' => $companies]);
    }

    public function switch(Request $request)
    {
        $request->validate([
            // Asumimos que company id es uuid? Si no, retiramos uuid rule.
            'company_id' => 'required|exists:companies,id'
        ]);

        $user = $request->user();
        $companyId = $request->input('company_id');

        // Autorización: hoy el usuario sólo puede cambiar a su propia company_id base.
        if ($user->company_id !== $companyId) {
            return response()->json(['message' => 'Not allowed for this company'], 403);
        }

        if ($user->last_active_company_id !== $companyId) {
            $user->last_active_company_id = $companyId;
            $user->save();
        }

        return response()->json([
            'message' => 'Company switched',
            'data' => [
                'id' => $user->last_active_company_id,
            ]
        ]);
    }

    public function limits(PlanLimitService $service)
    {
    $company = \current_company();
        if (!$company) {
            return response()->json(['data' => null], 200);
        }

        $limits = $service->getLimitsFor($company);
        $usage = [
            'employees' => DB::table('employees')->where('company_id', $company->id)->count(),
            'job_postings' => DB::table('job_postings')->where('company_id', $company->id)->count(),
            'candidates' => DB::table('candidates')->where('company_id', $company->id)->count(),
            'interviews' => DB::table('interviews')->where('company_id', $company->id)->count(),
        ];
        $remaining = [];
        foreach ($limits as $k => $limit) {
            $remaining[$k] = is_null($limit) ? null : max(0, $limit - ($usage[$k] ?? 0));
        }

        return response()->json([
            'data' => [
                'plan' => $company->plan ?? 'basic',
                'limits' => $limits,
                'usage' => $usage,
                'remaining' => $remaining,
            ]
        ]);
    }
}