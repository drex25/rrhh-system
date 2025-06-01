@extends('layouts.admin')

@section('content')
<div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Solicitudes de Licencia</h1>
    @can('create_leave_requests')
    <a href="{{ route('leave-requests.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
        Nueva Licencia
    </a>
    @endcan
</div>

@if(session('success'))
    <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
@endif
@if(session('error'))
    <div class="mb-4 p-4 bg-red-100 text-red-800 rounded">{{ session('error') }}</div>
@endif

<div class="overflow-x-auto bg-white rounded shadow">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Empleado</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tipo</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Desde</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Hasta</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Días</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Estado</th>
                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Acciones</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @forelse($leaveRequests as $request)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">
                        {{ $request->employee->first_name }} {{ $request->employee->last_name }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        {{ $request->leaveType->name ?? '-' }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        {{ $request->start_date }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        {{ $request->end_date }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        {{ $request->total_days }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($request->status === 'approved')
                            <span class="px-2 py-1 text-xs bg-green-100 text-green-800 rounded">Aprobada</span>
                        @elseif($request->status === 'rejected')
                            <span class="px-2 py-1 text-xs bg-red-100 text-red-800 rounded">Rechazada</span>
                        @else
                            <span class="px-2 py-1 text-xs bg-yellow-100 text-yellow-800 rounded">Pendiente</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <a href="{{ route('leave-requests.show', $request) }}" class="text-blue-600 hover:text-blue-900 mr-2">Ver</a>
                        @can('edit_leave_requests')
                        <a href="{{ route('leave-requests.edit', $request) }}" class="text-yellow-600 hover:text-yellow-900 mr-2">Editar</a>
                        @endcan
                        @can('delete_leave_requests')
                        <form action="{{ route('leave-requests.destroy', $request) }}" method="POST" class="inline-block" onsubmit="return confirm('¿Seguro que deseas eliminar esta solicitud?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900">Eliminar</button>
                        </form>
                        @endcan
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="px-6 py-4 text-center text-gray-500">No hay solicitudes de licencia registradas.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    <div class="p-4">
        {{ $leaveRequests->links() }}
    </div>
</div>
@endsection 