<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rules\Password;

class PasswordChangeController extends Controller
{
    public function showChangeForm()
    {
        Log::info('Mostrando formulario de cambio de contraseña', [
            'user_id' => Auth::id()
        ]);

        return view('auth.force-password-change');
    }

    public function change(Request $request)
    {
        Log::info('Iniciando proceso de cambio de contraseña', [
            'user_id' => Auth::id(),
            'force_change' => Auth::user()->force_password_change
        ]);

        try {
            $request->validate([
                'current_password' => ['required', 'current_password'],
                'password' => ['required', 'confirmed', Password::defaults()],
            ]);

            $user = User::find(Auth::id());
            $user->password = Hash::make($request->password);
            $user->force_password_change = false;
            $user->save();

            Log::info('Contraseña actualizada exitosamente', [
                'user_id' => Auth::id()
            ]);

            return redirect()->route('dashboard')
                ->with('success', 'Contraseña actualizada correctamente. Redirigiendo al dashboard...');
        } catch (\Exception $e) {
            Log::error('Error al cambiar la contraseña', [
                'user_id' => Auth::id(),
                'error' => $e->getMessage()
            ]);

            return back()->withErrors(['error' => 'Error al cambiar la contraseña. Por favor, intente nuevamente.']);
        }
    }
} 