@extends('layouts.admin')

@section('content')
<div class="w-full mx-auto px-4 md:px-6 lg:px-8 py-6">
    <!-- Header -->
    <div class="flex flex-col md:flex-row items-center justify-between bg-white dark:bg-gray-900 rounded-2xl shadow-lg p-8 mb-8 border border-gray-200 dark:border-gray-800 transform transition-all duration-300 hover:shadow-xl">
        <div class="flex items-center gap-4 mb-4 md:mb-0">
            <div class="p-3 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl shadow-lg">
                <i class="fa-solid fa-list-check text-2xl text-white"></i>
            </div>
            <div>
                <h1 class="text-3xl md:text-4xl font-extrabold text-gray-800 dark:text-white tracking-tight">Tipos de Licencia</h1>
                <p class="text-gray-500 dark:text-gray-400 mt-1">Administración de tipos de licencia</p>
            </div>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('leave-requests.index') }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-gray-600 dark:bg-gray-700 text-white text-sm font-semibold rounded-xl shadow-sm hover:bg-gray-700 dark:hover:bg-gray-600 transition-all duration-200">
                <i class="fa-solid fa-calendar-check"></i>
                Solicitudes
            </a>
            <a href="{{ route('employee-leave-balances.index') }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-600 text-white text-sm font-semibold rounded-xl shadow-sm hover:from-indigo-600 hover:to-blue-600 transition-all duration-200">
                <i class="fa-solid fa-calculator"></i>
                Saldos
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-4 p-4 bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-300 rounded-lg flex items-center">
            <i class="fa-solid fa-circle-check mr-2"></i>
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="mb-4 p-4 bg-red-100 dark:bg-red-900/30 text-red-800 dark:text-red-300 rounded-lg flex items-center">
            <i class="fa-solid fa-circle-exclamation mr-2"></i>
            {{ session('error') }}
        </div>
    @endif

    <!-- Tabla de Tipos de Licencia -->
    <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-lg overflow-hidden border border-gray-200 dark:border-gray-800">
        <div class="p-6 flex justify-between items-center border-b border-gray-200 dark:border-gray-700">
            <h2 class="text-xl font-semibold text-gray-800 dark:text-white">Lista de Tipos de Licencia</h2>
            <a href="{{ route('leave-types.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-600 text-white text-sm font-semibold rounded-xl shadow-sm hover:from-indigo-600 hover:to-blue-600 transition-all duration-200">
                <i class="fa-solid fa-plus"></i>
                Nuevo Tipo
            </a>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-800">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Nombre</th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Descripción</th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Días Máximos</th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Estado</th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-900 divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($leaveTypes as $type)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-800 transition-all duration-200">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10">
                                    <div class="h-10 w-10 rounded-full bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center text-white font-bold">
                                        {{ substr($type->name, 0, 1) }}
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900 dark:text-white">
                                        {{ $type->name }}
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-500 dark:text-gray-400">
                                {{ $type->description }}
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-bold bg-blue-50 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300">
                                {{ $type->max_days }} días
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full 
                                @if($type->is_active) bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300
                                @else bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300
                                @endif">
                                {{ $type->is_active ? 'Activo' : 'Inactivo' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center gap-2">
                                <a href="{{ route('leave-types.edit', $type) }}" class="group flex items-center justify-center w-9 h-9 rounded-lg bg-blue-50 dark:bg-blue-900/30 hover:bg-blue-100 dark:hover:bg-blue-900/50 shadow-sm transition-all duration-200" title="Editar">
                                    <i class="fa-solid fa-pen text-blue-600 dark:text-blue-300 text-sm group-hover:scale-110 transition-transform"></i>
                                </a>
                                <form action="{{ route('leave-types.destroy', $type) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="group flex items-center justify-center w-9 h-9 rounded-lg bg-red-50 dark:bg-red-900/30 hover:bg-red-100 dark:hover:bg-red-900/50 shadow-sm transition-all duration-200" title="Eliminar" onclick="return confirm('¿Está seguro de eliminar este tipo de licencia?')">
                                        <i class="fa-solid fa-trash text-red-600 dark:text-red-300 text-sm group-hover:scale-110 transition-transform"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center">
                            <div class="flex flex-col items-center justify-center text-gray-500 dark:text-gray-400">
                                <i class="fa-solid fa-list-xmark text-4xl mb-3 text-gray-300 dark:text-gray-600"></i>
                                <p class="text-lg font-medium">No hay tipos de licencia</p>
                                <p class="text-sm mt-1">Comience agregando un nuevo tipo de licencia</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 bg-white dark:bg-gray-900 border-t border-gray-200 dark:border-gray-700 flex justify-center">
            {{ $leaveTypes->links() }}
        </div>
    </div>
</div>
@endsection 