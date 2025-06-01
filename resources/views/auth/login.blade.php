@extends('layouts.custom-guest')

@section('content')
    @php
        $demoUsers = [
            ['role' => 'Admin', 'email' => 'admin@company.com', 'icon' => '👑'],
            ['role' => 'HR', 'email' => 'hr@company.com', 'icon' => '👥'],
            ['role' => 'Manager', 'email' => 'manager@company.com', 'icon' => '📊'],
            ['role' => 'Employee', 'email' => 'employee@company.com', 'icon' => '👤'],
        ];
    @endphp

    <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-gray-100 to-blue-100 dark:from-gray-900 dark:to-blue-950 py-8 px-2" 
         x-data="{ 
            darkMode: localStorage.getItem('darkMode') === 'true', 
            showPassword: false, 
            loading: false, 
            email: '', 
            password: '',
            hoveredUser: null,
            shake: false
         }" 
         :class="{ 'dark': darkMode }" 
         x-init="$watch('darkMode', val => localStorage.setItem('darkMode', val)); email = '{{ old('email') }}'">
        
        <!-- Floating particles background -->
        <div class="fixed inset-0 overflow-hidden pointer-events-none">
            <div class="absolute inset-0 bg-gradient-to-br from-blue-50/30 to-blue-100/30 dark:from-blue-900/30 dark:to-blue-950/30 backdrop-blur-sm"></div>
            <div class="particles-container"></div>
        </div>

        <div class="absolute top-4 right-4 flex items-center gap-2 z-10">
            <button @click="darkMode = !darkMode" 
                    class="p-2 rounded-full text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-400 transition-all duration-300 hover:scale-110" 
                    aria-label="Cambiar modo oscuro">
                <svg x-show="!darkMode" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
                </svg>
                <svg x-show="darkMode" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
                </svg>
            </button>
        </div>

        <div class="w-full max-w-6xl min-h-[700px] bg-white/80 dark:bg-gray-800/80 backdrop-blur-lg rounded-3xl shadow-2xl shadow-blue-100/40 flex flex-col md:flex-row overflow-hidden transition-all duration-300 animate-fade-in-up relative">
            <!-- Glassmorphism effect -->
            <div class="absolute inset-0 bg-gradient-to-br from-white/50 to-white/30 dark:from-gray-800/50 dark:to-gray-800/30 backdrop-blur-sm"></div>
            
            <!-- Left: Branding & Welcome -->
            <div class="md:w-1/2 bg-gradient-to-br from-blue-500 to-blue-400 dark:from-blue-900 dark:to-blue-700 p-16 flex flex-col justify-center items-center text-white relative overflow-hidden">
                <!-- Animated background pattern -->
                <div class="absolute inset-0 opacity-10">
                    <div class="absolute inset-0 bg-[radial-gradient(circle_at_center,_var(--tw-gradient-stops))] from-white via-transparent to-transparent animate-pulse"></div>
                </div>
                
                <div class="flex flex-col items-center animate-fade-in relative z-10">
                    <div class="relative">
                        <img src="https://cdn-icons-png.flaticon.com/512/3135/3135715.png" alt="TSGroup Logo" 
                             class="w-24 h-24 mb-8 animate-float">
                        <div class="absolute -inset-4 bg-blue-400/20 rounded-full blur-xl animate-pulse"></div>
                    </div>
                    <h1 class="text-4xl font-bold mb-2 bg-clip-text text-transparent bg-gradient-to-r from-white to-blue-100">Bienvenido a TSGroup</h1>
                    <p class="mb-8 text-lg text-center text-blue-50">Gestiona tu talento de forma simple y profesional</p>
                    
                    <!-- Modern SVG Illustration -->
                    <div class="relative w-[220px] h-[150px]">
                        <svg width="220" height="150" viewBox="0 0 180 120" fill="none" xmlns="http://www.w3.org/2000/svg" class="animate-float-slow">
                            <rect x="20" y="60" width="140" height="40" rx="8" fill="#2563eb" class="animate-pulse"/>
                            <rect x="60" y="30" width="60" height="40" rx="8" fill="#fff"/>
                            <circle cx="90" cy="50" r="12" fill="#2563eb" class="animate-bounce"/>
                            <rect x="80" y="70" width="20" height="30" rx="5" fill="#fff"/>
                        </svg>
                        <div class="absolute inset-0 bg-blue-400/20 rounded-full blur-xl animate-pulse"></div>
                    </div>
                </div>
            </div>

            <!-- Right: Login Form -->
            <div class="md:w-1/2 p-16 flex flex-col justify-center relative z-10">
                <h2 class="text-3xl font-bold text-blue-700 dark:text-blue-400 mb-4 flex items-center gap-2">
                    <svg class="w-7 h-7 text-blue-500 dark:text-blue-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 11c1.104 0 2-.896 2-2s-.896-2-2-2-2 .896-2 2 .896 2 2 2zm0 0v2m0 4h.01M21 12c0 4.97-4.03 9-9 9s-9-4.03-9-9 4.03-9 9-9 9 4.03 9 9z"/>
                    </svg>
                    Inicia sesión
                </h2>
                <p class="text-gray-500 dark:text-gray-300 mb-8">Accede a tu cuenta corporativa</p>

                <!-- Session Status -->
                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}" class="space-y-6" @submit="loading = true">
                    @csrf
                    <!-- Email -->
                    <div class="relative group">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-blue-400 dark:text-blue-300 transition-colors duration-200 group-focus-within:text-blue-600 z-10 pointer-events-none">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="2" y="4" width="20" height="16" rx="4"/>
                                <polyline points="22,6 12,13 2,6"></polyline>
                            </svg>
                        </span>
                        <input id="email" name="email" type="email" required autofocus autocomplete="username" 
                               placeholder="Correo electrónico" 
                               class="pl-12 pr-4 py-3 w-full border rounded-xl bg-white/80 dark:bg-gray-700/80 dark:border-gray-600 dark:text-white focus:ring-2 focus:ring-blue-400 focus:outline-none transition-all duration-200 text-base shadow-sm group-hover:shadow-md" 
                               x-model="email"
                               @invalid="shake = true; setTimeout(() => shake = false, 500)">
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Password -->
                    <div class="relative group">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-blue-400 dark:text-blue-300 transition-colors duration-200 group-focus-within:text-blue-600 z-10 pointer-events-none">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                                <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                            </svg>
                        </span>
                        <input :type="showPassword ? 'text' : 'password'" id="password" name="password" required 
                               autocomplete="current-password" placeholder="Contraseña" 
                               class="pl-12 pr-12 py-3 w-full border rounded-xl bg-white/80 dark:bg-gray-700/80 dark:border-gray-600 dark:text-white focus:ring-2 focus:ring-blue-400 focus:outline-none transition-all duration-200 text-base shadow-sm group-hover:shadow-md" 
                               x-model="password" x-ref="passwordInput"
                               @invalid="shake = true; setTimeout(() => shake = false, 500)">
                        <button type="button" @click="showPassword = !showPassword" tabindex="-1" 
                                class="absolute right-4 top-1/2 -translate-y-1/2 text-blue-400 dark:text-blue-300 hover:text-blue-600 dark:hover:text-blue-400 focus:outline-none transition-colors duration-200 z-10" 
                                :aria-label="showPassword ? 'Ocultar contraseña' : 'Mostrar contraseña'">
                            <svg x-show="!showPassword" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                <circle cx="12" cy="12" r="3"></circle>
                            </svg>
                            <svg x-show="showPassword" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path>
                                <line x1="1" y1="1" x2="23" y2="23"></line>
                            </svg>
                        </button>
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- Remember Me -->
                    <div class="flex items-center">
                        <input id="remember_me" type="checkbox" 
                               class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500 transition-colors duration-200" 
                               name="remember">
                        <label for="remember_me" class="ml-2 text-sm text-gray-600 dark:text-gray-300">Recordarme</label>
                    </div>

                    <button type="submit" 
                            class="w-full py-3 text-lg bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white font-bold rounded-xl shadow-md transition-all duration-300 active:scale-95 flex items-center justify-center disabled:opacity-60 hover:shadow-lg" 
                            :disabled="loading">
                        <svg x-show="loading" class="animate-spin h-5 w-5 mr-2 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path>
                        </svg>
                        <span>INGRESAR</span>
                    </button>

                    <div class="flex justify-between items-center mt-2">
                        @if (Route::has('password.request'))
                            <a class="text-sm text-blue-500 hover:text-blue-600 dark:text-blue-300 dark:hover:text-blue-400 transition-colors duration-200" 
                               href="{{ route('password.request') }}">¿Olvidaste tu contraseña?</a>
                        @endif
                    </div>
                </form>

                <!-- Demo users -->
                <div class="mt-10 grid grid-cols-1 lg:grid-cols-2 gap-4 w-full">
                    @foreach($demoUsers as $user)
                        <div class="flex items-center bg-white/50 dark:bg-blue-900/50 backdrop-blur-sm rounded-xl px-4 py-3 shadow-sm gap-3 hover:shadow-lg transition-all duration-300 cursor-pointer w-full transform hover:-translate-y-1" 
                             @mouseover="hoveredUser = '{{ $user['role'] }}'" 
                             @mouseleave="hoveredUser = null"
                             @click="email = '{{ $user['email'] }}'; $nextTick(() => { $refs.passwordInput.focus(); })">
                            <span class="inline-flex items-center justify-center h-10 w-10 rounded-full bg-gradient-to-r from-blue-500 to-blue-600 text-white font-bold text-lg transition-transform duration-300"
                                  :class="{ 'scale-110': hoveredUser === '{{ $user['role'] }}' }">
                                {{ $user['icon'] }}
                            </span>
                            <div class="flex-1 min-w-0">
                                <div class="font-semibold text-blue-700 dark:text-blue-200 text-base truncate transition-colors duration-200"
                                     :class="{ 'text-blue-600 dark:text-blue-100': hoveredUser === '{{ $user['role'] }}' }">
                                    {{ $user['role'] }}
                                </div>
                                <div class="text-xs text-gray-500 dark:text-gray-300 truncate">{{ $user['email'] }}</div>
                            </div>
                            <button type="button" 
                                    class="ml-2 px-3 py-1 text-xs bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white rounded shadow transition-all duration-300 flex items-center gap-1 transform hover:scale-105" 
                                    @click.stop="email = '{{ $user['email'] }}'; password = 'password'; $nextTick(() => { $refs.passwordInput.focus(); })">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 17l-4 4m0 0l-4-4m4 4V3"/>
                                </svg>
                                Usar
                            </button>
                        </div>
                    @endforeach
                </div>

                <div class="text-center text-gray-400 dark:text-gray-500 text-xs mt-10">© 2025 TSGroup. Todos los derechos reservados.</div>
            </div>
        </div>

        <!-- Add particles.js -->
        <script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                particlesJS('particles-container', {
                    particles: {
                        number: { value: 80, density: { enable: true, value_area: 800 } },
                        color: { value: '#3b82f6' },
                        shape: { type: 'circle' },
                        opacity: { value: 0.5, random: true },
                        size: { value: 3, random: true },
                        line_linked: {
                            enable: true,
                            distance: 150,
                            color: '#3b82f6',
                            opacity: 0.2,
                            width: 1
                        },
                        move: {
                            enable: true,
                            speed: 2,
                            direction: 'none',
                            random: true,
                            straight: false,
                            out_mode: 'out',
                            bounce: false
                        }
                    },
                    interactivity: {
                        detect_on: 'canvas',
                        events: {
                            onhover: { enable: true, mode: 'grab' },
                            onclick: { enable: true, mode: 'push' },
                            resize: true
                        },
                        modes: {
                            grab: { distance: 140, line_linked: { opacity: 0.5 } },
                            push: { particles_nb: 4 }
                        }
                    },
                    retina_detect: true
                });
            });
        </script>
        <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    </div>
@endsection

<style>
@keyframes float {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-10px); }
}

@keyframes float-slow {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-5px); }
}

@keyframes shake {
    0%, 100% { transform: translateX(0); }
    10%, 30%, 50%, 70%, 90% { transform: translateX(-5px); }
    20%, 40%, 60%, 80% { transform: translateX(5px); }
}

.animate-float {
    animation: float 3s ease-in-out infinite;
}

.animate-float-slow {
    animation: float-slow 4s ease-in-out infinite;
}

.animate-shake {
    animation: shake 0.5s cubic-bezier(.36,.07,.19,.97) both;
}

.particles-container {
    position: absolute;
    width: 100%;
    height: 100%;
    top: 0;
    left: 0;
    z-index: 0;
}
</style>
