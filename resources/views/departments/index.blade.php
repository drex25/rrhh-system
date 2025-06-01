@extends('layouts.admin')

@section('content')
<div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Departamentos</h1>
    <a href="{{ route('departments.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
        Nuevo departamento
    </a>
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
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nombre</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Código</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Manager</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Ubicación</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Estado</th>
                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Acciones</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @forelse($departments as $department)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap font-semibold text-gray-800">
                        {{ $department->name }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-gray-600">
                        {{ $department->code }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-gray-600">
                        {{ $department->manager ? $department->manager->first_name . ' ' . $department->manager->last_name : '-' }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-gray-600">
                        {{ $department->location ?? '-' }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($department->is_active)
                            <span class="px-2 py-1 text-xs bg-green-100 text-green-800 rounded">Activo</span>
                        @else
                            <span class="px-2 py-1 text-xs bg-red-100 text-red-800 rounded">Inactivo</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <a href="{{ route('departments.show', $department) }}" class="text-blue-600 hover:text-blue-900 mr-2">Ver</a>
                        <a href="{{ route('departments.edit', $department) }}" class="text-yellow-600 hover:text-yellow-900 mr-2">Editar</a>
                        <form action="{{ route('departments.destroy', $department) }}" method="POST" class="inline-block" onsubmit="return confirm('¿Seguro que deseas eliminar este departamento?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="px-6 py-4 text-center text-gray-500">No hay departamentos registrados.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    <div class="p-4">
        {{ $departments->links() }}
    </div>
</div>
@endsection 