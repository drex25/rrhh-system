@extends('layouts.admin')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8 animate-fade-in-up">
    <!-- Tarjetas resumen -->
    <div class="bg-gradient-to-br from-blue-500 to-blue-400 dark:from-blue-900 dark:to-blue-700 rounded-2xl shadow-xl p-6 flex flex-col items-center text-white relative overflow-hidden">
        <div class="absolute right-2 top-2 opacity-10 text-7xl font-black select-none">👥</div>
        <div class="bg-white/20 rounded-full p-3 mb-2">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87m9-5a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
        </div>
        <div class="text-lg font-semibold">Empleados</div>
        <div class="text-3xl font-extrabold mt-1">{{ $totalEmployees }}</div>
    </div>
    <div class="bg-gradient-to-br from-green-400 to-blue-400 dark:from-green-900 dark:to-blue-700 rounded-2xl shadow-xl p-6 flex flex-col items-center text-white relative overflow-hidden">
        <div class="absolute right-2 top-2 opacity-10 text-7xl font-black select-none">💸</div>
        <div class="bg-white/20 rounded-full p-3 mb-2">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 17v-2a4 4 0 014-4h3m4 0V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2h7"/></svg>
        </div>
        <div class="text-lg font-semibold">Recibos</div>
        <div class="text-3xl font-extrabold mt-1">{{ $totalPayslips }}</div>
    </div>
    <div class="bg-gradient-to-br from-pink-500 to-purple-500 dark:from-pink-900 dark:to-purple-800 rounded-2xl shadow-xl p-6 flex flex-col items-center text-white relative overflow-hidden">
        <div class="absolute right-2 top-2 opacity-10 text-7xl font-black select-none">📝</div>
        <div class="bg-white/20 rounded-full p-3 mb-2">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 17l4 4 4-4m0-5V3a1 1 0 00-1-1H7a1 1 0 00-1 1v9m12 4h-4a2 2 0 01-2-2V7a2 2 0 012-2h4a2 2 0 012 2v8a2 2 0 01-2 2z"/></svg>
        </div>
        <div class="text-lg font-semibold">Licencias Pendientes</div>
        <div class="text-3xl font-extrabold mt-1">{{ $totalLeaveRequests }}</div>
    </div>
    <div class="bg-gradient-to-br from-yellow-400 to-orange-400 dark:from-yellow-900 dark:to-orange-700 rounded-2xl shadow-xl p-6 flex flex-col items-center text-white relative overflow-hidden">
        <div class="absolute right-2 top-2 opacity-10 text-7xl font-black select-none">📊</div>
        <div class="bg-white/20 rounded-full p-3 mb-2">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 7v4a1 1 0 001 1h3m10-5h3a1 1 0 011 1v4a1 1 0 01-1 1h-3m-10 4h10"/></svg>
        </div>
        <div class="text-lg font-semibold">Departamentos</div>
        <div class="text-3xl font-extrabold mt-1">{{ $totalDepartments }}</div>
    </div>
</div>

<!-- Gráficos -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8 animate-fade-in-up">
    <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-xl p-6 flex flex-col">
        <div class="flex items-center mb-4">
            <span class="text-lg font-bold text-blue-700 dark:text-blue-300">Empleados por Departamento</span>
        </div>
        <canvas id="barChart" height="180"></canvas>
    </div>
    <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-xl p-6 flex flex-col">
        <div class="flex items-center mb-4">
            <span class="text-lg font-bold text-pink-700 dark:text-pink-300">Licencias por Mes</span>
        </div>
        <canvas id="pieChart" height="180"></canvas>
    </div>
</div>

<!-- Bienvenida -->
<div class="bg-white dark:bg-gray-900 rounded-2xl shadow-xl p-8 flex flex-col items-center animate-fade-in">
    <h1 class="text-3xl font-bold text-blue-700 dark:text-blue-300 mb-2">
        ¡Bienvenido, {{ strtoupper(Auth::user()->name) }}!
    </h1>
    <p class="text-gray-600 dark:text-gray-300 mb-4 text-center">
        @role('Admin')
            Tienes acceso total al sistema. Gestiona usuarios, empleados, recibos, licencias y configuración.
        @endrole
        @role('HR')
            Gestiona empleados, recibos y licencias. Accede a notificaciones y reportes.
        @endrole
        @role('Manager')
            Visualiza tu equipo, aprueba licencias y revisa notificaciones.
        @endrole
        @role('Employee')
            Consulta tus recibos, solicita licencias y revisa tus notificaciones.
        @endrole
    </p>
    <img src="https://cdn-icons-png.flaticon.com/512/3135/3135715.png" alt="TSGroup" class="w-24 h-24 rounded-full shadow mb-2">
</div>

<!-- Chart.js CDN y script -->
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
                plugins: {
                    legend: {
                        labels: { color: colors.text }
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
