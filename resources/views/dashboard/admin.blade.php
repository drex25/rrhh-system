@extends('layouts.admin')

@section('content')
<!-- Header Section -->
<div class="mb-8">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-white">Panel de Control</h1>
            <p class="mt-1 text-sm text-gray-300">Bienvenido a tu panel de control</p>
        </div>
        <div class="mt-4 md:mt-0 flex items-center space-x-3">
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

<!-- Stats Grid -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Total Employees Card -->
    <div class="bg-[#232B3E] rounded-xl shadow p-6 border border-[#232B3E] hover:shadow-lg transition-shadow duration-300">
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

    <!-- Total Payslips Card -->
    <div class="bg-[#232B3E] rounded-xl shadow p-6 border border-[#232B3E] hover:shadow-lg transition-shadow duration-300">
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
    <div class="bg-[#232B3E] rounded-xl shadow p-6 border border-[#232B3E] hover:shadow-lg transition-shadow duration-300">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-400">Licencias Pendientes</p>
                <p class="text-2xl font-semibold text-white mt-1">{{ $totalLeaveRequests }}</p>
            </div>
            <div class="p-3 bg-purple-800 rounded-full">
                <svg class="w-6 h-6 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
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
    <div class="bg-[#232B3E] rounded-xl shadow p-6 border border-[#232B3E] hover:shadow-lg transition-shadow duration-300">
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

<!-- Charts Section -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
    <!-- Employees by Department Chart -->
    <div class="bg-[#232B3E] rounded-xl shadow p-6 border border-[#232B3E]">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-white">Empleados por Departamento</h3>
            <div class="flex items-center space-x-2">
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
    <div class="bg-[#232B3E] rounded-xl shadow p-6 border border-[#232B3E]">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-white">Licencias por Mes</h3>
            <div class="flex items-center space-x-2">
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
<div class="bg-[#232B3E] rounded-xl shadow p-6 border border-[#232B3E] mb-8">
    <div class="flex items-center justify-between mb-6">
        <h3 class="text-lg font-semibold text-white">Actividad Reciente</h3>
        <button class="text-sm text-blue-400 hover:text-blue-300">
            Ver todo
        </button>
    </div>
    <div class="space-y-4">
        <!-- Activity Items -->
        <div class="flex items-center space-x-4">
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

        <div class="flex items-center space-x-4">
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

        <div class="flex items-center space-x-4">
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
                    }
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