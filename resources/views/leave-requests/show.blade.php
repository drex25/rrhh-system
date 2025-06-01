@extends('layouts.admin')

@section('content')
<div class="max-w-2xl mx-auto bg-white p-8 rounded shadow">
    <h1 class="text-2xl font-bold mb-6 text-gray-800">Detalle de Solicitud de Licencia</h1>
    <div class="mb-4">
        <span class="font-semibold text-gray-700">Empleado:</span>
        <span class="ml-2 text-gray-900">{{ $leaveRequest->employee->first_name }} {{ $leaveRequest->employee->last_name }}</span>
    </div>
    <div class="mb-4">
        <span class="font-semibold text-gray-700">Tipo de Licencia:</span>
        <span class="ml-2 text-gray-900">{{ $leaveRequest->leaveType->name ?? '-' }}</span>
    </div>
    <div class="mb-4">
        <span class="font-semibold text-gray-700">Desde:</span>
        <span class="ml-2 text-gray-900">{{ $leaveRequest->start_date }}</span>
    </div>
    <div class="mb-4">
        <span class="font-semibold text-gray-700">Hasta:</span>
        <span class="ml-2 text-gray-900">{{ $leaveRequest->end_date }}</span>
    </div>
    <div class="mb-4">
        <span class="font-semibold text-gray-700">Días:</span>
        <span class="ml-2 text-gray-900">{{ $leaveRequest->total_days }}</span>
    </div>
    <div class="mb-4">
        <span class="font-semibold text-gray-700">Motivo:</span>
        <span class="ml-2 text-gray-900">{{ $leaveRequest->reason }}</span>
    </div>
    <div class="mb-4">
        <span class="font-semibold text-gray-700">Estado:</span>
        <span class="ml-2">
            @if($leaveRequest->status === 'approved')
                <span class="px-2 py-1 text-xs bg-green-100 text-green-800 rounded">Aprobada</span>
            @elseif($leaveRequest->status === 'rejected')
                <span class="px-2 py-1 text-xs bg-red-100 text-red-800 rounded">Rechazada</span>
            @else
                <span class="px-2 py-1 text-xs bg-yellow-100 text-yellow-800 rounded">Pendiente</span>
            @endif
        </span>
    </div>
    @if($leaveRequest->status === 'rejected' && $leaveRequest->rejection_reason)
    <div class="mb-4">
        <span class="font-semibold text-gray-700">Motivo de Rechazo:</span>
        <span class="ml-2 text-red-700">{{ $leaveRequest->rejection_reason }}</span>
    </div>
    @endif
    @if($leaveRequest->notes)
    <div class="mb-4">
        <span class="font-semibold text-gray-700">Notas:</span>
        <span class="ml-2 text-gray-900">{{ $leaveRequest->notes }}</span>
    </div>
    @endif
    <div class="flex justify-end mt-6">
        <a href="{{ route('leave-requests.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300 mr-2">Volver</a>
        @can('edit_leave_requests')
        <a href="{{ route('leave-requests.edit', $leaveRequest) }}" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Editar</a>
        @endcan
    </div>
</div>
@endsection 