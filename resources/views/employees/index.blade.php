@extends('layouts.admin')

@section('content')
<div class="w-full mx-auto px-4 md:px-6 lg:px-8 py-6">
    <!-- Header -->
    <div class="flex flex-col md:flex-row items-center justify-between bg-white dark:bg-gray-900 rounded-2xl shadow-lg p-8 mb-8 border border-gray-200 dark:border-gray-800 transform transition-all duration-300 hover:shadow-xl hover:scale-[1.01]">
        <div class="flex items-center gap-4 mb-4 md:mb-0">
            <div class="p-3 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl shadow-lg transform transition-all duration-300 hover:scale-110 hover:rotate-3">
                <i class="fa-solid fa-users text-2xl text-white"></i>
            </div>
            <div>
                <h1 class="text-3xl md:text-4xl font-extrabold text-gray-800 dark:text-white tracking-tight animate-fade-in">Colaboradores</h1>
                <p class="text-gray-500 dark:text-gray-400 mt-1 animate-fade-in-delay">Gestión de colaboradores de la empresa</p>
            </div>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('departments.index') }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-gray-600 dark:bg-gray-700 text-white text-sm font-semibold rounded-xl shadow-sm hover:bg-gray-700 dark:hover:bg-gray-600 transition-all duration-200 hover:scale-105 hover:shadow-md">
                <i class="fa-solid fa-building-user"></i>
                Departamentos
            </a>
            <a href="{{ route('positions.index') }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-600 text-white text-sm font-semibold rounded-xl shadow-sm hover:from-indigo-600 hover:to-blue-600 transition-all duration-200 hover:scale-105 hover:shadow-md">
                <i class="fa-solid fa-briefcase"></i>
                Puestos
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-4 p-4 bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-300 rounded-lg flex items-center animate-slide-in-right">
            <i class="fa-solid fa-circle-check mr-2"></i>
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="mb-4 p-4 bg-red-100 dark:bg-red-900/30 text-red-800 dark:text-red-300 rounded-lg flex items-center animate-slide-in-right">
            <i class="fa-solid fa-circle-exclamation mr-2"></i>
            {{ session('error') }}
        </div>
    @endif

    <!-- Filtros -->
    <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-lg mb-6 border border-gray-200 dark:border-gray-800 transform transition-all duration-300 hover:shadow-xl">
        <div class="px-6 py-5">
            <form action="{{ route('employees.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <div class="transform transition-all duration-200 hover:scale-[1.02]">
                    <label for="department" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Departamento</label>
                    <select name="department_id" id="department" class="w-full px-4 py-2.5 rounded-xl border border-gray-300 dark:border-gray-700 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-800 dark:text-gray-100 transition-all duration-200">
                        <option value="">Todos</option>
                        @foreach($departments as $department)
                            <option value="{{ $department->id }}" {{ request('department_id') == $department->id ? 'selected' : '' }}>
                                {{ $department->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="transform transition-all duration-200 hover:scale-[1.02]">
                    <label for="position" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Puesto</label>
                    <select name="position_id" id="position" class="w-full px-4 py-2.5 rounded-xl border border-gray-300 dark:border-gray-700 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-800 dark:text-gray-100 transition-all duration-200">
                        <option value="">Todos</option>
                        @foreach($positions as $position)
                            <option value="{{ $position->id }}" {{ request('position_id') == $position->id ? 'selected' : '' }}>
                                {{ $position->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="transform transition-all duration-200 hover:scale-[1.02]">
                    <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Estado</label>
                    <select name="status" id="status" class="w-full px-4 py-2.5 rounded-xl border border-gray-300 dark:border-gray-700 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-800 dark:text-gray-100 transition-all duration-200">
                        <option value="">Todos</option>
                        <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Activo</option>
                        <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactivo</option>
                    </select>
                </div>
                <div class="flex items-end">
                    <button type="submit" class="w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-600 text-white text-sm font-semibold rounded-xl shadow-sm hover:from-indigo-600 hover:to-blue-600 transition-all duration-200 hover:scale-105 hover:shadow-md">
                        <i class="fa-solid fa-filter"></i>
                        Filtrar
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Tabla de Empleados -->
    <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-lg overflow-hidden border border-gray-200 dark:border-gray-800 transform transition-all duration-300 hover:shadow-xl">
        <div class="p-6 flex justify-between items-center border-b border-gray-200 dark:border-gray-700">
            <h2 class="text-xl font-semibold text-gray-800 dark:text-white">Lista de Colaboradores</h2>
            <a href="{{ route('employees.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-600 text-white text-sm font-semibold rounded-xl shadow-sm hover:from-indigo-600 hover:to-blue-600 transition-all duration-200 hover:scale-105 hover:shadow-md">
                <i class="fa-solid fa-plus"></i>
                Nuevo Colaborador
            </a>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-800">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Colaborador</th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Departamento</th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Puesto</th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Email</th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Estado</th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-900 divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($employees as $employee)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-800 transition-all duration-200 animate-fade-in">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10 transform transition-all duration-200 hover:scale-110">
                                    <div class="h-10 w-10 rounded-full bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center text-white font-bold">
                                        {{ substr($employee->user->name, 0, 1) }}
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900 dark:text-white">
                                        {{ $employee->user->name }}
                                    </div>
                                    <div class="text-sm text-gray-500 dark:text-gray-400">
                                        {{ $employee->identification }}
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-bold bg-blue-50 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 transform transition-all duration-200 hover:scale-105">
                                {{ $employee->department->name }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-bold bg-purple-50 dark:bg-purple-900/30 text-purple-700 dark:text-purple-300 transform transition-all duration-200 hover:scale-105">
                                {{ $employee->position->name }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                            {{ $employee->user->email }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full transform transition-all duration-200 hover:scale-105
                                @if($employee->is_active) bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300
                                @else bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300
                                @endif">
                                {{ $employee->is_active ? 'Activo' : 'Inactivo' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center gap-2">
                                <a href="{{ route('employees.show', $employee) }}" class="group flex items-center justify-center w-9 h-9 rounded-lg bg-blue-50 dark:bg-blue-900/30 hover:bg-blue-100 dark:hover:bg-blue-900/50 shadow-sm transition-all duration-200 hover:scale-110 hover:shadow-md" title="Ver">
                                    <i class="fa-solid fa-eye text-blue-600 dark:text-blue-300 text-sm group-hover:scale-110 transition-transform"></i>
                                </a>
                                <a href="{{ route('employees.edit', $employee) }}" class="group flex items-center justify-center w-9 h-9 rounded-lg bg-yellow-50 dark:bg-yellow-900/30 hover:bg-yellow-100 dark:hover:bg-yellow-900/50 shadow-sm transition-all duration-200 hover:scale-110 hover:shadow-md" title="Editar">
                                    <i class="fa-solid fa-pen text-yellow-600 dark:text-yellow-300 text-sm group-hover:scale-110 transition-transform"></i>
                                </a>
                                <form action="{{ route('employees.destroy', $employee) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="group flex items-center justify-center w-9 h-9 rounded-lg bg-red-50 dark:bg-red-900/30 hover:bg-red-100 dark:hover:bg-red-900/50 shadow-sm transition-all duration-200 hover:scale-110 hover:shadow-md" title="Eliminar" onclick="return confirm('¿Está seguro de eliminar este colaborador?')">
                                        <i class="fa-solid fa-trash text-red-600 dark:text-red-300 text-sm group-hover:scale-110 transition-transform"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-8 text-center">
                            <div class="flex flex-col items-center justify-center text-gray-500 dark:text-gray-400 animate-fade-in">
                                <i class="fa-solid fa-users-slash text-4xl mb-3 text-gray-300 dark:text-gray-600 transform transition-all duration-300 hover:scale-110"></i>
                                <p class="text-lg font-medium">No hay colaboradores</p>
                                <p class="text-sm mt-1">Comience agregando un nuevo colaborador</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 bg-white dark:bg-gray-900 border-t border-gray-200 dark:border-gray-700 flex justify-center">
            {{ $employees->links() }}
        </div>
    </div>
</div>

<style>
    @keyframes fade-in {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    @keyframes slide-in-right {
        from { opacity: 0; transform: translateX(20px); }
        to { opacity: 1; transform: translateX(0); }
    }
    .animate-fade-in {
        animation: fade-in 0.5s ease-out;
    }
    .animate-fade-in-delay {
        animation: fade-in 0.5s ease-out 0.2s both;
    }
    .animate-slide-in-right {
        animation: slide-in-right 0.5s ease-out;
    }
</style>
@endsection 