<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>{{ config('app.name', 'Laravel') }} · Crear tu Empresa</title>

    <link rel="preconnect" href="https://fonts.bunny.net" />
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    @vite(['resources/css/app.css','resources/js/app.js'])

    <style>
        /* Fondo animado sutil */
        .gradient-bg {
            background: radial-gradient(circle at 20% 20%, rgba(59,130,246,.25), transparent 60%),
                        radial-gradient(circle at 80% 30%, rgba(168,85,247,.22), transparent 65%),
                        linear-gradient(135deg,#f5f7fa 0%,#ffffff 40%,#f1f5f9 100%);
        }
        .dark .gradient-bg {
            background: radial-gradient(circle at 15% 25%, rgba(37,99,235,.25), transparent 55%),
                        radial-gradient(circle at 85% 35%, rgba(147,51,234,.25), transparent 60%),
                        linear-gradient(135deg,#0f172a 0%,#111827 50%,#1e293b 100%);
        }
        /* Glass panel */
        .glass {
            background: rgba(255,255,255,0.65);
            backdrop-filter: blur(14px) saturate(160%);
            -webkit-backdrop-filter: blur(14px) saturate(160%);
        }
        .dark .glass {
            background: rgba(17,24,39,0.72);
        }
        /* Password strength bar */
        .strength-bar span { transition: width .35s ease, background-color .35s ease; }
        .input-focus-ring:focus { box-shadow: 0 0 0 2px theme('colors.white'), 0 0 0 4px rgb(59 130 246 / 70%); }
    </style>
</head>
<body class="font-sans antialiased min-h-screen gradient-bg relative overflow-x-hidden">
    <!-- Decorative shapes -->
    <div aria-hidden="true" class="pointer-events-none select-none">
        <div class="absolute -top-32 -left-32 w-96 h-96 bg-blue-400/10 dark:bg-blue-500/10 rounded-full blur-3xl animate-pulse"></div>
        <div class="absolute top-1/3 -right-32 w-96 h-96 bg-purple-400/10 dark:bg-purple-500/10 rounded-full blur-3xl animate-pulse [animation-delay:1.5s]"></div>
    </div>

    <main class="relative z-10 flex flex-col lg:flex-row min-h-screen">
        <!-- Left / Marketing panel -->
        <section class="hidden lg:flex w-full lg:w-1/2 flex-col justify-between py-10 px-14">
            <div>
                <a href="{{ route('landing.index') }}" class="inline-flex items-center gap-3 group">
                    <span class="relative inline-block">
                        <img src="{{ asset('images/tsg.png') }}" alt="Logo" class="h-14 w-auto transition-transform duration-300 group-hover:scale-105" />
                        <span class="absolute -inset-2 rounded-full bg-gradient-to-r from-blue-500/20 to-purple-600/20 opacity-0 group-hover:opacity-100 blur-md transition" ></span>
                    </span>
                    <span class="font-semibold text-xl text-gray-800 dark:text-gray-200 tracking-tight">{{ config('app.name','TS Group') }}</span>
                </a>
                <div class="mt-16 max-w-lg">
                    <h1 class="text-4xl font-extrabold tracking-tight text-slate-800 dark:text-white leading-tight">Gestiona tu <span class="bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">talento</span> con una plataforma moderna</h1>
                    <p class="mt-6 text-slate-600 dark:text-slate-300 text-base leading-relaxed">Automatiza procesos de RRHH, centraliza información y obtén insights accionables. Empieza en minutos y escala sin complicaciones.</p>
                    <ul class="mt-8 space-y-4 text-sm text-slate-600 dark:text-slate-300">
                        <li class="flex gap-3"><i class="fa-solid fa-circle-check text-emerald-500 mt-0.5"></i><span>Onboarding inteligente y seguimiento de candidatos</span></li>
                        <li class="flex gap-3"><i class="fa-solid fa-circle-check text-emerald-500 mt-0.5"></i><span>Gestión de asistencias, vacaciones y licencias</span></li>
                        <li class="flex gap-3"><i class="fa-solid fa-circle-check text-emerald-500 mt-0.5"></i><span>Panel de control con métricas clave en tiempo real</span></li>
                    </ul>
                </div>
            </div>
            <div class="grid grid-cols-3 gap-6 max-w-md mt-12">
                <div class="text-center">
                    <p class="text-3xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">14d</p>
                    <p class="text-xs tracking-wide text-slate-600 dark:text-slate-400">Prueba gratis</p>
                </div>
                <div class="text-center">
                    <p class="text-3xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">0$</p>
                    <p class="text-xs tracking-wide text-slate-600 dark:text-slate-400">Sin tarjeta</p>
                </div>
                <div class="text-center">
                    <p class="text-3xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">5min</p>
                    <p class="text-xs tracking-wide text-slate-600 dark:text-slate-400">Setup rápido</p>
                </div>
            </div>
            <p class="mt-10 text-[10px] text-slate-400">© {{ date('Y') }} {{ config('app.name','TS Group') }}. Todos los derechos reservados.</p>
        </section>

        <!-- Right / Form panel -->
        <section class="flex w-full lg:w-1/2 items-center justify-center py-10 px-6 sm:px-10">
            <div class="w-full max-w-2xl">
                <div class="glass rounded-2xl shadow-2xl border border-white/40 dark:border-white/10 px-8 py-8 relative overflow-hidden">
                    <div class="absolute -top-20 -right-28 w-72 h-72 bg-gradient-to-br from-blue-500/10 to-purple-500/10 rounded-full blur-3xl"></div>
                    <div class="relative">
                        <div class="flex items-start justify-between flex-wrap gap-4">
                            <div>
                                <h2 class="text-3xl font-bold text-slate-800 dark:text-white tracking-tight">Crea tu Empresa</h2>
                                <p class="mt-1.5 text-sm text-slate-600 dark:text-slate-300">Comienza tu prueba gratuita ahora. Sin tarjeta de crédito.</p>
                            </div>
                            <button type="button" id="toggleTheme" class="shrink-0 inline-flex items-center gap-2 text-xs px-3 py-2 rounded-lg bg-slate-900/5 dark:bg-white/10 text-slate-600 dark:text-slate-300 hover:bg-slate-900/10 dark:hover:bg-white/20 transition">
                                <i class="fa-solid fa-moon"></i>
                                <span>Modo</span>
                            </button>
                        </div>

                        <form method="POST" action="{{ route('signup.store') }}" class="mt-8 grid gap-x-6 gap-y-5 md:grid-cols-2 items-start">
                            @csrf

                            <!-- Company Name -->
                            <div class="md:col-span-1">
                                <label for="company_name" class="flex items-center text-xs font-medium uppercase tracking-wide text-slate-600 dark:text-slate-400 mb-2 gap-2">
                                    <i class="fas fa-building text-blue-500"></i>
                                    <span>Nombre de la Empresa</span>
                                </label>
                                <input id="company_name" name="company_name" type="text" autocomplete="organization" required autofocus placeholder="Ej: Mi Empresa SRL" value="{{ old('company_name') }}" class="peer block w-full rounded-xl border border-slate-300/70 dark:border-slate-600/60 bg-white/70 dark:bg-slate-800/60 px-4 py-3 text-slate-800 dark:text-slate-100 placeholder-slate-400 dark:placeholder-slate-500 focus:outline-none focus:ring-4 focus:ring-blue-500/30 focus:border-blue-500 @error('company_name') border-red-500 @enderror" />
                                @error('company_name')
                                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Admin Name -->
                            <div class="md:col-span-1">
                                <label for="name" class="flex items-center text-xs font-medium uppercase tracking-wide text-slate-600 dark:text-slate-400 mb-2 gap-2">
                                    <i class="fas fa-user text-purple-500"></i>
                                    <span>Tu Nombre Completo</span>
                                </label>
                                <input id="name" name="name" type="text" autocomplete="name" required placeholder="Ej: Juan Pérez" value="{{ old('name') }}" class="block w-full rounded-xl border border-slate-300/70 dark:border-slate-600/60 bg-white/70 dark:bg-slate-800/60 px-4 py-3 text-slate-800 dark:text-slate-100 placeholder-slate-400 dark:placeholder-slate-500 focus:outline-none focus:ring-4 focus:ring-blue-500/30 focus:border-blue-500 @error('name') border-red-500 @enderror" />
                                @error('name')
                                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div class="md:col-span-2">
                                <label for="email" class="flex items-center text-xs font-medium uppercase tracking-wide text-slate-600 dark:text-slate-400 mb-2 gap-2">
                                    <i class="fas fa-envelope text-green-500"></i>
                                    <span>Email Corporativo</span>
                                </label>
                                <div class="relative">
                                    <input id="email" name="email" type="email" autocomplete="username" required placeholder="juan@miempresa.com" value="{{ old('email') }}" class="peer block w-full rounded-xl border border-slate-300/70 dark:border-slate-600/60 bg-white/70 dark:bg-slate-800/60 pl-4 pr-14 py-3 text-slate-800 dark:text-slate-100 placeholder-slate-400 dark:placeholder-slate-500 focus:outline-none focus:ring-4 focus:ring-blue-500/30 focus:border-blue-500 @error('email') border-red-500 @enderror" />
                                    <span class="absolute inset-y-0 right-0 flex items-center pr-4 text-slate-400 peer-focus:text-blue-500 transition"><i class="fa-regular fa-at"></i></span>
                                </div>
                                @error('email')
                                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Password -->
                            <div class="md:col-span-1">
                                <div class="flex items-center justify-between mb-2">
                                    <label for="password" class="flex items-center text-xs font-medium uppercase tracking-wide text-slate-600 dark:text-slate-400 gap-2">
                                        <i class="fas fa-lock text-orange-500"></i>
                                        <span>Contraseña</span>
                                    </label>
                                    <button type="button" id="togglePassword" class="text-[11px] font-medium text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300 focus:outline-none">Mostrar</button>
                                </div>
                                <div class="relative">
                                    <input id="password" name="password" type="password" autocomplete="new-password" required placeholder="Mínimo 8 caracteres" class="password-input block w-full rounded-xl border border-slate-300/70 dark:border-slate-600/60 bg-white/70 dark:bg-slate-800/60 px-4 py-3 pr-12 text-slate-800 dark:text-slate-100 placeholder-slate-400 dark:placeholder-slate-500 focus:outline-none focus:ring-4 focus:ring-blue-500/30 focus:border-blue-500 @error('password') border-red-500 @enderror" />
                                    <span class="absolute inset-y-0 right-0 flex items-center pr-4 text-slate-400"><i class="fa-solid fa-shield"></i></span>
                                </div>
                                <div class="mt-2 flex gap-1" aria-hidden="true">
                                    <span class="flex-1 h-1 rounded bg-slate-200 dark:bg-slate-700 overflow-hidden"><i class="block h-full w-0" id="ps1"></i></span>
                                    <span class="flex-1 h-1 rounded bg-slate-200 dark:bg-slate-700 overflow-hidden"><i class="block h-full w-0" id="ps2"></i></span>
                                    <span class="flex-1 h-1 rounded bg-slate-200 dark:bg-slate-700 overflow-hidden"><i class="block h-full w-0" id="ps3"></i></span>
                                    <span class="flex-1 h-1 rounded bg-slate-200 dark:bg-slate-700 overflow-hidden"><i class="block h-full w-0" id="ps4"></i></span>
                                    <span class="flex-1 h-1 rounded bg-slate-200 dark:bg-slate-700 overflow-hidden"><i class="block h-full w-0" id="ps5"></i></span>
                                </div>
                                <p id="passwordHint" class="mt-1 text-[11px] text-slate-500 dark:text-slate-400">Introduce una contraseña.</p>
                                @error('password')
                                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Confirm Password -->
                            <div class="md:col-span-1">
                                <label for="password_confirmation" class="flex items-center text-xs font-medium uppercase tracking-wide text-slate-600 dark:text-slate-400 mb-2 gap-2">
                                    <i class="fas fa-lock text-orange-500"></i>
                                    <span>Confirmar Contraseña</span>
                                </label>
                                <input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" required placeholder="Repite tu contraseña" class="block w-full rounded-xl border border-slate-300/70 dark:border-slate-600/60 bg-white/70 dark:bg-slate-800/60 px-4 py-3 text-slate-800 dark:text-slate-100 placeholder-slate-400 dark:placeholder-slate-500 focus:outline-none focus:ring-4 focus:ring-blue-500/30 focus:border-blue-500 @error('password_confirmation') border-red-500 @enderror" />
                                @error('password_confirmation')
                                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                @enderror
                                <p id="matchHint" class="mt-1 text-[11px] text-slate-400"></p>
                            </div>

                            <!-- Terms -->
                            <div class="md:col-span-2 pt-2">
                                <p class="text-[11px] leading-relaxed text-slate-500 dark:text-slate-400">Al crear tu cuenta, aceptas nuestros <a href="#" class="text-blue-600 hover:underline dark:text-blue-400">Términos de Servicio</a> y <a href="#" class="text-blue-600 hover:underline dark:text-blue-400">Política de Privacidad</a>.</p>
                            </div>

                            <!-- Submit -->
                            <div class="md:col-span-2 pt-2">
                                <button type="submit" class="group relative w-full overflow-hidden rounded-xl bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 px-6 py-4 font-semibold text-white shadow-lg shadow-blue-500/20 transition-all hover:shadow-indigo-600/30 focus:outline-none focus:ring-4 focus:ring-blue-500/40">
                                    <span class="absolute inset-0 -translate-x-full bg-gradient-to-r from-transparent via-white/25 to-transparent group-hover:translate-x-full transition-transform duration-700"></span>
                                    <span class="inline-flex items-center gap-2">
                                        <i class="fa-solid fa-rocket"></i>
                                        Crear mi Empresa – ¡Gratis!
                                    </span>
                                </button>
                            </div>
                        </form>

                        <div class="mt-8 text-center text-sm">
                            <p class="text-slate-600 dark:text-slate-400">¿Ya tienes una cuenta? <a href="{{ route('login') }}" class="text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300 font-medium">Inicia Sesión</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <script>
        (function(){
            const pwd = document.getElementById('password');
            const pwd2 = document.getElementById('password_confirmation');
            const toggle = document.getElementById('togglePassword');
            const hint = document.getElementById('passwordHint');
            const matchHint = document.getElementById('matchHint');
            const segments = ['ps1','ps2','ps3','ps4','ps5'].map(id=>document.getElementById(id));
            const segColors = ['bg-red-500','bg-orange-500','bg-yellow-500','bg-lime-500','bg-emerald-500'];

            function scorePassword(v){
                let s=0; if(v.length>=8) s++; if(/[A-Z]/.test(v)) s++; if(/[0-9]/.test(v)) s++; if(/[^A-Za-z0-9]/.test(v)) s++; if(v.length>=14) s++; return s; //0-5
            }
            function paintSegments(score){
                segments.forEach((el,i)=>{
                    if(!el) return; el.className='block h-full w-full rounded transition-all duration-300';
                    if(i<score){ el.classList.add(segColors[Math.min(score-1, segColors.length-1)]); } else { el.classList.remove(...segColors); el.classList.add('bg-transparent'); }
                });
            }
            function updatePassword(){
                const v = pwd.value; const score = scorePassword(v); paintSegments(score);
                hint.textContent = !v ? 'Introduce una contraseña.' : score < 3 ? 'Fortalece la contraseña.' : score < 5 ? 'Contraseña aceptable.' : 'Contraseña muy fuerte.';
                updateMatch();
            }
            function updateMatch(){
                if(!pwd2.value){ matchHint.textContent=''; return; }
                if(pwd2.value === pwd.value){ matchHint.textContent='Las contraseñas coinciden.'; matchHint.className='mt-1 text-[11px] text-emerald-500'; }
                else { matchHint.textContent='Las contraseñas no coinciden.'; matchHint.className='mt-1 text-[11px] text-red-500'; }
            }
            toggle?.addEventListener('click',()=>{
                const type = pwd.getAttribute('type') === 'password' ? 'text' : 'password';
                pwd.setAttribute('type', type);
                toggle.textContent = type === 'password' ? 'Mostrar' : 'Ocultar';
            });
            pwd?.addEventListener('input', updatePassword);
            pwd2?.addEventListener('input', updateMatch);
            updatePassword();

            // Tema
            const btnTheme = document.getElementById('toggleTheme');
            btnTheme?.addEventListener('click',()=>{
                document.documentElement.classList.toggle('dark');
                btnTheme.querySelector('i')?.classList.toggle('fa-moon');
                btnTheme.querySelector('i')?.classList.toggle('fa-sun');
            });
        })();
    </script>
</body>
</html>