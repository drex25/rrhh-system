@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="max-w-2xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-semibold text-gray-900">Nuevo Saldo de Licencia</h1>
            <a href="{{ route('employee-leave-balances.index') }}" class="text-blue-600 hover:text-blue-900">
                Volver
            </a>
        </div>

        @if($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="bg-white shadow rounded-lg">
            <form action="{{ route('employee-leave-balances.store') }}" method="POST" class="p-6">
                @csrf
                
                <div class="mb-4">
                    <label for="employee_id" class="block text-sm font-medium text-gray-700">Empleado</label>
                    <select name="employee_id" id="employee_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                        <option value="">Seleccione un empleado</option>
                        @foreach($employees as $employee)
                            <option value="{{ $employee->id }}" {{ old('employee_id') == $employee->id ? 'selected' : '' }}>
                                {{ $employee->user->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label for="leave_type_id" class="block text-sm font-medium text-gray-700">Tipo de Licencia</label>
                    <select name="leave_type_id" id="leave_type_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                        <option value="">Seleccione un tipo de licencia</option>
                        @foreach($leaveTypes as $type)
                            <option value="{{ $type->id }}" {{ old('leave_type_id') == $type->id ? 'selected' : '' }}>
                                {{ $type->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label for="total_days" class="block text-sm font-medium text-gray-700">Días Totales</label>
                    <input type="number" name="total_days" id="total_days" min="0" step="0.5" value="{{ old('total_days') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                </div>

                <div class="mb-4">
                    <label for="year" class="block text-sm font-medium text-gray-700">Año</label>
                    <select name="year" id="year" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                        @for($year = date('Y'); $year >= date('Y') - 2; $year--)
                            <option value="{{ $year }}" {{ old('year', date('Y')) == $year ? 'selected' : '' }}>
                                {{ $year }}
                            </option>
                        @endfor
                    </select>
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                        Guardar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection 