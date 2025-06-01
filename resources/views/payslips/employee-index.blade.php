@extends('layouts.admin')

@section('content')
<div class="w-full mx-auto bg-white p-8 rounded shadow">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Mis Recibos</h2>
    </div>
    @if(session('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
    @endif
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha de Pago</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Período</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Neto</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($payslips as $payslip)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $payslip->id }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $payslip->payment_date->format('d/m/Y') }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        {{ $payslip->period_start->format('d/m/Y') }} - {{ $payslip->period_end->format('d/m/Y') }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">${{ number_format($payslip->net_salary, 2) }}</td>
                    <td class="px-6 py-4 whitespace-nowrap flex gap-2">
                        <a href="{{ route('employee.payslips.show', $payslip) }}" class="text-blue-600 hover:underline">Ver</a>
                        <a href="{{ route('employee.payslips.download', $payslip) }}" class="text-green-600 hover:underline">Descargar PDF</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-4 text-center text-gray-500">No hay recibos disponibles.</td>
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