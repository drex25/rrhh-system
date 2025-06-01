@extends('layouts.admin')

@section('content')
<div class="w-full mx-auto bg-white p-8 rounded shadow">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Recibos</h2>
        <a href="{{ route('payslips.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Nuevo Recibo</a>
    </div>
    @if(session('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
    @endif
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Empleado</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Mes</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Año</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($payslips as $payslip)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $payslip->id }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $payslip->employee->full_name ?? '-' }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $payslip->month }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $payslip->year }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">${{ number_format($payslip->total, 2) }}</td>
                    <td class="px-6 py-4 whitespace-nowrap flex gap-2">
                        <a href="{{ route('payslips.show', $payslip) }}" class="text-blue-600 hover:underline">Ver</a>
                        <a href="{{ route('payslips.edit', $payslip) }}" class="text-yellow-600 hover:underline">Editar</a>
                        <form action="{{ route('payslips.destroy', $payslip) }}" method="POST" onsubmit="return confirm('¿Seguro que desea eliminar este recibo?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:underline">Eliminar</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-4 text-center text-gray-500">No hay recibos registrados.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">
        {{ $payslips->links() }}
    </div>
</div>
@endsection 