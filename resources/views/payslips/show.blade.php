@extends('layouts.admin')

@section('content')
<div class="w-full mx-auto bg-white p-8 rounded shadow">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Detalle del Recibo de Haberes</h2>
        <a href="{{ route('payslips.downloadPdf', $payslip) }}" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700" target="_blank">
            Descargar PDF
        </a>
    </div>
    <div class="mb-4">
        <strong>Empleado:</strong> {{ $payslip->employee->full_name ?? '-' }}<br>
        <strong>Legajo:</strong> {{ $payslip->employee->file_number ?? '-' }}<br>
        <strong>Período:</strong> {{ $payslip->period_start->format('m/Y') }} - {{ $payslip->period_end->format('m/Y') }}<br>
        <strong>Fecha de pago:</strong> {{ $payslip->payment_date->format('d/m/Y') }}<br>
        <strong>Sueldo Bruto:</strong> ${{ number_format($payslip->gross_salary, 2) }}<br>
        <strong>Sueldo Neto:</strong> ${{ number_format($payslip->net_salary, 2) }}<br>
        <strong>Método de pago:</strong> {{ $payslip->payment_method }}<br>
        <strong>Cuenta bancaria:</strong> {{ $payslip->bank_account }}<br>
    </div>
    <div>
        <h3 class="font-semibold mb-2">Conceptos</h3>
        <table class="min-w-full divide-y divide-gray-200 mb-4">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-2 text-xs">Descripción</th>
                    <th class="px-4 py-2 text-xs">Cód.</th>
                    <th class="px-4 py-2 text-xs">Unid.</th>
                    <th class="px-4 py-2 text-xs">Haberes</th>
                    <th class="px-4 py-2 text-xs">Retenciones</th>
                    <th class="px-4 py-2 text-xs">Adicionales</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @php
                    $conceptos = array_merge($payslip->allowances ?? [], $payslip->deductions ?? []);
                @endphp
                @foreach($conceptos as $item)
                <tr>
                    <td class="px-4 py-2">{{ $item['descripcion'] ?? $item['description'] ?? '' }}</td>
                    <td class="px-4 py-2">{{ $item['codigo'] ?? $item['code'] ?? '' }}</td>
                    <td class="px-4 py-2">{{ $item['unidades'] ?? $item['units'] ?? '' }}</td>
                    <td class="px-4 py-2">{{ isset($item['haberes']) ? number_format($item['haberes'], 2) : '' }}</td>
                    <td class="px-4 py-2">{{ isset($item['retenciones']) ? number_format($item['retenciones'], 2) : '' }}</td>
                    <td class="px-4 py-2">{{ isset($item['adicionales']) ? number_format($item['adicionales'], 2) : '' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div>
        <strong>Notas:</strong> {{ $payslip->notes }}
    </div>
</div>
@endsection 