<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class SettingsController extends Controller
{
    /**
     * Show company settings form
     */
    public function company()
    {
        $user = Auth::user();
        $company = Company::find($user->company_id);
        
        if (!$company) {
            return redirect()->route('dashboard')
                ->with('error', 'No tienes una empresa asignada.');
        }

        $timezones = [
            'America/Argentina/Buenos_Aires' => 'Buenos Aires (UTC-3)',
            'America/Argentina/Cordoba' => 'Córdoba (UTC-3)',
            'America/Argentina/Mendoza' => 'Mendoza (UTC-3)',
            'America/Mexico_City' => 'México City (UTC-6)',
            'America/Bogota' => 'Bogotá (UTC-5)',
            'America/Lima' => 'Lima (UTC-5)',
            'America/Santiago' => 'Santiago (UTC-3)',
            'America/Caracas' => 'Caracas (UTC-4)',
            'UTC' => 'UTC (UTC+0)',
        ];

        $currencies = [
            'ARS' => 'Peso Argentino (ARS)',
            'USD' => 'Dólar Estadounidense (USD)',
            'EUR' => 'Euro (EUR)',
            'MXN' => 'Peso Mexicano (MXN)',
            'COP' => 'Peso Colombiano (COP)',
            'PEN' => 'Sol Peruano (PEN)',
            'CLP' => 'Peso Chileno (CLP)',
            'VES' => 'Bolívar Venezolano (VES)',
        ];

        $businessTypes = [
            'SRL' => 'Sociedad de Responsabilidad Limitada (SRL)',
            'SA' => 'Sociedad Anónima (SA)',
            'SAPA' => 'Sociedad Anónima con Participación Estatal',
            'Cooperativa' => 'Cooperativa',
            'Fundación' => 'Fundación',
            'Asociación Civil' => 'Asociación Civil',
            'Empresa Unipersonal' => 'Empresa Unipersonal',
            'Otro' => 'Otro',
        ];

        return view('settings.company', compact('company', 'timezones', 'currencies', 'businessTypes'));
    }

    /**
     * Update company settings
     */
    public function updateCompany(Request $request)
    {
        $user = Auth::user();
        $company = Company::find($user->company_id);
        
        if (!$company) {
            return redirect()->route('dashboard')
                ->with('error', 'No tienes una empresa asignada.');
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'timezone' => 'required|string',
            'currency' => 'required|string|max:3',
            'address' => 'nullable|string|max:500',
            'phone' => 'nullable|string|max:20',
            'website' => 'nullable|url|max:255',
            'tax_id' => 'nullable|string|max:50',
            'business_type' => 'nullable|string|max:100',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Handle logo upload
        $logoPath = $company->logo;
        if ($request->hasFile('logo')) {
            // Delete old logo if exists
            if ($logoPath && Storage::disk('public')->exists($logoPath)) {
                Storage::disk('public')->delete($logoPath);
            }
            
            // Store new logo
            $logoPath = $request->file('logo')->store('company-logos', 'public');
        }

        // Update company
        $company->update([
            'name' => $request->name,
            'timezone' => $request->timezone,
            'currency' => $request->currency,
            'address' => $request->address,
            'phone' => $request->phone,
            'website' => $request->website,
            'tax_id' => $request->tax_id,
            'business_type' => $request->business_type,
            'logo' => $logoPath,
        ]);

        return redirect()->route('settings.company')
            ->with('success', 'Configuración de empresa actualizada correctamente.');
    }

    /**
     * Remove company logo
     */
    public function removeLogo()
    {
        $user = Auth::user();
        $company = Company::find($user->company_id);
        
        if (!$company) {
            return response()->json(['error' => 'Empresa no encontrada'], 404);
        }

        if ($company->logo && Storage::disk('public')->exists($company->logo)) {
            Storage::disk('public')->delete($company->logo);
        }

        $company->update(['logo' => null]);

        return response()->json(['success' => 'Logo eliminado correctamente']);
    }
}
