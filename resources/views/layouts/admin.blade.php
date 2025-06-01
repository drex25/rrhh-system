<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'TSGroup') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/css/tom-select.css" rel="stylesheet">
    <style>
    .input-pro, .form-input-pro, select, textarea {
        border: 1.5px solid #e5e7eb;
        border-radius: 0.75rem;
        background: #f8fafc;
        padding: 0.85rem 1.2rem;
        font-size: 1.08rem;
        color: #374151;
        transition: border-color 0.2s, box-shadow 0.2s;
        box-shadow: 0 1px 4px 0 rgba(99,102,241,0.04);
        outline: none;
    }
    .input-pro:focus, .form-input-pro:focus, select:focus, textarea:focus {
        border-color: #6366f1;
        box-shadow: 0 0 0 3px #6366f133;
        background: #fff;
    }
    .input-pro[readonly], .form-input-pro[readonly] {
        background: #f1f5f9;
        color: #a1a1aa;
    }
    .error-message {
        color: #ef4444;
        font-size: 0.95rem;
        margin-top: 0.2rem;
        display: block;
    }
    </style>
</head>

<body class="bg-gray-50 min-h-screen font-sans antialiased" x-data="{ darkMode: localStorage.getItem('darkMode') === 'true', userMenu: false, showPasswordModal: false, redirecting: false, sidebarCollapsed: localStorage.getItem('sidebarCollapsed') === 'true' }" :class="{ 'dark': darkMode }"
    x-init="$watch('darkMode', val => localStorage.setItem('darkMode', val));
    $watch('sidebarCollapsed', val => localStorage.setItem('sidebarCollapsed', val));
    @if(Auth::user()->force_password_change && !request()->is('password/change'))
    showPasswordModal = true;
    @endif">
    @if (Auth::user()->force_password_change && !request()->is('password/change'))
        <!-- Modal de Cambio de Contraseña -->
        <div x-show="showPasswordModal" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title"
            role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div x-show="showPasswordModal" x-transition:enter="ease-out duration-300"
                    x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                    x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0"
                    class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <div x-show="showPasswordModal" x-transition:enter="ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                    x-transition:leave="ease-in duration-200"
                    x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                    x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <form action="{{ route('password.change') }}" method="POST" class="p-6"
                        @submit="redirecting = true">
                        @csrf
                        <div>
                            <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white" id="modal-title">
                                Cambio de Contraseña Requerido
                            </h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500 dark:text-gray-400">
                                    Por seguridad, debes cambiar tu contraseña antes de continuar.
                                </p>
                            </div>
                        </div>

                        <div class="mt-4 space-y-4">
                            <div>
                                <label for="current_password"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Contraseña Actual
                                </label>
                                <input type="password" name="current_password" id="current_password" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            </div>

                            <div>
                                <label for="password"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Nueva Contraseña
                                </label>
                                <input type="password" name="password" id="password" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            </div>

                            <div>
                                <label for="password_confirmation"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Confirmar Nueva Contraseña
                                </label>
                                <input type="password" name="password_confirmation" id="password_confirmation" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            </div>
                        </div>

                        @if ($errors->any())
                            <div
                                class="mt-4 bg-red-50 dark:bg-red-900/50 border border-red-200 dark:border-red-800 rounded-md p-4">
                                <ul class="text-sm text-red-600 dark:text-red-400">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="mt-6">
                            <button type="submit"
                                class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:text-sm"
                                :disabled="redirecting">
                                <span x-show="!redirecting">Cambiar Contraseña</span>
                                <span x-show="redirecting" class="flex items-center">
                                    <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white"
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10"
                                            stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor"
                                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                        </path>
                                    </svg>
                                    Procesando...
                                </span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
    <!-- Sidebar SIEMPRE visible y fijo -->
    <aside class="fixed z-30 inset-y-0 left-0 transition-all duration-300 ease-in-out"
        :class="sidebarCollapsed ? 'w-20' : 'w-72'" x-init="$watch('sidebarCollapsed', val => localStorage.setItem('sidebarCollapsed', val))">
        <div class="bg-white dark:bg-gray-900 shadow-xl flex-col flex h-screen">
            <div class="flex items-center justify-center h-20 border-b dark:border-gray-800">
                <img src="https://cdn-icons-png.flaticon.com/512/3135/3135715.png" alt="TSGroup Logo" class="w-12 h-12">
                <span class="ml-2 text-2xl font-extrabold text-blue-700 dark:text-white tracking-tight"
                    x-show="!sidebarCollapsed">TSGroup</span>
            </div>
            <nav class="flex-1 px-6 py-8 space-y-2">
                <!-- Dashboard -->
                <a href="/dashboard"
                    class="flex items-center rounded-lg font-semibold transition-all duration-200 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-400 group {{ request()->is('dashboard') ? 'bg-blue-100 text-blue-700 dark:bg-blue-800 dark:text-white shadow' : 'text-gray-700 dark:text-gray-200 hover:bg-blue-50 hover:text-blue-700 dark:hover:bg-gray-800' }}"
                    :class="sidebarCollapsed ? 'justify-center px-0 py-2' : 'gap-3 px-4 py-2'" x-data="{ tooltip: false }"
                    @mouseenter="if(sidebarCollapsed) tooltip = true" @mouseleave="tooltip = false">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3 12l2-2m0 0l7-7 7 7M13 5v6h6m-6 0v6m0 0H7m6 0h6" />
                    </svg>
                    <span x-show="!sidebarCollapsed">Dashboard</span>
                    <span x-show="tooltip"
                        class="absolute left-full ml-2 px-2 py-1 rounded bg-gray-900 text-white text-xs z-50"
                        x-cloak>Dashboard</span>
                </a>
                @role('Admin')
                    <div class="mt-6 mb-2 text-xs text-gray-400 dark:text-gray-500 uppercase pl-2"
                        x-show="!sidebarCollapsed">Gestión</div>
                    <!-- Empleados -->
                    <a href="{{ route('employees.index') }}"
                        class="flex items-center rounded-lg transition-all duration-200 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-400 group {{ request()->is('employees*') ? 'bg-blue-100 text-blue-700 dark:bg-blue-800 dark:text-white shadow' : 'text-gray-700 dark:text-gray-200 hover:bg-blue-50 hover:text-blue-700 dark:hover:bg-gray-800' }}"
                        :class="sidebarCollapsed ? 'justify-center px-0 py-2' : 'gap-3 px-4 py-2'" x-data="{ tooltip: false }"
                        @mouseenter="if(sidebarCollapsed) tooltip = true" @mouseleave="tooltip = false">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87m9-5a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                        <span x-show="!sidebarCollapsed">Empleados</span>
                        <span x-show="tooltip"
                            class="absolute left-full ml-2 px-2 py-1 rounded bg-gray-900 text-white text-xs z-50"
                            x-cloak>Empleados</span>
                    </a>
                    <!-- Departamentos -->
                    <a href="{{ route('departments.index') }}"
                        class="flex items-center rounded-lg transition-all duration-200 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-400 group {{ request()->is('departments*') ? 'bg-blue-100 text-blue-700 dark:bg-blue-800 dark:text-white shadow' : 'text-gray-700 dark:text-gray-200 hover:bg-blue-50 hover:text-blue-700 dark:hover:bg-gray-800' }}"
                        :class="sidebarCollapsed ? 'justify-center px-0 py-2' : 'gap-3 px-4 py-2'" x-data="{ tooltip: false }"
                        @mouseenter="if(sidebarCollapsed) tooltip = true" @mouseleave="tooltip = false">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3 7v4a1 1 0 001 1h3m10-5h3a1 1 0 011 1v4a1 1 0 01-1 1h-3m-10 4h10" />
                        </svg>
                        <span x-show="!sidebarCollapsed">Departamentos</span>
                        <span x-show="tooltip"
                            class="absolute left-full ml-2 px-2 py-1 rounded bg-gray-900 text-white text-xs z-50"
                            x-cloak>Departamentos</span>
                    </a>
                    <!-- Puestos -->
                    <a href="{{ route('positions.index') }}"
                        class="flex items-center rounded-lg transition-all duration-200 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-400 group {{ request()->is('positions*') ? 'bg-blue-100 text-blue-700 dark:bg-blue-800 dark:text-white shadow' : 'text-gray-700 dark:text-gray-200 hover:bg-blue-50 hover:text-blue-700 dark:hover:bg-gray-800' }}"
                        :class="sidebarCollapsed ? 'justify-center px-0 py-2' : 'gap-3 px-4 py-2'" x-data="{ tooltip: false }"
                        @mouseenter="if(sidebarCollapsed) tooltip = true" @mouseleave="tooltip = false">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M9 17v-2a4 4 0 014-4h3m4 0V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2h7" />
                        </svg>
                        <span x-show="!sidebarCollapsed">Puestos</span>
                        <span x-show="tooltip"
                            class="absolute left-full ml-2 px-2 py-1 rounded bg-gray-900 text-white text-xs z-50"
                            x-cloak>Puestos</span>
                    </a>
                @endrole
                @role('HR')
                    <div class="mt-6 mb-2 text-xs text-gray-400 dark:text-gray-500 uppercase pl-2"
                        x-show="!sidebarCollapsed">Gestión</div>
                    <a href="{{ route('employees.index') }}"
                        class="flex items-center gap-3 px-4 py-2 rounded-lg transition-all duration-200 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-400 group {{ request()->is('employees*') ? 'bg-blue-100 text-blue-700 dark:bg-blue-800 dark:text-white shadow' : 'text-gray-700 dark:text-gray-200 hover:bg-blue-50 hover:text-blue-700 dark:hover:bg-gray-800' }}">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87m9-5a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                        <span x-show="!sidebarCollapsed">Empleados</span>
                    </a>
                    <a href="{{ route('departments.index') }}"
                        class="flex items-center gap-3 px-4 py-2 rounded-lg transition-all duration-200 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-400 group {{ request()->is('departments*') ? 'bg-blue-100 text-blue-700 dark:bg-blue-800 dark:text-white shadow' : 'text-gray-700 dark:text-gray-200 hover:bg-blue-50 hover:text-blue-700 dark:hover:bg-gray-800' }}">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3 7v4a1 1 0 001 1h3m10-5h3a1 1 0 011 1v4a1 1 0 01-1 1h-3m-10 4h10" />
                        </svg>
                        <span x-show="!sidebarCollapsed">Departamentos</span>
                    </a>
                    <a href="{{ route('positions.index') }}"
                        class="flex items-center gap-3 px-4 py-2 rounded-lg transition-all duration-200 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-400 group {{ request()->is('positions*') ? 'bg-blue-100 text-blue-700 dark:bg-blue-800 dark:text-white shadow' : 'text-gray-700 dark:text-gray-200 hover:bg-blue-50 hover:text-blue-700 dark:hover:bg-gray-800' }}">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M9 17v-2a4 4 0 014-4h3m4 0V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2h7" />
                        </svg>
                        <span x-show="!sidebarCollapsed">Puestos</span>
                    </a>
                @endrole
                @role('Admin')
                    <div class="mt-6 mb-2 text-xs text-gray-400 dark:text-gray-500 uppercase pl-2"
                        x-show="!sidebarCollapsed">Recibos</div>
                    <a href="{{ route('payslips.index') }}"
                        class="flex items-center rounded-lg transition-all duration-200 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-400 group {{ request()->is('payslips*') ? 'bg-blue-100 text-blue-700 dark:bg-blue-800 dark:text-white shadow' : 'text-gray-700 dark:text-gray-200 hover:bg-blue-50 hover:text-blue-700 dark:hover:bg-gray-800' }}"
                        :class="sidebarCollapsed ? 'justify-center px-0 py-2' : 'gap-3 px-4 py-2'" x-data="{ tooltip: false }"
                        @mouseenter="if(sidebarCollapsed) tooltip = true" @mouseleave="tooltip = false">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M9 17v-2a4 4 0 014-4h3m4 0V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2h7" />
                        </svg>
                        <span x-show="!sidebarCollapsed">Recibos</span>
                        <span x-show="tooltip"
                            class="absolute left-full ml-2 px-2 py-1 rounded bg-gray-900 text-white text-xs z-50"
                            x-cloak>Recibos</span>
                    </a>
                @endrole
                @role('HR')
                    <div class="mt-6 mb-2 text-xs text-gray-400 dark:text-gray-500 uppercase pl-2"
                        x-show="!sidebarCollapsed">Recibos</div>
                    <a href="{{ route('payslips.index') }}"
                        class="flex items-center rounded-lg transition-all duration-200 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-400 group {{ request()->is('payslips*') ? 'bg-blue-100 text-blue-700 dark:bg-blue-800 dark:text-white shadow' : 'text-gray-700 dark:text-gray-200 hover:bg-blue-50 hover:text-blue-700 dark:hover:bg-gray-800' }}"
                        :class="sidebarCollapsed ? 'justify-center px-0 py-2' : 'gap-3 px-4 py-2'" x-data="{ tooltip: false }"
                        @mouseenter="if(sidebarCollapsed) tooltip = true" @mouseleave="tooltip = false">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M9 17v-2a4 4 0 014-4h3m4 0V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2h7" />
                        </svg>
                        <span x-show="!sidebarCollapsed">Recibos</span>
                        <span x-show="tooltip"
                            class="absolute left-full ml-2 px-2 py-1 rounded bg-gray-900 text-white text-xs z-50"
                            x-cloak>Recibos</span>
                    </a>
                @endrole
                @role('Employee')
                    <div class="mt-6 mb-2 text-xs text-gray-400 dark:text-gray-500 uppercase pl-2"
                        x-show="!sidebarCollapsed">Recibos</div>
                    <a href="{{ route('employee.payslips.index') }}"
                        class="flex items-center rounded-lg transition-all duration-200 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-400 group {{ request()->is('my-payslips*') ? 'bg-blue-100 text-blue-700 dark:bg-blue-800 dark:text-white shadow' : 'text-gray-700 dark:text-gray-200 hover:bg-blue-50 hover:text-blue-700 dark:hover:bg-gray-800' }}"
                        :class="sidebarCollapsed ? 'justify-center px-0 py-2' : 'gap-3 px-4 py-2'" x-data="{ tooltip: false }"
                        @mouseenter="if(sidebarCollapsed) tooltip = true" @mouseleave="tooltip = false">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M9 17v-2a4 4 0 014-4h3m4 0V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2h7" />
                        </svg>
                        <span x-show="!sidebarCollapsed">Mis Recibos</span>
                        <span x-show="tooltip"
                            class="absolute left-full ml-2 px-2 py-1 rounded bg-gray-900 text-white text-xs z-50"
                            x-cloak>Mis Recibos</span>
                    </a>
                @endrole
                @role('Admin')
                    <div class="mt-6 mb-2 text-xs text-gray-400 dark:text-gray-500 uppercase pl-2"
                        x-show="!sidebarCollapsed">Licencias</div>
                    <a href="{{ route('leave-requests.index') }}"
                        class="flex items-center rounded-lg transition-all duration-200 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-400 group {{ request()->is('leave-requests*') ? 'bg-blue-100 text-blue-700 dark:bg-blue-800 dark:text-white shadow' : 'text-gray-700 dark:text-gray-200 hover:bg-blue-50 hover:text-blue-700 dark:hover:bg-gray-800' }}"
                        :class="sidebarCollapsed ? 'justify-center px-0 py-2' : 'gap-3 px-4 py-2'" x-data="{ tooltip: false }"
                        @mouseenter="if(sidebarCollapsed) tooltip = true" @mouseleave="tooltip = false">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M8 17l4 4 4-4m0-5V3a1 1 0 00-1-1H7a1 1 0 00-1 1v9m12 4h-4a2 2 0 01-2-2V7a2 2 0 012-2h4a2 2 0 012 2v8a2 2 0 01-2 2z" />
                        </svg>
                        <span x-show="!sidebarCollapsed">Licencias</span>
                        <span x-show="tooltip"
                            class="absolute left-full ml-2 px-2 py-1 rounded bg-gray-900 text-white text-xs z-50"
                            x-cloak>Licencias</span>
                    </a>
                    <a href="{{ route('leave-types.index') }}"
                        class="flex items-center rounded-lg transition-all duration-200 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-400 group {{ request()->is('leave-types*') ? 'bg-blue-100 text-blue-700 dark:bg-blue-800 dark:text-white shadow' : 'text-gray-700 dark:text-gray-200 hover:bg-blue-50 hover:text-blue-700 dark:hover:bg-gray-800' }}"
                        :class="sidebarCollapsed ? 'justify-center px-0 py-2' : 'gap-3 px-4 py-2'" x-data="{ tooltip: false }"
                        @mouseenter="if(sidebarCollapsed) tooltip = true" @mouseleave="tooltip = false">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                        <span x-show="!sidebarCollapsed">Tipos de Licencia</span>
                        <span x-show="tooltip"
                            class="absolute left-full ml-2 px-2 py-1 rounded bg-gray-900 text-white text-xs z-50"
                            x-cloak>Tipos de Licencia</span>
                    </a>
                @endrole
                @role('HR')
                    <div class="mt-6 mb-2 text-xs text-gray-400 dark:text-gray-500 uppercase pl-2"
                        x-show="!sidebarCollapsed">Licencias</div>
                    <a href="{{ route('leave-requests.index') }}"
                        class="flex items-center rounded-lg transition-all duration-200 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-400 group {{ request()->is('leave-requests*') ? 'bg-blue-100 text-blue-700 dark:bg-blue-800 dark:text-white shadow' : 'text-gray-700 dark:text-gray-200 hover:bg-blue-50 hover:text-blue-700 dark:hover:bg-gray-800' }}"
                        :class="sidebarCollapsed ? 'justify-center px-0 py-2' : 'gap-3 px-4 py-2'" x-data="{ tooltip: false }"
                        @mouseenter="if(sidebarCollapsed) tooltip = true" @mouseleave="tooltip = false">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M8 17l4 4 4-4m0-5V3a1 1 0 00-1-1H7a1 1 0 00-1 1v9m12 4h-4a2 2 0 01-2-2V7a2 2 0 012-2h4a2 2 0 012 2v8a2 2 0 01-2 2z" />
                        </svg>
                        <span x-show="!sidebarCollapsed">Licencias</span>
                    </a>
                    <a href="{{ route('leave-types.index') }}"
                        class="flex items-center rounded-lg transition-all duration-200 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-400 group {{ request()->is('leave-types*') ? 'bg-blue-100 text-blue-700 dark:bg-blue-800 dark:text-white shadow' : 'text-gray-700 dark:text-gray-200 hover:bg-blue-50 hover:text-blue-700 dark:hover:bg-gray-800' }}"
                        :class="sidebarCollapsed ? 'justify-center px-0 py-2' : 'gap-3 px-4 py-2'" x-data="{ tooltip: false }"
                        @mouseenter="if(sidebarCollapsed) tooltip = true" @mouseleave="tooltip = false">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                        <span x-show="!sidebarCollapsed">Tipos de Licencia</span>
                    </a>
                @endrole
                @role('Manager')
                    <div class="mt-6 mb-2 text-xs text-gray-400 dark:text-gray-500 uppercase pl-2"
                        x-show="!sidebarCollapsed">Licencias</div>
                    <a href="{{ route('leave-requests.index') }}"
                        class="flex items-center rounded-lg transition-all duration-200 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-400 group {{ request()->is('leave-requests*') ? 'bg-blue-100 text-blue-700 dark:bg-blue-800 dark:text-white shadow' : 'text-gray-700 dark:text-gray-200 hover:bg-blue-50 hover:text-blue-700 dark:hover:bg-gray-800' }}"
                        :class="sidebarCollapsed ? 'justify-center px-0 py-2' : 'gap-3 px-4 py-2'" x-data="{ tooltip: false }"
                        @mouseenter="if(sidebarCollapsed) tooltip = true" @mouseleave="tooltip = false">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M8 17l4 4 4-4m0-5V3a1 1 0 00-1-1H7a1 1 0 00-1 1v9m12 4h-4a2 2 0 01-2-2V7a2 2 0 012-2h4a2 2 0 012 2v8a2 2 0 01-2 2z" />
                        </svg>
                        <span x-show="!sidebarCollapsed">Licencias</span>
                    </a>
                @endrole
                @role('Employee')
                    <div class="mt-6 mb-2 text-xs text-gray-400 dark:text-gray-500 uppercase pl-2"
                        x-show="!sidebarCollapsed">Licencias</div>
                    <a href="{{ route('leave-requests.index') }}"
                        class="flex items-center rounded-lg transition-all duration-200 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-400 group {{ request()->is('leave-requests*') ? 'bg-blue-100 text-blue-700 dark:bg-blue-800 dark:text-white shadow' : 'text-gray-700 dark:text-gray-200 hover:bg-blue-50 hover:text-blue-700 dark:hover:bg-gray-800' }}"
                        :class="sidebarCollapsed ? 'justify-center px-0 py-2' : 'gap-3 px-4 py-2'"
                        x-data="{ tooltip: false }" @mouseenter="if(sidebarCollapsed) tooltip = true"
                        @mouseleave="tooltip = false">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M8 17l4 4 4-4m0-5V3a1 1 0 00-1-1H7a1 1 0 00-1 1v9m12 4h-4a2 2 0 01-2-2V7a2 2 0 012-2h4a2 2 0 012 2v8a2 2 0 01-2 2z" />
                        </svg>
                        <span x-show="!sidebarCollapsed">Licencias</span>
                    </a>
                @endrole
                <div class="mt-6 mb-2 text-xs text-gray-400 dark:text-gray-500 uppercase pl-2"
                    x-show="!sidebarCollapsed">Usuario</div>
                <a href="#"
                    class="flex items-center rounded-lg transition-all duration-200 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-400 group text-gray-700 dark:text-gray-200 hover:bg-blue-50 hover:text-blue-700 dark:hover:bg-gray-800"
                    :class="sidebarCollapsed ? 'justify-center px-0 py-2' : 'gap-3 px-4 py-2'"
                    x-data="{ tooltip: false }" @mouseenter="if(sidebarCollapsed) tooltip = true"
                    @mouseleave="tooltip = false">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M5.121 17.804A13.937 13.937 0 0112 15c2.5 0 4.847.655 6.879 1.804M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <span x-show="!sidebarCollapsed">Perfil</span>
                </a>
                @role('Admin')
                    <div class="mt-6 mb-2 text-xs text-gray-400 dark:text-gray-500 uppercase pl-2"
                        x-show="!sidebarCollapsed">Admin</div>
                    <a href="#"
                        class="flex items-center rounded-lg transition-all duration-200 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-400 group text-gray-700 dark:text-gray-200 hover:bg-blue-50 hover:text-blue-700 dark:hover:bg-gray-800"
                        :class="sidebarCollapsed ? 'justify-center px-0 py-2' : 'gap-3 px-4 py-2'"
                        x-data="{ tooltip: false }" @mouseenter="if(sidebarCollapsed) tooltip = true"
                        @mouseleave="tooltip = false">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 8v4l3 3m6 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span x-show="!sidebarCollapsed">Configuración</span>
                    </a>
                    <a href="#"
                        class="flex items-center rounded-lg transition-all duration-200 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-400 group text-gray-700 dark:text-gray-200 hover:bg-blue-50 hover:text-blue-700 dark:hover:bg-gray-800"
                        :class="sidebarCollapsed ? 'justify-center px-0 py-2' : 'gap-3 px-4 py-2'"
                        x-data="{ tooltip: false }" @mouseenter="if(sidebarCollapsed) tooltip = true"
                        @mouseleave="tooltip = false">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3 7v4a1 1 0 001 1h3m10-5h3a1 1 0 011 1v4a1 1 0 01-1 1h-3m-10 4h10" />
                        </svg>
                        <span x-show="!sidebarCollapsed">Auditoría</span>
                    </a>
                @endrole
            </nav>
        </div>
    </aside>
    <!-- Contenido principal con margen izquierdo -->
    <div class="flex flex-col min-h-screen transition-all duration-300 ease-in-out"
        :class="sidebarCollapsed ? 'ml-20' : 'ml-72'">
        <!-- Topbar -->
        <header
            class="bg-white dark:bg-gray-900 shadow-md border-b border-gray-100 dark:border-gray-800 flex items-center justify-between px-8 h-20 sticky top-0 z-20 w-full transition-all">
            <div class="flex items-center gap-4">
                <button @click="sidebarCollapsed = !sidebarCollapsed"
                    class="p-2 rounded-full text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-400"
                    aria-label="Colapsar sidebar">
                    <svg x-show="!sidebarCollapsed" class="w-6 h-6" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 19l-7-7 7-7m8 14l-7-7 7-7"></path>
                    </svg>
                    <svg x-show="sidebarCollapsed" class="w-6 h-6" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 5l7 7-7 7M5 5l7 7-7 7"></path>
                    </svg>
                </button>
                <span class="text-xl font-semibold text-blue-700 dark:text-white">Panel de Administración</span>
            </div>
            <div class="flex items-center gap-4">
                <!-- Search -->
                <div class="relative hidden md:block">
                    <input type="text" placeholder="Buscar..."
                        class="pl-10 pr-4 py-2 rounded-lg bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-400 transition w-64" />
                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <circle cx="11" cy="11" r="8" />
                            <path d="M21 21l-4.35-4.35" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </span>
                </div>
                <!-- Help -->
                <button
                    class="p-2 rounded-full text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-400 relative group"
                    aria-label="Ayuda">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M8 10a4 4 0 118 0c0 2-2 3-2 3m-2 4h.01" />
                    </svg>
                    <span
                        class="absolute left-1/2 -translate-x-1/2 mt-2 px-2 py-1 rounded bg-gray-900 text-white text-xs z-50 opacity-0 group-hover:opacity-100 transition pointer-events-none">Ayuda</span>
                </button>
                <!-- Notifications -->
                <button
                    class="p-2 rounded-full text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-400 relative"
                    aria-label="Notificaciones">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                    </svg>
                    <span
                        class="absolute top-1 right-1 w-2.5 h-2.5 bg-red-500 rounded-full border-2 border-white"></span>
                </button>
                <!-- Dark Mode Toggle -->
                <button @click="darkMode = !darkMode"
                    class="p-2 rounded-full text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-400"
                    aria-label="Cambiar modo oscuro">
                    <svg x-show="!darkMode" class="w-6 h-6" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z">
                        </path>
                    </svg>
                    <svg x-show="darkMode" class="w-6 h-6" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z">
                        </path>
                    </svg>
                </button>
                <!-- User Dropdown Mejorado -->
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open"
                        class="flex items-center space-x-2 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-400 transition">
                        @if (Auth::user()->profile_photo_url ?? false)
                            <img class="h-10 w-10 rounded-full object-cover border-2 border-blue-400 shadow"
                                src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}">
                        @else
                            <span
                                class="inline-flex items-center justify-center h-10 w-10 rounded-full bg-blue-600 text-white font-bold border-2 border-blue-400 shadow">
                                {{ strtoupper(Str::substr(Auth::user()->name, 0, 2)) }}
                            </span>
                        @endif
                        <span
                            class="hidden md:block text-sm font-medium text-gray-700 dark:text-gray-200">{{ Auth::user()->name }}</span>
                        <svg class="w-4 h-4 ml-1 text-gray-400 transition-transform duration-200"
                            :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="open" @click.away="open = false"
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-75"
                        x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                        class="absolute right-0 mt-2 w-56 rounded-md shadow-lg bg-white dark:bg-gray-800 ring-1 ring-black ring-opacity-5 z-50 transition-all duration-200 origin-top-right">
                        <div class="py-1">
                            <a href="#"
                                class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-blue-50 dark:hover:bg-gray-700 transition">Perfil</a>
                            <a href="#"
                                class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-blue-50 dark:hover:bg-gray-700 transition">Configuración</a>
                            <div class="border-t border-gray-200 dark:border-gray-700 my-1"></div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                    class="block w-full text-left px-4 py-2 text-sm text-red-600 dark:text-red-400 hover:bg-blue-50 dark:hover:bg-gray-700 transition">Cerrar
                                    Sesión</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <!-- Content -->
        <main class="flex-1 p-8 overflow-y-auto" style="height:calc(100vh - 5rem)">
            @yield('content')
        </main>
    </div>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/js/tom-select.complete.min.js"></script>
    @stack('scripts')
    <script>
        // Manejo de mensajes flash con SweetAlert2
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: '¡Éxito!',
                text: '{{ session('success') }}',
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true
            });
        @endif

        @if(session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: '{{ session('error') }}',
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true
            });
        @endif
    </script>
</body>

</html>
