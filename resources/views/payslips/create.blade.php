@extends('layouts.admin')

@section('content')
<div class="w-full mx-auto bg-white p-8 rounded shadow">
    <h2 class="text-2xl font-bold mb-6 text-gray-800">Nuevo Recibo de Haberes</h2>
    <form action="{{ route('payslips.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700">Empleado *</label>
                <select name="employee_id" class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                    <option value="">Seleccione...</option>
                    @foreach($employees as $employee)
                        <option value="{{ $employee->id }}">{{ $employee->full_name }} ({{ $employee->file_number }})</option>
                    @endforeach
                </select>
                @error('employee_id')<span class="text-red-600 text-xs">{{ $message }}</span>@enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Fecha de pago *</label>
                <input type="date" name="payment_date" value="{{ old('payment_date') }}" class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                @error('payment_date')<span class="text-red-600 text-xs">{{ $message }}</span>@enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Período desde *</label>
                <input type="date" name="period_start" value="{{ old('period_start') }}" class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                @error('period_start')<span class="text-red-600 text-xs">{{ $message }}</span>@enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Período hasta *</label>
                <input type="date" name="period_end" value="{{ old('period_end') }}" class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                @error('period_end')<span class="text-red-600 text-xs">{{ $message }}</span>@enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Sueldo Bruto *</label>
                <input type="number" step="0.01" name="gross_salary" value="{{ old('gross_salary') }}" class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                @error('gross_salary')<span class="text-red-600 text-xs">{{ $message }}</span>@enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Sueldo Neto *</label>
                <input type="number" step="0.01" name="net_salary" value="{{ old('net_salary') }}" class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                @error('net_salary')<span class="text-red-600 text-xs">{{ $message }}</span>@enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Método de pago *</label>
                <input type="text" name="payment_method" value="{{ old('payment_method') }}" class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                @error('payment_method')<span class="text-red-600 text-xs">{{ $message }}</span>@enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Cuenta bancaria</label>
                <input type="text" name="bank_account" value="{{ old('bank_account') }}" class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">
                @error('bank_account')<span class="text-red-600 text-xs">{{ $message }}</span>@enderror
            </div>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Conceptos (Haberes, Retenciones, Adicionales)</label>
            <textarea name="concepts_json" rows="6" class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500" placeholder='Ejemplo: [{"descripcion":"SUELDO","codigo":"1005","unidades":1,"haberes":1300927.96,"retenciones":0,"adicionales":0}, ...]'>{{ old('concepts_json') }}</textarea>
            <span class="text-xs text-gray-500">Pegue aquí los conceptos en formato JSON. (En el futuro se puede hacer dinámico por JS)</span>
            @error('concepts_json')<span class="text-red-600 text-xs">{{ $message }}</span>@enderror
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Notas</label>
            <textarea name="notes" rows="2" class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">{{ old('notes') }}</textarea>
            @error('notes')<span class="text-red-600 text-xs">{{ $message }}</span>@enderror
        </div>
        <div class="flex justify-end">
            <button type="submit" class="px-6 py-2 bg-green-600 text-white rounded hover:bg-green-700">Guardar Recibo</button>
        </div>
    </form>
</div>
@endsection 