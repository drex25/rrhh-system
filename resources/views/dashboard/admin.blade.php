@extends('layouts.admin')

@section('content')
<!-- Header Section -->
<div class="mb-8">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between">
        <div>
            <h1 :class="darkMode ? 'text-white' : 'text-blue-900'" class="text-2xl font-bold">Panel de Control</h1>
            <p :class="darkMode ? 'text-gray-300' : 'text-gray-600'" class="mt-1 text-sm">Bienvenido a tu panel de control</p>
        </div>
        <div class="mt-4 md:mt-0 flex items-center space-x-3">
            <div class="relative">
                <button @click="showDateRangePicker = !showDateRangePicker" class="inline-flex items-center px-4 py-2 bg-[#232B3E] border border-[#232B3E] rounded-lg shadow text-sm font-medium text-gray-200 hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    Filtrar por Fecha
                </button>
                <div x-show="showDateRangePicker" @click.away="showDateRangePicker = false" class="absolute right-0 mt-2 w-80 bg-white dark:bg-[#232B3E] rounded-lg shadow-lg p-4 z-50">
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Desde</label>
                            <input type="date" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Hasta</label>
                            <input type="date" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        </div>
                        <button class="w-full bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                            Aplicar Filtro
                        </button>
                    </div>
                </div>
            </div>
            <button class="inline-flex items-center px-4 py-2 bg-[#232B3E] border border-[#232B3E] rounded-lg shadow text-sm font-medium text-gray-200 hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Generar Reporte
            </button>
            <button class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-lg shadow text-sm font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                </svg>
                Nueva Acción
            </button>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="mb-8">
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <button class="p-4 rounded-lg bg-gradient-to-br from-blue-500 to-blue-600 text-white hover:from-blue-600 hover:to-blue-700 transition-all duration-200 transform hover:scale-105">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium">Nuevo Empleado</p>
                    <p class="text-xs opacity-75">Agregar personal</p>
                </div>
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                </svg>
            </div>
        </button>
        <button class="p-4 rounded-lg bg-gradient-to-br from-green-500 to-green-600 text-white hover:from-green-600 hover:to-green-700 transition-all duration-200 transform hover:scale-105">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium">Nueva Licencia</p>
                    <p class="text-xs opacity-75">Gestionar ausencias</p>
                </div>
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>
        </button>
        <button class="p-4 rounded-lg bg-gradient-to-br from-purple-500 to-purple-600 text-white hover:from-purple-600 hover:to-purple-700 transition-all duration-200 transform hover:scale-105">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium">Generar Nómina</p>
                    <p class="text-xs opacity-75">Procesar pagos</p>
                </div>
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
        </button>
        <button class="p-4 rounded-lg bg-gradient-to-br from-yellow-500 to-yellow-600 text-white hover:from-yellow-600 hover:to-yellow-700 transition-all duration-200 transform hover:scale-105">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium">Reportes</p>
                    <p class="text-xs opacity-75">Ver estadísticas</p>
                </div>
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                </svg>
            </div>
        </button>
    </div>
</div>

