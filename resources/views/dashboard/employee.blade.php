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
            <div class="absolute right-2 top-2 opacity-10 text-7xl font-black select-none">💸</div>
            <div class="bg-white/20 rounded-full p-3 mb-2">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 17v-2a4 4 0 014-4h3m4 0V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2h7"/></svg>
            </div>
            <div class="text-lg font-semibold">Recibos</div>
            <div class="text-3xl font-extrabold mt-1">{{ $payslips->count() }}</div>
        </div>
        <div class="bg-gradient-to-br from-pink-500 to-purple-500 dark:from-pink-900 dark:to-purple-800 rounded-2xl shadow-xl p-6 flex flex-col items-center text-white relative overflow-hidden">
            <div class="absolute right-2 top-2 opacity-10 text-7xl font-black select-none">📝</div>
            <div class="bg-white/20 rounded-full p-3 mb-2">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 17l4 4 4-4m0-5V3a1 1 0 00-1-1H7a1 1 0 00-1 1v9m12 4h-4a2 2 0 01-2-2V7a2 2 0 012-2h4a2 2 0 012 2v8a2 2 0 01-2 2z"/></svg>
            </div>
            <div class="text-lg font-semibold">Licencias</div>
            <div class="text-3xl font-extrabold mt-1">{{ $leaveRequests->count() }}</div>
        </div>
        <div class="bg-gradient-to-br from-yellow-400 to-orange-400 dark:from-yellow-900 dark:to-orange-700 rounded-2xl shadow-xl p-6 flex flex-col items-center text-white relative overflow-hidden">
            <div class="absolute right-2 top-2 opacity-10 text-7xl font-black select-none">📊</div>
            <div class="bg-white/20 rounded-full p-3 mb-2">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 7v4a1 1 0 001 1h3m10-5h3a1 1 0 011 1v4a1 1 0 01-1 1h-3m-10 4h10"/></svg>
            </div>
            <div class="text-lg font-semibold">Días Disponibles</div>
            <div class="text-3xl font-extrabold mt-1">{{ $leaveBalance->available_days ?? 0 }}</div>
        </div>
    </div>

    <!-- Últimos Recibos -->
    <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-xl p-6 mb-8 animate-fade-in-up">
        <h2 class="text-xl font-bold text-gray-800 dark:text-gray-200 mb-4">Últimos Recibos</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-800">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Fecha</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Monto Neto</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-900 divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($payslips as $payslip)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-300">
                            {{ $payslip->created_at->format('d/m/Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-300">
                            ${{ number_format($payslip->net_amount, 2) }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-300">
                            <a href="{{ route('employee.payslips.show', $payslip) }}" class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300">
                                Ver Detalles
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="px-6 py-4 text-center text-sm text-gray-500 dark:text-gray-400">
                            No hay recibos disponibles
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Últimas Licencias -->
    <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-xl p-6 mb-8 animate-fade-in-up">
        <h2 class="text-xl font-bold text-gray-800 dark:text-gray-200 mb-4">Últimas Licencias</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-800">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Tipo</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Fecha Inicio</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Fecha Fin</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Estado</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-900 divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($leaveRequests as $request)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-300">
                            {{ $request->leaveType->name }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-300">
                            {{ $request->start_date->format('d/m/Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-300">
                            {{ $request->end_date->format('d/m/Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                @if($request->status === 'approved') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300
                                @elseif($request->status === 'pending') bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300
                                @else bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300 @endif">
                                {{ ucfirst($request->status) }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-4 text-center text-sm text-gray-500 dark:text-gray-400">
                            No hay licencias solicitadas
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Bienvenida -->
    <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-xl p-8 flex flex-col items-center animate-fade-in">
        <h1 class="text-3xl font-bold text-blue-700 dark:text-blue-300 mb-2">
            ¡Bienvenido, {{ strtoupper(Auth::user()->name) }}!
        </h1>
        <p class="text-gray-600 dark:text-gray-300 mb-4 text-center">
            Consulta tus recibos, solicita licencias y revisa tus notificaciones.
        </p>
        <img src="https://cdn-icons-png.flaticon.com/512/3135/3135715.png" alt="TSGroup" class="w-24 h-24 rounded-full shadow mb-2">
    </div>
@endif
@endsection 