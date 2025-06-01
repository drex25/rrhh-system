@extends('layouts.admin')

@section('content')
@if(isset($error))
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-8 animate-fade-in" role="alert">
        <strong class="font-bold">¡Error!</strong>
        <span class="block sm:inline">{{ $error }}</span>
    </div>
@else
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8 animate-fade-in-up">
        <!-- Tarjetas resumen -->
        <div class="bg-gradient-to-br from-blue-500 to-blue-400 dark:from-blue-900 dark:to-blue-700 rounded-2xl shadow-xl p-6 flex flex-col items-center text-white relative overflow-hidden">
            <div class="absolute right-2 top-2 opacity-10 text-7xl font-black select-none">👥</div>
            <div class="bg-white/20 rounded-full p-3 mb-2">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87m9-5a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
            </div>
            <div class="text-lg font-semibold">Empleados en {{ $department->name }}</div>
            <div class="text-3xl font-extrabold mt-1">{{ $departmentEmployees }}</div>
        </div>
        <div class="bg-gradient-to-br from-pink-500 to-purple-500 dark:from-pink-900 dark:to-purple-800 rounded-2xl shadow-xl p-6 flex flex-col items-center text-white relative overflow-hidden">
            <div class="absolute right-2 top-2 opacity-10 text-7xl font-black select-none">📝</div>
            <div class="bg-white/20 rounded-full p-3 mb-2">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 17l4 4 4-4m0-5V3a1 1 0 00-1-1H7a1 1 0 00-1 1v9m12 4h-4a2 2 0 01-2-2V7a2 2 0 012-2h4a2 2 0 012 2v8a2 2 0 01-2 2z"/></svg>
            </div>
            <div class="text-lg font-semibold">Licencias Pendientes</div>
            <div class="text-3xl font-extrabold mt-1">{{ $pendingLeaveRequests }}</div>
        </div>
        <div class="bg-gradient-to-br from-yellow-400 to-orange-400 dark:from-yellow-900 dark:to-orange-700 rounded-2xl shadow-xl p-6 flex flex-col items-center text-white relative overflow-hidden">
            <div class="absolute right-2 top-2 opacity-10 text-7xl font-black select-none">📊</div>
            <div class="bg-white/20 rounded-full p-3 mb-2">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 7v4a1 1 0 001 1h3m10-5h3a1 1 0 011 1v4a1 1 0 01-1 1h-3m-10 4h10"/></svg>
            </div>
            <div class="text-lg font-semibold">Departamento</div>
            <div class="text-3xl font-extrabold mt-1">{{ $department->name }}</div>
        </div>
    </div>

    <!-- Gráfico -->
    <div class="grid grid-cols-1 gap-6 mb-8 animate-fade-in-up">
        <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-xl p-6 flex flex-col">
            <div class="flex items-center mb-4">
                <span class="text-lg font-bold text-pink-700 dark:text-pink-300">Licencias por Mes en {{ $department->name }}</span>
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
            Como Manager de {{ $department->name }}, puedes visualizar tu equipo, aprobar licencias y revisar notificaciones.
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
        let pieChart;
        function renderCharts() {
            if(pieChart) pieChart.destroy();
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
@endif
@endsection 