<!-- Stats Grid -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Total Employees Card -->
    <div class="rounded-xl shadow p-6 hover:shadow-lg transition-all duration-300 border transform hover:scale-105" :class="darkMode ? 'bg-[#232B3E] border-[#232B3E]' : 'bg-white border-gray-200'">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-400">Total Empleados</p>
                <p class="text-2xl font-semibold text-white mt-1">{{ $totalEmployees }}</p>
            </div>
            <div class="p-3 bg-blue-800 rounded-full">
                <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87m9-5a4 4 0 11-8 0 4 4 0 018 0z"/>
                </svg>
            </div>
        </div>
        <div class="mt-4">
            <div class="flex items-center text-sm">
                <span class="text-green-400 flex items-center">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                    </svg>
                    12%
                </span>
                <span class="text-gray-400 ml-2">vs mes anterior</span>
            </div>
        </div>
    </div>

    <!-- Total Payslips Card.. -->
    <div class="rounded-xl shadow p-6 hover:shadow-lg transition-all duration-300 border transform hover:scale-105" :class="darkMode ? 'bg-[#232B3E] border-[#232B3E]' : 'bg-white border-gray-200'">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-400">Total Recibos</p>
                <p class="text-2xl font-semibold text-white mt-1">{{ $totalPayslips }}</p>
            </div>
            <div class="p-3 bg-green-800 rounded-full">
                <svg class="w-6 h-6 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2a4 4 0 014-4h3m4 0V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2h7"/>
                </svg>
            </div>
        </div>
        <div class="mt-4">
            <div class="flex items-center text-sm">
                <span class="text-green-400 flex items-center">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                    </svg>
                    8%
                </span>
                <span class="text-gray-400 ml-2">vs mes anterior</span>
            </div>
        </div>
    </div>

    <!-- Pending Leave Requests Card -->
    <div class="rounded-xl shadow p-6 hover:shadow-lg transition-all duration-300 border transform hover:scale-105" :class="darkMode ? 'bg-[#232B3E] border-[#232B3E]' : 'bg-white border-gray-200'">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-400">Licencias Pendientes</p>
                <p class="text-2xl font-semibold text-white mt-1">{{ $totalLeaveRequests }}</p>
            </div>
            <div class="p-3 bg-purple-800 rounded-full">
                <svg class="w-6 h-6 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2h7"/>
                </svg>
            </div>
        </div>
        <div class="mt-4">
            <div class="flex items-center text-sm">
                <span class="text-red-400 flex items-center">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"/>
                    </svg>
                    3%
                </span>
                <span class="text-gray-400 ml-2">vs mes anterior</span>
            </div>
        </div>
    </div>

    <!-- Total Departments Card -->
    <div class="rounded-xl shadow p-6 hover:shadow-lg transition-all duration-300 border transform hover:scale-105" :class="darkMode ? 'bg-[#232B3E] border-[#232B3E]' : 'bg-white border-gray-200'">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-400">Departamentos</p>
                <p class="text-2xl font-semibold text-white mt-1">{{ $totalDepartments }}</p>
            </div>
            <div class="p-3 bg-yellow-800 rounded-full">
                <svg class="w-6 h-6 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                </svg>
            </div>
        </div>
        <div class="mt-4">
            <div class="flex items-center text-sm">
                <span class="text-green-400 flex items-center">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                    </svg>
                    5%
                </span>
                <span class="text-gray-400 ml-2">vs mes anterior</span>
            </div>
        </div>
    </div>
</div>

<!-- Panel Uso del Plan -->
<div x-data="limitsPanel" x-cloak class="mb-10">
        <h2 class="text-lg font-semibold mb-4 flex items-center gap-2">
                <svg class="h-5 w-5 text-blue-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 3h18M3 9h18M3 15h18M3 21h18"/></svg>
                Uso del Plan
                <template x-if="plan"><span class="ml-2 text-sm px-2 py-0.5 rounded bg-blue-100 text-blue-700" x-text="plan"></span></template>
        </h2>
        <template x-if="loaded">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                        <template x-for="key in Object.keys(limits)" :key="key">
                                <div class="p-4 rounded border bg-white dark:bg-gray-800 shadow-sm">
                                        <div class="flex justify-between items-center mb-2">
                                                <span class="text-sm font-medium capitalize" x-text="key.replace('_',' ')"></span>
                                                <span class="text-xs text-gray-500" x-text="usage[key] + ' / ' + (limits[key] ?? '∞')"></span>
                                        </div>
                                        <div class="w-full h-2 bg-gray-200 dark:bg-gray-700 rounded overflow-hidden">
                                                <div class="h-2 bg-blue-500" :style="progressStyle(key)"></div>
                                        </div>
                                        <p class="mt-2 text-xs text-gray-500" x-show="remaining[key] !== null" x-text="'Restantes: ' + remaining[key]"></p>
                                </div>
                        </template>
                </div>
        </template>
        <template x-if="!loaded">
                <div class="text-sm text-gray-500">Cargando límites...</div>
        </template>
</div>

