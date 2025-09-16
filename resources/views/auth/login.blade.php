@extends('layouts.custom-guest')

@section('content')
    @php
        $demoUsers = [
            ['role' => 'Admin', 'email' => 'admin@company.com', 'icon' => '👑', 'color' => 'from-purple-500 to-pink-500'],
            ['role' => 'HR', 'email' => 'hr@company.com', 'icon' => '👥', 'color' => 'from-blue-500 to-cyan-500'],
            ['role' => 'Manager', 'email' => 'manager@company.com', 'icon' => '📊', 'color' => 'from-green-500 to-emerald-500'],
            ['role' => 'Employee', 'email' => 'employee@company.com', 'icon' => '👤', 'color' => 'from-orange-500 to-yellow-500'],
        ];
    @endphp

    <div class="min-h-screen w-full bg-gradient-to-br from-gray-100 via-gray-50 to-gray-100 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900 flex items-center justify-center p-4">
        <!-- Main Container -->
        <div class="w-full max-w-6xl flex flex-col md:flex-row gap-8 items-stretch" x-data="{ showPassword: false, loading: false, email: '', password: '', highlight: false, darkMode: localStorage.getItem('darkMode') === 'true' }" x-init="$watch('darkMode', val => localStorage.setItem('darkMode', val))">
            <!-- Left Panel: Welcome & Demo Users -->
            <div class="w-full md:w-1/2 flex flex-col gap-8">
                <!-- Welcome Section -->
                <div class="bg-white/80 dark:bg-white/10 backdrop-blur-lg rounded-3xl p-8 border border-gray-200 dark:border-white/20 shadow-2xl flex-1 flex flex-col">
                    <div class="flex items-center gap-4 mb-6">
                        <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-blue-500 to-purple-500 flex items-center justify-center shadow-lg">
                            <img src="https://cdn-icons-png.flaticon.com/512/3135/3135715.png" alt="Logo" class="w-10 h-10">
                        </div>
                        <div>
                            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">TSGroup</h1>
                            <p class="text-blue-700 dark:text-blue-200">Sistema de Gestión</p>
                        </div>
                    </div>
                    <div class="flex-1 flex flex-col justify-center">
                        <h2 class="text-4xl font-bold text-gray-900 dark:text-white mb-4">¡Bienvenido!</h2>
                        <p class="text-gray-700 dark:text-gray-300 text-lg">Gestiona tu talento de forma simple, profesional y moderna.</p>
                    </div>
                </div>

                <!-- Demo Users Section -->
                <div class="bg-white/80 dark:bg-white/10 backdrop-blur-lg rounded-3xl p-8 border border-blue-200 dark:border-blue-400/30 shadow-2xl flex-1 flex flex-col">
                    <h3 class="text-xl font-semibold text-blue-700 dark:text-blue-300 mb-2 flex items-center gap-2">
                        <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        Cuentas Demo
                    </h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">Haz clic en una cuenta para autocompletar el login con usuario y contraseña demo.</p>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 flex-1">
                        @foreach($demoUsers as $user)
                            <div class="group cursor-pointer transform transition-all duration-300 hover:scale-105"
                                 @click="email = '{{ $user['email'] }}'; password = 'password'; highlight = true; $nextTick(() => { $refs.emailInput.focus(); })">
                                <div class="bg-gradient-to-br {{ $user['color'] }} rounded-2xl p-4 shadow-lg h-full flex items-center gap-3">
                                    <span class="text-3xl">{{ $user['icon'] }}</span>
                                    <div class="flex-1 min-w-0">
                                        <div class="font-bold text-white text-lg truncate">{{ $user['role'] }}</div>
                                        <div class="text-sm text-white/90 truncate select-all">{{ $user['email'] }}</div>
                                    </div>
                                    <button type="button" class="px-3 py-1 bg-white/30 dark:bg-white/20 hover:bg-white/40 dark:hover:bg-white/30 text-white rounded-lg text-sm transition-colors duration-200 pointer-events-none opacity-80">
                                        Usar
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Right Panel: Login Form -->
            <div class="w-full md:w-1/2 flex flex-col justify-center">
                <div class="bg-white/80 dark:bg-white/10 backdrop-blur-lg rounded-3xl p-8 border border-gray-200 dark:border-white/20 shadow-2xl h-full flex flex-col justify-center">
                    <div class="flex flex-col items-center mb-6">
                        <div class="bg-gradient-to-br from-blue-500 to-purple-500 rounded-full p-4 shadow-lg mb-2">
                            <!-- Ícono de login -->
                            <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm0 2c-2.67 0-8 1.337-8 4v2a1 1 0 001 1h14a1 1 0 001-1v-2c0-2.663-5.33-4-8-4z" />
                            </svg>
                        </div>
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-1">Iniciar Sesión</h2>
                        <p class="text-gray-600 dark:text-gray-400 text-sm">Ingresa tus credenciales para continuar</p>
                    </div>

                    <form method="POST" action="{{ route('login') }}" class="space-y-6 flex-1 flex flex-col justify-center" @submit="loading = true">
                        @csrf
                        <div class="space-y-4 flex-1">
                            <div class="relative group">
                                <div class="absolute inset-0 bg-gradient-to-r from-blue-200 to-purple-200 dark:from-blue-500 dark:to-purple-500 rounded-xl blur opacity-20 group-hover:opacity-30 transition-opacity"></div>
                                <div class="relative">
                                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-blue-400 transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                                        </svg>
                                    </span>
                                    <input id="email" name="email" type="email" required autofocus autocomplete="username" aria-label="Correo electrónico"
                                           placeholder="Correo electrónico" 
                                           class="w-full pl-12 pr-4 py-3 bg-white/90 dark:bg-white/5 border border-gray-300 dark:border-white/10 rounded-xl text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-200 dark:focus:ring-blue-500 transition-all duration-200 shadow-sm focus:shadow-lg"
                                           x-model="email" x-ref="emailInput" :class="highlight ? 'border-blue-500' : ''" @animationend="highlight = false" @focus="error = ''">
                                </div>
                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            </div>

                            <div class="relative group">
                                <div class="absolute inset-0 bg-gradient-to-r from-blue-200 to-purple-200 dark:from-blue-500 dark:to-purple-500 rounded-xl blur opacity-20 group-hover:opacity-30 transition-opacity"></div>
                                <div class="relative">
                                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-blue-400 transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                        </svg>
                                    </span>
                                    <input :type="showPassword ? 'text' : 'password'" id="password" name="password" required 
                                           autocomplete="current-password" placeholder="Contraseña" aria-label="Contraseña"
                                           class="w-full pl-12 pr-12 py-3 bg-white/90 dark:bg-white/5 border border-gray-300 dark:border-white/10 rounded-xl text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-200 dark:focus:ring-blue-500 transition-all duration-200 shadow-sm focus:shadow-lg"
                                           x-ref="passwordInput" x-model="password" :class="highlight ? 'border-blue-500' : ''" @animationend="highlight = false" @focus="error = ''">
                                    <button type="button" @click="showPassword = !showPassword" 
                                            class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-blue-400 transition-colors">
                                        <svg x-show="!showPassword" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                        <svg x-show="showPassword" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                        </svg>
                                    </button>
                                </div>
                                <x-input-error :messages="$errors->get('password')" class="mt-2" />
                            </div>
                        </div>

                        <div class="flex items-center justify-between mt-6">
                            <label class="flex items-center">
                                <input type="checkbox" name="remember" class="rounded border-gray-400 dark:border-gray-600 text-blue-500 shadow-sm focus:ring-blue-500 bg-white/80 dark:bg-white/5">
                                <span class="ml-2 text-sm text-gray-700 dark:text-gray-400">Recordarme</span>
                            </label>
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="text-sm text-blue-600 dark:text-blue-400 hover:text-blue-500 dark:hover:text-blue-300 transition-colors">
                                    ¿Olvidaste tu contraseña?
                                </a>
                            @endif
                        </div>

                        <button type="submit" 
                                class="w-full py-3 px-4 bg-gradient-to-r from-blue-500 to-purple-500 hover:from-blue-600 hover:to-purple-600 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-[1.02] focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 focus:ring-offset-gray-100 dark:focus:ring-offset-gray-900 disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center mt-6"
                                :disabled="loading">
                            <svg x-show="loading" class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            <span>INGRESAR</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Dark Mode Toggle -->
    <div class="fixed top-4 right-4 z-50">
        <button @click="darkMode = !darkMode; localStorage.setItem('darkMode', darkMode)"
                class="p-2 rounded-full bg-white/10 hover:bg-white/20 text-gray-700 dark:text-white shadow-lg backdrop-blur-sm transition-all duration-300 hover:scale-110">
            <template x-if="!darkMode">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
                </svg>
            </template>
            <template x-if="darkMode">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
                </svg>
            </template>
        </button>
    </div>
@endsection

<style>
@keyframes float {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-10px); }
}

@keyframes pulse {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.05); }
}

.animate-float {
    animation: float 3s ease-in-out infinite;
}

.animate-pulse {
    animation: pulse 2s ease-in-out infinite;
}

/* Glassmorphism effects */
.glass {
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.2);
}

/* Gradient animations */
@keyframes gradient {
    0% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
    100% { background-position: 0% 50%; }
}

.animate-gradient {
    background-size: 200% 200%;
    animation: gradient 15s ease infinite;
}

/* Custom scrollbar */
::-webkit-scrollbar {
    width: 8px;
}

::-webkit-scrollbar-track {
    background: rgba(255, 255, 255, 0.1);
    border-radius: 4px;
}

::-webkit-scrollbar-thumb {
    background: rgba(255, 255, 255, 0.2);
    border-radius: 4px;
}

::-webkit-scrollbar-thumb:hover {
    background: rgba(255, 255, 255, 0.3);
}
</style>
