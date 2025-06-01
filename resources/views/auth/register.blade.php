@extends('layouts.custom-guest')

@section('content')
    <div class="min-h-screen flex items-center justify-center bg-gray-100 py-8 px-2">
        <div class="w-full max-w-3xl bg-white rounded-3xl shadow-2xl flex flex-col md:flex-row overflow-hidden">
            <!-- Left: Branding & Welcome -->
            <div class="md:w-1/2 bg-gradient-to-br from-blue-500 to-blue-400 p-10 flex flex-col justify-center items-center text-white">
                <div class="flex flex-col items-center">
                    <img src="https://cdn-icons-png.flaticon.com/512/3135/3135715.png" alt="TSGroup Logo" class="w-16 h-16 mb-4">
                    <h1 class="text-3xl font-bold mb-2">Crea tu cuenta</h1>
                    <p class="mb-6 text-center">Únete a TSGroup y gestiona tu talento de forma simple y profesional</p>
                </div>
            </div>
            <!-- Right: Register Form -->
            <div class="md:w-1/2 p-8 flex flex-col justify-center">
                <h2 class="text-2xl font-bold text-blue-700 mb-2 flex items-center gap-2">
                    <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 21v-2a4 4 0 00-3-3.87M12 3a4 4 0 110 8 4 4 0 010-8zm6 8v1a4 4 0 01-8 0v-1"/></svg>
                    Registro
                </h2>
                <form method="POST" action="{{ route('register') }}" class="space-y-4 mt-4">
                    @csrf
                    <!-- Name -->
                    <div class="relative">
                        <span class="absolute left-3 top-3 text-blue-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5.121 17.804A13.937 13.937 0 0112 15c2.5 0 4.847.655 6.879 1.804M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        </span>
                        <input id="name" name="name" type="text" required autofocus autocomplete="name" placeholder="Nombre completo" class="pl-10 pr-4 py-2 w-full border rounded-lg focus:ring-2 focus:ring-blue-400 focus:outline-none" value="{{ old('name') }}">
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>
                    <!-- Email -->
                    <div class="relative">
                        <span class="absolute left-3 top-3 text-blue-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 12H8m8 0a4 4 0 11-8 0 4 4 0 018 0zm0 0v1a4 4 0 01-8 0v-1"/></svg>
                        </span>
                        <input id="email" name="email" type="email" required autocomplete="username" placeholder="Correo electrónico" class="pl-10 pr-4 py-2 w-full border rounded-lg focus:ring-2 focus:ring-blue-400 focus:outline-none" value="{{ old('email') }}">
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>
                    <!-- Password -->
                    <div class="relative">
                        <span class="absolute left-3 top-3 text-blue-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m0-6v2m6 4V7a2 2 0 00-2-2H8a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2z"/></svg>
                        </span>
                        <input id="password" name="password" type="password" required autocomplete="new-password" placeholder="Contraseña" class="pl-10 pr-4 py-2 w-full border rounded-lg focus:ring-2 focus:ring-blue-400 focus:outline-none">
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>
                    <!-- Confirm Password -->
                    <div class="relative">
                        <span class="absolute left-3 top-3 text-blue-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m0-6v2m6 4V7a2 2 0 00-2-2H8a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2z"/></svg>
                        </span>
                        <input id="password_confirmation" name="password_confirmation" type="password" required autocomplete="new-password" placeholder="Confirmar contraseña" class="pl-10 pr-4 py-2 w-full border rounded-lg focus:ring-2 focus:ring-blue-400 focus:outline-none">
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                    </div>
                    <div class="flex items-center justify-between mt-4">
                        <a class="text-sm text-blue-500 hover:underline" href="{{ route('login') }}">
                            ¿Ya tienes cuenta?
                        </a>
                        <button type="submit" class="py-2 px-6 bg-blue-500 hover:bg-blue-600 text-white font-bold rounded-lg transition">REGISTRARME</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