@push('scripts')
<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('limitsPanel', () => ({
        loaded:false, plan:null, limits:{}, usage:{}, remaining:{},
        async init(){
            try{ const {data}= await axios.get('/api/company/limits');
                if(data.data){
                    this.plan = data.data.plan;
                    this.limits = data.data.limits;
                    this.usage = data.data.usage;
                    this.remaining = data.data.remaining;
                }
                this.loaded = true;
            }catch(e){ console.error(e); }
        },
        progressStyle(key){
            const limit = this.limits[key];
            if(limit === null) return 'width:100%';
            const used = this.usage[key] ?? 0;
            const pct = Math.min(100, (used/limit)*100);
            return `width:${pct}%`;
        }
    }))
});
</script>
@endpush

<!-- Charts Section -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
    <!-- Employees by Department Chart -->
    <div class="rounded-xl shadow p-6 border hover:shadow-lg transition-all duration-300" :class="darkMode ? 'bg-[#232B3E] border-[#232B3E]' : 'bg-white border-gray-200'">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-white">Empleados por Departamento</h3>
            <div class="flex items-center space-x-2">
                <select class="text-sm rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-blue-500 focus:ring-blue-500">
                    <option>Último mes</option>
                    <option>Últimos 3 meses</option>
                    <option>Último año</option>
                </select>
                <button class="p-2 text-gray-400 hover:text-white">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
            </div>
        </div>
        <div class="h-80">
            <canvas id="barChart"></canvas>
        </div>
    </div>

    <!-- Leave Requests by Month Chart -->
    <div class="rounded-xl shadow p-6 border hover:shadow-lg transition-all duration-300" :class="darkMode ? 'bg-[#232B3E] border-[#232B3E]' : 'bg-white border-gray-200'">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-white">Licencias por Mes</h3>
            <div class="flex items-center space-x-2">
                <select class="text-sm rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-blue-500 focus:ring-blue-500">
                    <option>Último mes</option>
                    <option>Últimos 3 meses</option>
                    <option>Último año</option>
                </select>
                <button class="p-2 text-gray-400 hover:text-white">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
            </div>
        </div>
        <div class="h-80">
            <canvas id="pieChart"></canvas>
        </div>
    </div>
</div>

