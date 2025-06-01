@extends('layouts.custom-guest')

@section('content')
    <div class="min-h-screen flex items-center justify-center bg-gray-100 py-8 px-2">
        <div class="w-full max-w-2xl bg-white rounded-3xl shadow-2xl flex flex-col md:flex-row overflow-hidden">
            <!-- Left: Branding & Welcome -->
            <div class="md:w-1/2 bg-gradient-to-br from-blue-500 to-blue-400 p-10 flex flex-col justify-center items-center text-white">
                <div class="flex flex-col items-center">
                    <img src="https://cdn-icons-png.flaticon.com/512/3135/3135715.png" alt="TSGroup Logo" class="w-16 h-16 mb-4">
                    <h1 class="text-2xl font-bold mb-2">¿Olvidaste tu contraseña?</h1>
                    <p class="mb-6 text-center">No te preocupes, te ayudamos a recuperarla.</p>
                </div>
            </div>
            <!-- Right: Forgot Password Form -->
            <div class="md:w-1/2 p-8 flex flex-col justify-center">
                <h2 class="text-xl font-bold text-blue-700 mb-2 flex items-center gap-2">
                    <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 11c1.104 0 2-.896 2-2s-.896-2-2-2-2 .896-2 2 .896 2 2 2zm0 0v2m0 4h.01M21 12c0 4.97-4.03 9-9 9s-9-4.03-9-9 4.03-9 9-9 9 4.03 9 9z"/></svg>
                    Recuperar acceso
                </h2>
                <div class="mb-4 text-sm text-gray-600">
                    Ingresa tu correo y te enviaremos un enlace para restablecer tu contraseña.
                </div>
                <!-- Session Status -->
                <x-auth-session-status class="mb-4" :status="session('status')" />
                <form method="POST" action="{{ route('password.email') }}" class="space-y-4">
                    @csrf
                    <!-- Email Address -->
                    <div class="relative">
                        <span class="absolute left-3 top-3 text-blue-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 12H8m8 0a4 4 0 11-8 0 4 4 0 018 0zm0 0v1a4 4 0 01-8 0v-1"/></svg>
                        </span>
                        <input id="email" name="email" type="email" required autofocus placeholder="Correo electrónico" class="pl-10 pr-4 py-2 w-full border rounded-lg focus:ring-2 focus:ring-blue-400 focus:outline-none" value="{{ old('email') }}">
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>
                    <div class="flex items-center justify-between mt-4">
                        <a class="text-sm text-blue-500 hover:underline" href="{{ route('login') }}">
                            Volver al login
                        </a>
                        <button type="submit" class="py-2 px-6 bg-blue-500 hover:bg-blue-600 text-white font-bold rounded-lg transition">ENVIAR ENLACE</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
