@extends('layouts.admin')

@section('content')
<div class="w-full mx-auto bg-white p-8 rounded shadow">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Detalle del Departamento</h1>
        <a href="{{ route('departments.edit', $department) }}" class="inline-flex items-center px-4 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-600 transition">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536M9 11l6 6M3 17.25V21h3.75l11.06-11.06a2.121 2.121 0 00-3-3L3 17.25z"/></svg>
            Editar
        </a>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <div>
            <div class="text-gray-500 text-xs uppercase">Nombre</div>
            <div class="text-lg font-semibold text-gray-800">{{ $department->name }}</div>
        </div>
        <div>
            <div class="text-gray-500 text-xs uppercase">Código</div>
            <div class="text-lg text-gray-800">{{ $department->code }}</div>
        </div>
        <div>
            <div class="text-gray-500 text-xs uppercase">Descripción</div>
            <div class="text-gray-800">{{ $department->description ?? '-' }}</div>
        </div>
        <div>
            <div class="text-gray-500 text-xs uppercase">Manager</div>
            <div class="text-gray-800">
                @if($department->manager)
                    {{ $department->manager->first_name }} {{ $department->manager->last_name }}
                @else
                    <span class="text-gray-400">Sin asignar</span>
                @endif
            </div>
        </div>
        <div>
            <div class="text-gray-500 text-xs uppercase">Ubicación</div>
            <div class="text-gray-800">{{ $department->location ?? '-' }}</div>
        </div>
        <div>
            <div class="text-gray-500 text-xs uppercase">Estado</div>
            @if($department->is_active)
                <span class="px-2 py-1 text-xs bg-green-100 text-green-800 rounded">Activo</span>
            @else
                <span class="px-2 py-1 text-xs bg-red-100 text-red-800 rounded">Inactivo</span>
            @endif
        </div>
    </div>
    <h2 class="text-xl font-bold text-gray-700 mb-4">Empleados del área</h2>
    <div class="overflow-x-auto bg-gray-50 rounded shadow">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nombre</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Posición</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Estado</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($department->employees as $employee)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap font-semibold text-gray-800">
                            {{ $employee->first_name }} {{ $employee->last_name }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-gray-600">
                            {{ $employee->email }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-gray-600">
                            {{ $employee->position->title ?? '-' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($employee->is_active)
                                <span class="px-2 py-1 text-xs bg-green-100 text-green-800 rounded">Activo</span>
                            @else
                                <span class="px-2 py-1 text-xs bg-red-100 text-red-800 rounded">Inactivo</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-4 text-center text-gray-500">No hay empleados en este departamento.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection 