@extends('layouts.admin')

@section('content')
<div class="p-8 bg-gray-50 dark:bg-gray-900 min-h-screen">
    <div class="max-w-4xl mx-auto">
        <div class="flex flex-col md:flex-row items-center gap-6 mb-8">
            <div class="flex-shrink-0">
                <img src="{{ $employee->profile_photo ? asset('storage/' . $employee->profile_photo) : 'https://ui-avatars.com/api/?name=' . urlencode($employee->first_name . ' ' . $employee->last_name) }}" 
                     class="w-24 h-24 rounded-full border-4 border-blue-500 shadow-lg bg-white dark:bg-gray-800 object-cover" 
                     alt="{{ $employee->first_name }} {{ $employee->last_name }}">
            </div>
            <div>
                <h1 class="text-2xl font-bold text-blue-700 dark:text-blue-400">{{ $employee->first_name }} {{ $employee->last_name }}</h1>
                <p class="text-gray-500 dark:text-gray-300">{{ $employee->position->title ?? '-' }} | {{ $employee->department->name ?? '-' }}</p>
                <p class="text-gray-400 dark:text-gray-400 text-sm">DNI: {{ $employee->dni }} | CUIT: {{ $employee->cuit }}</p>
            </div>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6 transition hover:shadow-lg">
            <h2 class="text-lg font-semibold text-gray-700 dark:text-gray-200 mb-4 flex items-center gap-2">
                <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 17l4 4 4-4m0-5V3a1 1 0 00-1-1H7a1 1 0 00-1 1v9m12 4h-4a2 2 0 01-2-2V7a2 2 0 012-2h4a2 2 0 012 2v8a2 2 0 01-2 2z"/></svg>
                Saldos de Licencia
            </h2>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-100 dark:bg-gray-700">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Año</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Tipo de Licencia</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Total</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Usados</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Restantes</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse($balances as $balance)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">{{ $balance->year }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">{{ $balance->leaveType->name ?? '-' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">{{ $balance->total_days }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">{{ $balance->used_days }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">{{ $balance->remaining_days }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">No hay saldos de licencia registrados para este empleado.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="mt-8">
            <a href="{{ route('employees.show', $employee) }}" class="inline-block bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg shadow transition">Volver al Perfil</a>
        </div>
    </div>
</div>
@endsection 