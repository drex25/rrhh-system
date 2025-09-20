<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - @yield('title', 'Bienvenido')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- AOS CSS -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/css/mobile-fixes.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="font-sans antialiased bg-gray-50 dark:bg-gray-900">
    @if(session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'success',
                    title: 'Éxito',
                    text: @json(session('success')),
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    customClass: {
                        popup: 'rounded-xl'
                    }
                });
            });
        </script>
    @endif

    <!-- Navigation -->
    <nav class="fixed top-0 left-0 right-0 z-40 bg-white/90 dark:bg-gray-900/90 backdrop-blur-xl border-b border-gray-200/50 dark:border-gray-700/50 shadow-lg" x-data="{ mobileMenuOpen: false }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <!-- Logo - Left Side -->
                <div class="flex items-center">
                    <div class="shrink-0 flex items-center">
                        <a href="{{ route('landing.index') }}" class="flex items-center group">
                            <div class="relative">
                                <img src="{{ asset('images/tsg.png') }}" alt="TS Group Logo" class="h-12 w-auto transition-transform duration-300 group-hover:scale-105">
                                <div class="absolute -inset-2 bg-gradient-to-r from-blue-600/20 to-purple-600/20 rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-300 blur-sm"></div>
                            </div>
                        </a>
                    </div>
                </div>
                
                <!-- Desktop Navigation Links - Right Side -->
                <div class="hidden md:flex md:items-center md:space-x-2 lg:space-x-4">
                    <a href="{{ route('landing.index') }}" class="text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 px-2 lg:px-3 py-2 rounded-lg text-sm font-medium transition-all duration-200 hover:bg-blue-50 dark:hover:bg-blue-900/20 whitespace-nowrap">
                        Inicio
                    </a>
                    
                    <!-- Mega Menu - Plataforma -->
                    <div class="relative group">
                        <button class="text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 px-2 lg:px-3 py-2 rounded-lg text-sm font-medium transition-all duration-200 hover:bg-blue-50 dark:hover:bg-blue-900/20 flex items-center whitespace-nowrap">
                            Plataforma
                            <i class="fas fa-chevron-down ml-1 text-xs transform group-hover:rotate-180 transition-transform duration-200"></i>
                        </button>
                        
                        <!-- Mega Menu Dropdown -->
                        <div class="absolute top-full left-0 mt-2 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 translate-y-2 group-hover:translate-y-0 z-50">
                            <div class="w-screen max-w-5xl" style="transform: translateX(calc(-50vw + 50%));">
                                <div class="mx-4">
                                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl border border-gray-200 dark:border-gray-700">
                                        <div class="p-6">
                                            <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
                                                <!-- Soluciones Column -->
                                                <div class="space-y-4">
                                                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4 flex items-center">
                                                        <i class="fas fa-cogs text-blue-500 mr-2"></i>
                                                        Soluciones
                                                    </h3>
                                                    <a href="#" class="group/item flex items-start p-3 rounded-xl hover:bg-blue-50 dark:hover:bg-blue-900/20 transition-all duration-200">
                                                        <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900/30 rounded-lg flex items-center justify-center mr-4 group-hover/item:scale-110 transition-transform duration-200">
                                                            <i class="fas fa-user-plus text-blue-600 text-lg"></i>
                                                        </div>
                                                        <div>
                                                            <h4 class="font-semibold text-gray-900 dark:text-white group-hover/item:text-blue-600 transition-colors">Reclutamiento</h4>
                                                            <p class="text-sm text-gray-500 dark:text-gray-400">IA para selección inteligente</p>
                                                        </div>
                                                    </a>
                                                    <a href="#" class="group/item flex items-start p-3 rounded-xl hover:bg-purple-50 dark:hover:bg-purple-900/20 transition-all duration-200">
                                                        <div class="w-12 h-12 bg-purple-100 dark:bg-purple-900/30 rounded-lg flex items-center justify-center mr-4 group-hover/item:scale-110 transition-transform duration-200">
                                                            <i class="fas fa-users text-purple-600 text-lg"></i>
                                                        </div>
                                                        <div>
                                                            <h4 class="font-semibold text-gray-900 dark:text-white group-hover/item:text-purple-600 transition-colors">Gestión Personal</h4>
                                                            <p class="text-sm text-gray-500 dark:text-gray-400">Legajos digitales centralizados</p>
                                                        </div>
                                                    </a>
                                                    <a href="#" class="group/item flex items-start p-3 rounded-xl hover:bg-green-50 dark:hover:bg-green-900/20 transition-all duration-200">
                                                        <div class="w-12 h-12 bg-green-100 dark:bg-green-900/30 rounded-lg flex items-center justify-center mr-4 group-hover/item:scale-110 transition-transform duration-200">
                                                            <i class="fas fa-chart-line text-green-600 text-lg"></i>
                                                        </div>
                                                        <div>
                                                            <h4 class="font-semibold text-gray-900 dark:text-white group-hover/item:text-green-600 transition-colors">Analytics</h4>
                                                            <p class="text-sm text-gray-500 dark:text-gray-400">Dashboards en tiempo real</p>
                                                        </div>
                                                    </a>
                                                </div>

                                                <!-- Productos Column -->
                                                <div class="space-y-4">
                                                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4 flex items-center">
                                                        <i class="fas fa-rocket text-purple-500 mr-2"></i>
                                                        Productos
                                                    </h3>
                                                    <a href="#" class="group/item flex items-start p-3 rounded-xl hover:bg-indigo-50 dark:hover:bg-indigo-900/20 transition-all duration-200">
                                                        <div class="w-12 h-12 bg-indigo-100 dark:bg-indigo-900/30 rounded-lg flex items-center justify-center mr-4 group-hover/item:scale-110 transition-transform duration-200">
                                                            <i class="fas fa-desktop text-indigo-600 text-lg"></i>
                                                        </div>
                                                        <div>
                                                            <h4 class="font-semibold text-gray-900 dark:text-white group-hover/item:text-indigo-600 transition-colors">Plataforma Web</h4>
                                                            <p class="text-sm text-gray-500 dark:text-gray-400">Acceso completo desde navegador</p>
                                                        </div>
                                                    </a>
                                                    <a href="#" class="group/item flex items-start p-3 rounded-xl hover:bg-pink-50 dark:hover:bg-pink-900/20 transition-all duration-200">
                                                        <div class="w-12 h-12 bg-pink-100 dark:bg-pink-900/30 rounded-lg flex items-center justify-center mr-4 group-hover/item:scale-110 transition-transform duration-200">
                                                            <i class="fas fa-mobile-alt text-pink-600 text-lg"></i>
                                                        </div>
                                                        <div>
                                                            <h4 class="font-semibold text-gray-900 dark:text-white group-hover/item:text-pink-600 transition-colors">App Móvil</h4>
                                                            <p class="text-sm text-gray-500 dark:text-gray-400">Gestión desde cualquier lugar</p>
                                                        </div>
                                                    </a>
                                                </div>

                                                <!-- Recursos Column -->
                                                <div class="space-y-4">
                                                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4 flex items-center">
                                                        <i class="fas fa-book text-green-500 mr-2"></i>
                                                        Recursos
                                                    </h3>
                                                    <a href="#" class="group/item flex items-start p-3 rounded-xl hover:bg-teal-50 dark:hover:bg-teal-900/20 transition-all duration-200">
                                                        <div class="w-12 h-12 bg-teal-100 dark:bg-teal-900/30 rounded-lg flex items-center justify-center mr-4 group-hover/item:scale-110 transition-transform duration-200">
                                                            <i class="fas fa-video text-teal-600 text-lg"></i>
                                                        </div>
                                                        <div>
                                                            <h4 class="font-semibold text-gray-900 dark:text-white group-hover/item:text-teal-600 transition-colors">Demo en Vivo</h4>
                                                            <p class="text-sm text-gray-500 dark:text-gray-400">Presentación interactiva</p>
                                                        </div>
                                                    </a>
                                                    <a href="#" class="group/item flex items-start p-3 rounded-xl hover:bg-orange-50 dark:hover:bg-orange-900/20 transition-all duration-200">
                                                        <div class="w-12 h-12 bg-orange-100 dark:bg-orange-900/30 rounded-lg flex items-center justify-center mr-4 group-hover/item:scale-110 transition-transform duration-200">
                                                            <i class="fas fa-graduation-cap text-orange-600 text-lg"></i>
                                                        </div>
                                                        <div>
                                                            <h4 class="font-semibold text-gray-900 dark:text-white group-hover/item:text-orange-600 transition-colors">Centro de Ayuda</h4>
                                                            <p class="text-sm text-gray-500 dark:text-gray-400">Guías y tutoriales</p>
                                                        </div>
                                                    </a>
                                                </div>

                                                <!-- CTA Column -->
                                                <div class="bg-gradient-to-br from-blue-50 to-purple-50 dark:from-blue-900/20 dark:to-purple-900/20 rounded-xl p-6">
                                                    <div class="text-center">
                                                        <div class="w-16 h-16 bg-gradient-to-r from-blue-500 to-purple-500 rounded-full flex items-center justify-center mx-auto mb-4">
                                                            <i class="fas fa-star text-white text-xl"></i>
                                                        </div>
                                                        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">¿Listo para empezar?</h3>
                                                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">Prueba nuestra plataforma gratis por 14 días</p>
                                                        <a href="{{ route('login') }}" class="inline-flex items-center justify-center px-4 py-2 bg-gradient-to-r from-blue-600 to-purple-600 text-white text-sm font-semibold rounded-lg hover:from-blue-700 hover:to-purple-700 transition-all duration-200 transform hover:scale-105 shadow-lg">
                                                            <i class="fas fa-rocket mr-2"></i>
                                                            Comenzar Gratis
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <a href="#pricing" class="text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 px-2 lg:px-3 py-2 rounded-lg text-sm font-medium transition-all duration-200 hover:bg-blue-50 dark:hover:bg-blue-900/20 whitespace-nowrap">
                        Precios
                    </a>
                    
                    <a href="{{ route('public.job-postings.index') }}" class="text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 px-2 lg:px-3 py-2 rounded-lg text-sm font-medium transition-all duration-200 hover:bg-blue-50 dark:hover:bg-blue-900/20 whitespace-nowrap">
                        Empleos
                    </a>
                    
                    <a href="#contact" class="text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 px-2 lg:px-3 py-2 rounded-lg text-sm font-medium transition-all duration-200 hover:bg-blue-50 dark:hover:bg-blue-900/20 whitespace-nowrap">
                        Contacto
                    </a>

                    @if(!auth()->check() && config('demo.enabled'))
                    <a href="{{ route('demo.login') }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-purple-700 dark:text-purple-300 hover:text-purple-800 dark:hover:text-purple-200 transition-all duration-200 bg-purple-50 dark:bg-purple-900/30 hover:bg-purple-100 dark:hover:bg-purple-900/40 rounded-lg whitespace-nowrap">
                        <i class="fas fa-play mr-2"></i>
                        Live Demo
                        <span class="ml-2 inline-flex items-center px-1.5 py-0.5 text-[10px] font-semibold rounded bg-purple-600 text-white">NEW</span>
                    </a>
                    @endif

                    <!-- Login Button -->
                    <a href="{{ route('login') }}" 
                       class="inline-flex items-center px-6 py-2.5 bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white text-sm font-semibold rounded-xl transition-all duration-200 shadow-lg hover:shadow-xl hover:-translate-y-0.5 hover:scale-105 whitespace-nowrap">
                        <i class="fas fa-sign-in-alt mr-2"></i>
                        Iniciar Sesión
                    </a>
                    
                    <!-- Mobile menu button -->
                    <div class="md:hidden">
                        <button @click="mobileMenuOpen = !mobileMenuOpen" class="inline-flex items-center justify-center p-2 rounded-xl text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-blue-500">
                            <i class="fas fa-bars text-xl" x-show="!mobileMenuOpen"></i>
                            <i class="fas fa-times text-xl" x-show="mobileMenuOpen" x-cloak></i>
                        </button>
                    </div>
                </div>
            </div>
            
            <!-- Mobile menu -->
            <div x-show="mobileMenuOpen" x-transition class="md:hidden" x-cloak>
                <div class="px-4 pt-4 pb-6 space-y-3 bg-white/95 dark:bg-gray-900/95 backdrop-blur-lg rounded-xl mt-2 shadow-xl border border-gray-200 dark:border-gray-700">
                    <!-- Navigation Links -->
                    <a href="{{ route('landing.index') }}" class="flex items-center px-4 py-3 rounded-lg text-base font-medium text-gray-700 dark:text-gray-300 hover:text-blue-600 hover:bg-blue-50 transition-colors duration-200">
                        <i class="fas fa-home mr-3 text-blue-500"></i>
                        Inicio
                    </a>
                    
                    <!-- Plataforma Section -->
                    <div class="space-y-2">
                        <div class="px-4 py-2 text-sm font-semibold text-gray-500 uppercase tracking-wider border-b border-gray-200 dark:border-gray-700">Plataforma</div>
                        <a href="#" class="flex items-center px-4 py-3 rounded-lg text-sm text-gray-600 dark:text-gray-400 hover:text-blue-600 hover:bg-blue-50 transition-colors duration-200">
                            <i class="fas fa-user-plus mr-3 text-blue-500"></i>
                            Reclutamiento Inteligente
                        </a>
                        <a href="#" class="flex items-center px-4 py-3 rounded-lg text-sm text-gray-600 dark:text-gray-400 hover:text-purple-600 hover:bg-purple-50 transition-colors duration-200">
                            <i class="fas fa-users mr-3 text-purple-500"></i>
                            Gestión de Personal
                        </a>
                        <a href="#" class="flex items-center px-4 py-3 rounded-lg text-sm text-gray-600 dark:text-gray-400 hover:text-green-600 hover:bg-green-50 transition-colors duration-200">
                            <i class="fas fa-chart-line mr-3 text-green-500"></i>
                            Analytics & Reportes
                        </a>
                    </div>
                    
                    <a href="#pricing" class="flex items-center px-4 py-3 rounded-lg text-base font-medium text-gray-700 dark:text-gray-300 hover:text-blue-600 hover:bg-blue-50 transition-colors duration-200">
                        <i class="fas fa-tag mr-3 text-indigo-500"></i>
                        Precios
                    </a>
                    
                    <a href="{{ route('public.job-postings.index') }}" class="flex items-center px-4 py-3 rounded-lg text-base font-medium text-gray-700 dark:text-gray-300 hover:text-blue-600 hover:bg-blue-50 transition-colors duration-200">
                        <i class="fas fa-briefcase mr-3 text-yellow-500"></i>
                        Empleos
                    </a>
                    
                    <a href="#contact" class="flex items-center px-4 py-3 rounded-lg text-base font-medium text-gray-700 dark:text-gray-300 hover:text-blue-600 hover:bg-blue-50 transition-colors duration-200">
                        <i class="fas fa-envelope mr-3 text-red-500"></i>
                        Contacto
                    </a>
                    
                    @guest
                    <div class="pt-4 border-t border-gray-200 dark:border-gray-700 space-y-3">
                        <!-- Demo Button -->
                        <a href="#" class="flex items-center px-4 py-3 rounded-lg text-base font-medium text-purple-600 hover:bg-purple-50 transition-colors duration-200">
                            <i class="fas fa-play mr-3 text-purple-500"></i>
                            Ver Demo
                        </a>
                        
                        <!-- Login Button -->
                        <a href="{{ route('login') }}" class="flex items-center justify-center px-4 py-3 rounded-xl text-center font-semibold text-white bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 transition-all duration-200 shadow-lg">
                            <i class="fas fa-sign-in-alt mr-2"></i>
                            Iniciar Sesión
                        </a>
                    </div>
                    @endguest
                </div>
            </div>
        </div>
    </nav>

    <!-- Page Content -->
    <main class="@yield('main-classes', 'min-h-screen pt-20')">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gradient-to-br from-gray-900 to-gray-800 dark:from-gray-900 dark:to-black text-white relative overflow-hidden">
        <!-- Background elements -->
        <div class="absolute inset-0 overflow-hidden">
            <div class="absolute -top-24 -right-24 w-96 h-96 bg-blue-500/10 rounded-full blur-3xl"></div>
            <div class="absolute -bottom-24 -left-24 w-96 h-96 bg-purple-500/10 rounded-full blur-3xl"></div>
        </div>
        
        <div class="max-w-7xl mx-auto py-16 px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12">
                <!-- Company Info -->
                <div class="md:col-span-2 space-y-6">
                    <div class="flex items-center">
                        <img src="{{ asset('images/tsg.png') }}" alt="TS Group Logo" class="h-12 w-auto mr-4">
                        <div>
                            <h3 class="text-2xl font-bold bg-gradient-to-r from-blue-400 to-purple-400 bg-clip-text text-transparent">TS Group</h3>
                            <p class="text-gray-400 text-sm">Plataforma SaaS de RRHH</p>
                        </div>
                    </div>
                    <p class="text-gray-300 leading-relaxed max-w-md">
                        Transformamos la gestión de recursos humanos con tecnología de vanguardia. 
                        Más de 500 empresas confían en nuestra plataforma para potenciar su capital humano.
                    </p>
                    <div class="flex space-x-4">
                        <a href="#" class="w-10 h-10 rounded-full bg-white/10 hover:bg-blue-600 flex items-center justify-center transition-all duration-200 hover:scale-110">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                        <a href="#" class="w-10 h-10 rounded-full bg-white/10 hover:bg-blue-400 flex items-center justify-center transition-all duration-200 hover:scale-110">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" class="w-10 h-10 rounded-full bg-white/10 hover:bg-blue-800 flex items-center justify-center transition-all duration-200 hover:scale-110">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="w-10 h-10 rounded-full bg-white/10 hover:bg-red-600 flex items-center justify-center transition-all duration-200 hover:scale-110">
                            <i class="fab fa-youtube"></i>
                        </a>
                    </div>
                </div>

                <!-- Soluciones -->
                <div class="space-y-6">
                    <h4 class="text-lg font-semibold text-white border-b border-blue-500/30 pb-2">Soluciones</h4>
                    <ul class="space-y-3">
                        <li>
                            <a href="#" class="text-gray-300 hover:text-blue-400 transition-colors duration-200 flex items-center group">
                                <i class="fas fa-user-plus text-blue-500 mr-2 group-hover:scale-110 transition-transform duration-200"></i>
                                Reclutamiento
                            </a>
                        </li>
                        <li>
                            <a href="#" class="text-gray-300 hover:text-purple-400 transition-colors duration-200 flex items-center group">
                                <i class="fas fa-folder-open text-purple-500 mr-2 group-hover:scale-110 transition-transform duration-200"></i>
                                Legajos Digitales
                            </a>
                        </li>
                        <li>
                            <a href="#" class="text-gray-300 hover:text-green-400 transition-colors duration-200 flex items-center group">
                                <i class="fas fa-chart-line text-green-500 mr-2 group-hover:scale-110 transition-transform duration-200"></i>
                                Evaluaciones
                            </a>
                        </li>
                        <li>
                            <a href="#" class="text-gray-300 hover:text-yellow-400 transition-colors duration-200 flex items-center group">
                                <i class="fas fa-money-check-alt text-yellow-500 mr-2 group-hover:scale-110 transition-transform duration-200"></i>
                                Nómina
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('public.job-postings.index') }}" class="text-gray-300 hover:text-indigo-400 transition-colors duration-200 flex items-center group">
                                <i class="fas fa-briefcase text-indigo-500 mr-2 group-hover:scale-110 transition-transform duration-200"></i>
                                Portal de Empleos
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Empresa -->
                <div class="space-y-6">
                    <h4 class="text-lg font-semibold text-white border-b border-blue-500/30 pb-2">Empresa</h4>
                    <ul class="space-y-3">
                        <li>
                            <a href="#" class="text-gray-300 hover:text-blue-400 transition-colors duration-200 flex items-center group">
                                <i class="fas fa-info-circle text-blue-500 mr-2 group-hover:scale-110 transition-transform duration-200"></i>
                                Sobre nosotros
                            </a>
                        </li>
                        <li>
                            <a href="#pricing" class="text-gray-300 hover:text-green-400 transition-colors duration-200 flex items-center group">
                                <i class="fas fa-tags text-green-500 mr-2 group-hover:scale-110 transition-transform duration-200"></i>
                                Precios
                            </a>
                        </li>
                        <li>
                            <a href="#" class="text-gray-300 hover:text-purple-400 transition-colors duration-200 flex items-center group">
                                <i class="fas fa-shield-alt text-purple-500 mr-2 group-hover:scale-110 transition-transform duration-200"></i>
                                Seguridad
                            </a>
                        </li>
                        <li>
                            <a href="#" class="text-gray-300 hover:text-yellow-400 transition-colors duration-200 flex items-center group">
                                <i class="fas fa-book text-yellow-500 mr-2 group-hover:scale-110 transition-transform duration-200"></i>
                                Documentación
                            </a>
                        </li>
                        <li>
                            <a href="#contact" class="text-gray-300 hover:text-indigo-400 transition-colors duration-200 flex items-center group">
                                <i class="fas fa-headset text-indigo-500 mr-2 group-hover:scale-110 transition-transform duration-200"></i>
                                Soporte
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            
            <!-- Newsletter & Contact -->
            <div class="mt-16 pt-8 border-t border-gray-700/50">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Newsletter -->
                    <div class="space-y-4">
                        <h4 class="text-lg font-semibold text-white flex items-center">
                            <i class="fas fa-paper-plane text-blue-500 mr-2"></i>
                            Mantente actualizado
                        </h4>
                        <p class="text-gray-300 text-sm">Recibe las últimas noticias y actualizaciones de nuestra plataforma.</p>
                        <form class="flex space-x-2">
                            <input type="email" placeholder="tu@email.com" class="flex-1 px-4 py-2 bg-white/10 border border-white/20 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <button type="submit" class="px-6 py-2 bg-gradient-to-r from-blue-600 to-purple-600 text-white rounded-lg hover:from-blue-700 hover:to-purple-700 transition-all duration-200 transform hover:scale-105">
                                <i class="fas fa-arrow-right"></i>
                            </button>
                        </form>
                    </div>
                    
                    <!-- Contact Info -->
                    <div class="space-y-4">
                        <h4 class="text-lg font-semibold text-white flex items-center">
                            <i class="fas fa-map-marker-alt text-blue-500 mr-2"></i>
                            Contacto
                        </h4>
                        <div class="space-y-2 text-sm">
                            <p class="text-gray-300 flex items-center">
                                <i class="fas fa-envelope text-blue-400 mr-3"></i>
                                contacto@tsgroup.com.ar
                            </p>
                            <p class="text-gray-300 flex items-center">
                                <i class="fas fa-phone text-green-400 mr-3"></i>
                                +54 (11) 1234-5678
                            </p>
                            <p class="text-gray-300 flex items-center">
                                <i class="fas fa-clock text-purple-400 mr-3"></i>
                                Lun - Vie: 9:00 - 18:00 HS
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bottom bar -->
            <div class="mt-12 pt-8 border-t border-gray-700/50 flex flex-col md:flex-row justify-between items-center">
                <p class="text-gray-400 text-sm">
                    &copy; {{ date('Y') }} TS Group. Todos los derechos reservados.
                </p>
                <div class="flex space-x-6 mt-4 md:mt-0">
                    <a href="#" class="text-gray-400 hover:text-white text-sm transition-colors duration-200">Términos de Uso</a>
                    <a href="#" class="text-gray-400 hover:text-white text-sm transition-colors duration-200">Política de Privacidad</a>
                    <a href="#" class="text-gray-400 hover:text-white text-sm transition-colors duration-200">Cookies</a>
                </div>
            </div>
        </div>
    </footer>

    @auth
    <script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('publicCompanySwitcher', () => ({
            open:false, loaded:false, companies:[], currentCompany:null,
            async init(){ await this.refresh(); },
            async refresh(){
                try {
                    const [cur, mine] = await Promise.all([
                        axios.get('/api/company/current'),
                        axios.get('/api/companies/mine')
                    ]);
                    this.currentCompany = cur.data.data;
                    this.companies = mine.data.data || [];
                    this.loaded = true;
                } catch(e){ console.error(e); }
            },
            async switchTo(id){
                if(this.currentCompany && id===this.currentCompany.id){ this.open=false; return; }
                try { await axios.post('/api/company/switch',{company_id:id}); await this.refresh(); this.open=false; window.location.reload(); }
                catch(e){ alert('No se pudo cambiar'); }
            }
        }))
    });
    </script>
    @endauth

    <!-- AOS JS -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            AOS.init({
                duration: 800,
                easing: 'ease-in-out',
                once: true,
                mirror: false
            });
        });
    </script>
    
    @stack('scripts')
</body>
</html> 