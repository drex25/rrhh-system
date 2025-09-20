<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use App\Http\Requests\StoreCompanyRequest;
use App\Http\Requests\UpdateCompanyRequest;

class CompanyController extends Controller
{
    public function index(Request $request)
    {
        // Sólo admin global debería ver todas; si quieres filtrar por user->company, agrega policy.
        return Company::query()->paginate();
    }

    public function store(StoreCompanyRequest $request)
    {
        $company = Company::create($request->validated());
        return response()->json($company, 201);
    }

    public function show(Company $company)
    {
        return $company;
    }

    public function update(UpdateCompanyRequest $request, Company $company)
    {
        $company->update($request->validated());
        return $company->refresh();
    }

    public function destroy(Company $company)
    {
        $company->delete();
        return response()->noContent();
    }
}
