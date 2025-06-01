@extends('layouts.admin')

@section('content')
<div class="max-w-lg mx-auto mt-12 bg-white dark:bg-gray-900 rounded-xl shadow-xl p-8 border border-gray-200 dark:border-gray-800">
    <h2 class="text-2xl font-bold text-gray-800 dark:text-white mb-6">Dar de baja empleado</h2>
    <p class="mb-4 text-gray-600 dark:text-gray-300">Estás a punto de dar de baja a <span class="font-semibold">{{ $employee->first_name }} {{ $employee->last_name }}</span>. Esta acción marcará al empleado como inactivo y conservará su historial.</p>
    <form action="{{ route('employees.baja', $employee) }}" method="POST" class="space-y-6">
        @csrf
        <div>
            <label for="termination_date" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">Fecha de baja <span class="text-red-500">*</span></label>
            <input type="date" name="termination_date" id="termination_date" required class="w-full px-4 py-2 border border-gray-300 dark:border-gray-700 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-900 dark:text-gray-100">
            @error('termination_date')
                <span class="text-red-500 text-xs">{{ $message }}</span>
            @enderror
        </div>
        <div>
            <label for="termination_reason" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">Motivo de baja (opcional)</label>
            <input type="text" name="termination_reason" id="termination_reason" maxlength="255" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-700 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-900 dark:text-gray-100" placeholder="Motivo de la baja">
            @error('termination_reason')
                <span class="text-red-500 text-xs">{{ $message }}</span>
            @enderror
        </div>
        <div class="flex justify-between items-center mt-8">
            <a href="{{ route('employees.show', $employee) }}" class="px-4 py-2 rounded-lg bg-gray-200 dark:bg-gray-800 text-gray-700 dark:text-gray-200 hover:bg-gray-300 dark:hover:bg-gray-700 transition">Cancelar</a>
            <button type="submit" class="px-6 py-2 rounded-lg bg-red-600 text-white font-semibold shadow hover:bg-red-700 transition">Confirmar baja</button>
        </div>
    </form>
</div>
@endsection 