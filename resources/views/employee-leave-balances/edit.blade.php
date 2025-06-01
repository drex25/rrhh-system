@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="max-w-2xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-semibold text-gray-900">Editar Saldo de Licencia</h1>
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
            <form action="{{ route('employee-leave-balances.update', $balance) }}" method="POST" class="p-6">
                @csrf
                @method('PUT')
                
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Empleado</label>
                    <div class="mt-1 block w-full rounded-md border-gray-300 bg-gray-50 px-3 py-2 text-gray-500">
                        {{ $balance->employee->user->name }}
                    </div>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Tipo de Licencia</label>
                    <div class="mt-1 block w-full rounded-md border-gray-300 bg-gray-50 px-3 py-2 text-gray-500">
                        {{ $balance->leaveType->name }}
                    </div>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Año</label>
                    <div class="mt-1 block w-full rounded-md border-gray-300 bg-gray-50 px-3 py-2 text-gray-500">
                        {{ $balance->year }}
                    </div>
                </div>

                <div class="mb-4">
                    <label for="total_days" class="block text-sm font-medium text-gray-700">Días Totales</label>
                    <input type="number" name="total_days" id="total_days" min="0" step="0.5" value="{{ old('total_days', $balance->total_days) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                    <p class="mt-1 text-sm text-gray-500">
                        Días usados: {{ $balance->used_days }} | Días restantes: {{ $balance->remaining_days }}
                    </p>
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                        Actualizar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection 