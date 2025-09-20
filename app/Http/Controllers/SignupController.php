<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\SignupRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;

class SignupController extends Controller
{
    public function show()
    {
        return view('auth.signup');
    }

    public function store(SignupRequest $request)
    {
        // Generar slug único para la compañía (evita excepción de unique constraint)
        $baseSlug = Str::slug($request->company_name);
        $slug = $baseSlug;
        $counter = 2;
        while (Company::withTrashed()->where('slug', $slug)->exists()) {
            $slug = $baseSlug.'-'.$counter;
            $counter++;
            if ($counter > 100) { // Evitar loop infinito en caso extremo
                return back()->withErrors(['company_name' => 'No se pudo generar un slug único, intenta con otro nombre.'])->withInput();
            }
        }

        try {
            // Crear la compañía
            $company = Company::create([
                'name' => $request->company_name,
                'slug' => $slug,
                'plan' => 'starter', // Plan por defecto
            ]);
        } catch (\Throwable $e) {
            // Fallback por si ocurre una race condition simultánea
            return back()->withErrors(['company_name' => 'El nombre de empresa ya está en uso.'])->withInput();
        }

        // Crear el usuario administrador
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'company_id' => $company->id,
            // Comentar temporalmente hasta que se arreglen las migraciones multi-tenant
            // 'last_active_company_id' => $company->id,
        ]);

        // Asignar rol de admin al usuario
        $user->assignRole('Admin');

        // Loguear automáticamente
        Auth::login($user);

        // Redirigir al onboarding
        return redirect()->route('onboarding.show')->with('success', '¡Bienvenido! Configuremos tu empresa.');
    }
}