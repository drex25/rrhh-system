@extends('layouts.admin')

@section('content')
<div class="w-full mx-auto bg-white p-8 rounded shadow">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Detalle del Recibo</h2>
        <div class="flex gap-2">
            <a href="{{ route('employee.payslips.index') }}" class="px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700">Volver</a>
            <a href="{{ route('employee.payslips.download', $payslip) }}" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">Descargar PDF</a>
        </div>
    </div>

    <div class="grid grid-cols-2 gap-6 mb-6">
        <div class="bg-gray-50 p-4 rounded">
            <h3 class="text-lg font-semibold mb-2">Información del Período</h3>
            <p><strong>Fecha de Pago:</strong> {{ $payslip->payment_date->format('d/m/Y') }}</p>
            <p><strong>Período:</strong> {{ $payslip->period_start->format('d/m/Y') }} - {{ $payslip->period_end->format('d/m/Y') }}</p>
            <p><strong>Método de Pago:</strong> {{ $payslip->payment_method }}</p>
            @if($payslip->bank_account)
                <p><strong>Cuenta Bancaria:</strong> {{ $payslip->bank_account }}</p>
            @endif
        </div>
    </div>

    <div class="mb-6">
        <h3 class="text-lg font-semibold mb-2">Desglose de Salario</h3>
        <div class="grid grid-cols-2 gap-6">
            <div class="bg-gray-50 p-4 rounded">
                <h4 class="font-semibold mb-2">Haberes y Adicionales</h4>
                <table class="w-full">
                    <tbody>
                        @foreach($payslip->allowances as $allowance)
                            <tr>
                                <td class="py-1">{{ $allowance['descripcion'] }}</td>
                                <td class="py-1 text-right">
                                    ${{ number_format(($allowance['haberes'] ?? 0) + ($allowance['adicionales'] ?? 0), 2) }}
                                </td>
                            </tr>
                        @endforeach
                        <tr class="border-t">
                            <td class="py-2 font-semibold">Total Haberes</td>
                            <td class="py-2 text-right font-semibold">${{ number_format($payslip->gross_salary, 2) }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="bg-gray-50 p-4 rounded">
                <h4 class="font-semibold mb-2">Deducciones</h4>
                <table class="w-full">
                    <tbody>
                        @foreach($payslip->deductions as $deduction)
                            <tr>
                                <td class="py-1">{{ $deduction['descripcion'] }}</td>
                                <td class="py-1 text-right">
                                    ${{ number_format($deduction['retenciones'] ?? 0, 2) }}
                                </td>
                            </tr>
                        @endforeach
                        <tr class="border-t">
                            <td class="py-2 font-semibold">Total Deducciones</td>
                            <td class="py-2 text-right font-semibold">${{ number_format($payslip->gross_salary - $payslip->net_salary, 2) }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="bg-blue-50 p-4 rounded">
        <h3 class="text-lg font-semibold mb-2">Total Neto a Recibir</h3>
        <p class="text-2xl font-bold text-blue-800">${{ number_format($payslip->net_salary, 2) }}</p>
    </div>

    @if($payslip->notes)
        <div class="mt-6 bg-gray-50 p-4 rounded">
            <h3 class="text-lg font-semibold mb-2">Notas</h3>
            <p>{{ $payslip->notes }}</p>
        </div>
    @endif
</div>
@endsection 