<!-- Recent Activity Section -->
<div class="rounded-xl shadow p-6 border mb-8 hover:shadow-lg transition-all duration-300" :class="darkMode ? 'bg-[#232B3E] border-[#232B3E]' : 'bg-white border-gray-200'">
    <div class="flex items-center justify-between mb-6">
        <h3 :class="darkMode ? 'text-white' : 'text-blue-900'" class="text-lg font-semibold">Actividad Reciente</h3>
        <div class="flex items-center space-x-4">
            <select class="text-sm rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-blue-500 focus:ring-blue-500">
                <option>Todas las actividades</option>
                <option>Empleados</option>
                <option>Licencias</option>
                <option>Nóminas</option>
            </select>
            <button class="text-sm text-blue-400 hover:text-blue-300">
                Ver todo
            </button>
        </div>
    </div>
    <div class="space-y-4">
        <!-- Activity Items -->
        <div class="flex items-center space-x-4 p-4 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-200">
            <div class="flex-shrink-0">
                <div class="w-10 h-10 rounded-full bg-blue-800 flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                </div>
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-sm font-medium text-white truncate">
                    Nuevo empleado registrado
                </p>
                <p class="text-sm text-gray-400">
                    Juan Pérez se unió al departamento de Desarrollo
                </p>
            </div>
            <div class="text-sm text-gray-400">
                Hace 2 horas
            </div>
        </div>

        <div class="flex items-center space-x-4 p-4 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-200">
            <div class="flex-shrink-0">
                <div class="w-10 h-10 rounded-full bg-green-800 flex items-center justify-center">
                    <svg class="w-6 h-6 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-sm font-medium text-white truncate">
                    Licencia aprobada
                </p>
                <p class="text-sm text-gray-400">
                    María García - Licencia por enfermedad
                </p>
            </div>
            <div class="text-sm text-gray-400">
                Hace 3 horas
            </div>
        </div>

        <div class="flex items-center space-x-4 p-4 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-200">
            <div class="flex-shrink-0">
                <div class="w-10 h-10 rounded-full bg-purple-800 flex items-center justify-center">
                    <svg class="w-6 h-6 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                </div>
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-sm font-medium text-white truncate">
                    Recibo generado
                </p>
                <p class="text-sm text-gray-400">
                    Recibo de nómina generado para Carlos Rodríguez
                </p>
            </div>
            <div class="text-sm text-gray-400">
                Hace 5 horas
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Detectar modo oscuro
    function isDarkMode() {
        return document.documentElement.classList.contains('dark') || localStorage.getItem('darkMode') === 'true';
    }

    // Colores adaptativos
    function chartColors() {
        return isDarkMode() ? {
            grid: '#374151',
            text: '#d1d5db',
            bg: '#1e293b',
        } : {
            grid: '#e5e7eb',
            text: '#374151',
            bg: '#fff',
        };
    }

    // Bar Chart
    function renderBarChart() {
        const ctx = document.getElementById('barChart').getContext('2d');
        const colors = chartColors();
        const departments = @json($employeesByDepartment);
        
        return new Chart(ctx, {
            type: 'bar',
            data: {
                labels: departments.map(d => d.name),
                datasets: [{
                    label: 'Empleados',
                    data: departments.map(d => d.count),
                    backgroundColor: [
                        'rgba(59,130,246,0.8)',
                        'rgba(16,185,129,0.8)',
                        'rgba(236,72,153,0.8)',
                        'rgba(251,191,36,0.8)'
                    ],
                    borderRadius: 8,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: colors.bg,
                        titleColor: colors.text,
                        bodyColor: colors.text,
                        borderColor: colors.grid,
                        borderWidth: 1,
                        padding: 12,
                        cornerRadius: 8,
                        displayColors: false,
                    }
                },
                scales: {
                    x: {
                        grid: { color: colors.grid },
                        ticks: { color: colors.text }
                    },
                    y: {
                        grid: { color: colors.grid },
                        ticks: { color: colors.text }
                    }
                },
                animation: {
                    duration: 2000,
                    easing: 'easeInOutQuart'
                }
            }
        });
    }

    // Pie Chart
    function renderPieChart() {
        const ctx = document.getElementById('pieChart').getContext('2d');
        const colors = chartColors();
        const leaveRequests = @json($leaveRequestsByMonth);
        
        return new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: leaveRequests.map(l => l.month),
                datasets: [{
                    label: 'Licencias',
                    data: leaveRequests.map(l => l.count),
                    backgroundColor: [
                        'rgba(59,130,246,0.8)',
                        'rgba(236,72,153,0.8)',
                        'rgba(251,191,36,0.8)',
                        'rgba(16,185,129,0.8)'
                    ],
                    borderWidth: 2,
                    borderColor: colors.bg,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: { 
                            color: colors.text,
                            padding: 20,
                            font: {
                                size: 12
                            }
                        }
                    },
                    tooltip: {
                        backgroundColor: colors.bg,
                        titleColor: colors.text,
                        bodyColor: colors.text,
                        borderColor: colors.grid,
                        borderWidth: 1,
                        padding: 12,
                        cornerRadius: 8,
                        displayColors: false,
                    }
                },
                animation: {
                    duration: 2000,
                    easing: 'easeInOutQuart'
                }
            }
        });
    }

    // Inicializar y actualizar en modo oscuro
    let barChart, pieChart;
    function renderCharts() {
        if(barChart) barChart.destroy();
        if(pieChart) pieChart.destroy();
        barChart = renderBarChart();
        pieChart = renderPieChart();
    }

    document.addEventListener('DOMContentLoaded', renderCharts);

    // Re-render al cambiar modo oscuro
    window.addEventListener('storage', (e) => {
        if(e.key === 'darkMode') setTimeout(renderCharts, 200);
    });

    document.querySelector('[aria-label="Cambiar modo oscuro"]')?.addEventListener('click', () => setTimeout(renderCharts, 200));
</script>
@endpush
@endsection 