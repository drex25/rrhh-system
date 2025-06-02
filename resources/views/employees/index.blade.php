@extends('layouts.admin')

@section('content')
<div class="w-full mx-auto px-4 md:px-6 lg:px-8 py-6" :class="darkMode ? 'bg-[#181F2A]' : 'bg-gray-100'" class="min-h-screen">
    <!-- Header -->
    <div class="flex flex-col md:flex-row items-center justify-between rounded-2xl shadow-lg p-8 mb-8 border" :class="darkMode ? 'bg-[#232B3E] border-[#232B3E]' : 'bg-white border-gray-200'">
        <div class="flex items-center gap-4 mb-4 md:mb-0">
            <div class="p-3 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl shadow-lg">
                <i class="fa-solid fa-users text-2xl text-white"></i>
            </div>
            <div>
                <h1 class="text-3xl md:text-4xl font-extrabold tracking-tight" :class="darkMode ? 'text-white' : 'text-blue-900'">Colaboradores</h1>
                <p class="mt-1" :class="darkMode ? 'text-gray-400' : 'text-gray-600'">Gestión de personal</p>
            </div>
        </div>
        <a href="{{ route('employees.create') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white text-lg font-semibold rounded-xl shadow-lg hover:scale-105 hover:from-indigo-600 hover:to-blue-600 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-blue-400">
            <i class="fa-solid fa-user-plus text-xl"></i>
            Dar de Alta
        </a>
    </div>

    <!-- Filtros -->
    <div class="rounded-xl shadow-lg p-6 mb-8 border" :class="darkMode ? 'bg-[#232B3E] border-[#232B3E]' : 'bg-white border-gray-200'">
        <form action="{{ route('employees.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <div class="relative group">
                <label for="search" class="block text-sm font-medium mb-2" :class="darkMode ? 'text-gray-300' : 'text-blue-900'">Buscar</label>
                <div class="relative">
                    <input type="text" name="search" id="search" value="{{ request('search') }}" 
                        class="w-full pl-10 pr-4 py-2.5 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 group-hover:border-blue-400" 
                        :class="darkMode ? 'border-gray-700 bg-[#232B3E] text-white placeholder-gray-400' : 'border-gray-300 bg-gray-200 text-blue-900 placeholder-gray-500'"
                        placeholder="Nombre, legajo, DNI...">
                    <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 transition-colors" :class="darkMode ? 'text-gray-400 group-hover:text-blue-500' : 'text-gray-500 group-hover:text-blue-500'"></i>
                </div>
            </div>
            <div class="group">
                <label for="department" class="block text-sm font-medium mb-2" :class="darkMode ? 'text-gray-300' : 'text-blue-900'">Departamento</label>
                <select name="department" id="department" 
                    class="w-full px-4 py-2.5 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 group-hover:border-blue-400 tom-select"
                    :class="darkMode ? 'border-gray-700 bg-[#232B3E] text-white' : 'border-gray-300 bg-gray-200 text-blue-900'">
                    <option value="">Todos los departamentos</option>
                    @foreach($departments as $department)
                        <option value="{{ $department->id }}" {{ request('department') == $department->id ? 'selected' : '' }}>{{ $department->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="group">
                <label for="status" class="block text-sm font-medium mb-2" :class="darkMode ? 'text-gray-300' : 'text-blue-900'">Estado</label>
                <select name="status" id="status" 
                    class="w-full px-4 py-2.5 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 group-hover:border-blue-400 tom-select"
                    :class="darkMode ? 'border-gray-700 bg-[#232B3E] text-white' : 'border-gray-300 bg-gray-200 text-blue-900'">
                    <option value="">Todos los estados</option>
                    <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>Activo</option>
                    <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>Inactivo</option>
                </select>
            </div>
            <div class="flex items-end">
                <button type="submit" class="w-full flex items-center justify-center gap-2 px-6 py-2.5 bg-gradient-to-r from-indigo-600 to-blue-600 text-white rounded-xl shadow-lg hover:scale-105 hover:from-blue-600 hover:to-indigo-600 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-blue-400">
                    <i class="fa-solid fa-filter"></i>
                    Filtrar
                </button>
            </div>
        </form>
    </div>

    <!-- Tabla -->
    <div class="rounded-2xl shadow-lg overflow-hidden border" :class="darkMode ? 'bg-[#232B3E] border-[#232B3E]' : 'bg-white border-gray-200'">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y" :class="darkMode ? 'divide-gray-700' : 'divide-gray-300'">
                <thead class="sticky top-0 z-10 border-b" :class="darkMode ? 'bg-[#232B3E] border-[#232B3E]' : 'bg-white border-gray-200'">
                    <tr>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider" :class="darkMode ? 'text-gray-300' : 'text-blue-900'">Legajo</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider" :class="darkMode ? 'text-gray-300' : 'text-blue-900'">Nombre</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider" :class="darkMode ? 'text-gray-300' : 'text-blue-900'">Departamento</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider" :class="darkMode ? 'text-gray-300' : 'text-blue-900'">Puesto</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider" :class="darkMode ? 'text-gray-300' : 'text-blue-900'">Estado</th>
                        <th scope="col" class="px-6 py-4 text-center text-xs font-bold uppercase tracking-wider" :class="darkMode ? 'text-gray-300' : 'text-blue-900'">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y" :class="darkMode ? 'bg-[#232B3E] divide-gray-700' : 'bg-white divide-gray-300'">
                    @forelse($employees as $employee)
                        <tr class="transition-all duration-200" :class="darkMode ? 'hover:bg-[#232B3E]/80' : 'hover:bg-gray-300'">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-bold" :class="darkMode ? 'bg-blue-900/30 text-blue-300' : 'bg-blue-50 text-blue-700'">
                                    #{{ $employee->file_number }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        <div class="h-10 w-10 rounded-full bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center text-white font-bold">
                                            {{ substr($employee->first_name, 0, 1) }}{{ substr($employee->last_name, 0, 1) }}
                                        </div>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium" :class="darkMode ? 'text-white' : 'text-blue-900'">{{ $employee->first_name }} {{ $employee->last_name }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm" :class="darkMode ? 'text-gray-300' : 'text-blue-900'">{{ $employee->department->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm" :class="darkMode ? 'text-gray-300' : 'text-blue-900'">{{ $employee->position->title }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full" :class="$employee->is_active ? (darkMode ? 'bg-green-900/30 text-green-300' : 'bg-green-100 text-green-800') : (darkMode ? 'bg-red-900/30 text-red-300' : 'bg-red-100 text-red-800')">
                                    {{ $employee->is_active ? 'Activo' : 'Inactivo' }}
                                </span>
                                @if(!$employee->is_active && $employee->termination_date)
                                    <span class="ml-2 px-2 py-1 rounded-full text-xs font-semibold cursor-help" :class="darkMode ? 'bg-red-900/30 text-red-300' : 'bg-red-100 text-red-800'" title="Baja: {{ \Carbon\Carbon::parse($employee->termination_date)->format('d/m/Y') }}{{ $employee->termination_reason ? ' | Motivo: ' . $employee->termination_reason : '' }}">
                                        <i class="fa-solid fa-arrow-right-to-bracket mr-1"></i> Baja
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('employees.show', $employee) }}" class="group flex items-center justify-center w-9 h-9 rounded-lg shadow-sm transition-all duration-200" :class="darkMode ? 'bg-indigo-900/30 hover:bg-indigo-900/50' : 'bg-indigo-50 hover:bg-indigo-100'" title="Ver Detalles">
                                        <i class="fa-solid fa-eye text-sm group-hover:scale-110 transition-transform" :class="darkMode ? 'text-indigo-300' : 'text-indigo-600'"></i>
                                    </a>
                                    <a href="{{ route('employees.edit', $employee) }}" class="group flex items-center justify-center w-9 h-9 rounded-lg shadow-sm transition-all duration-200 @if(!$employee->is_active) opacity-50 cursor-not-allowed pointer-events-none @endif" :class="darkMode ? 'bg-blue-900/30 hover:bg-blue-900/50' : 'bg-blue-50 hover:bg-blue-100'" @if(!$employee->is_active) title="No se puede editar un empleado dado de baja" @endif>
                                        <i class="fa-solid fa-pen text-sm group-hover:scale-110 transition-transform" :class="darkMode ? 'text-blue-300' : 'text-blue-600'"></i>
                                    </a>
                                    @role('Admin')
                                    @if($employee->is_active)
                                    <form id="delete-employee-form-{{ $employee->id }}" action="{{ route('employees.destroy', $employee) }}" method="POST" class="inline m-0 p-0 flex items-center">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" onclick="confirmDeleteEmployee{{ $employee->id }}(event)" class="group flex items-center justify-center w-9 h-9 rounded-lg shadow-sm transition-all duration-200 p-0 m-0 border-0" :class="darkMode ? 'bg-red-900/30 hover:bg-red-900/50' : 'bg-red-50 hover:bg-red-100'" title="Eliminar">
                                            <i class="fa-solid fa-trash text-sm group-hover:scale-110 transition-transform" :class="darkMode ? 'text-red-300' : 'text-red-600'"></i>
                                        </button>
                                    </form>
                                    <script>
                                    function confirmDeleteEmployee{{ $employee->id }}(e) {
                                        e.preventDefault();
                                        Swal.fire({
                                            title: '¿Estás seguro?',
                                            text: 'Esta acción eliminará permanentemente al empleado y no se podrá deshacer. ¿Deseas continuar?',
                                            icon: 'warning',
                                            showCancelButton: true,
                                            confirmButtonColor: '#d33',
                                            cancelButtonColor: '#3085d6',
                                            confirmButtonText: 'Sí, eliminar',
                                            cancelButtonText: 'Cancelar',
                                            customClass: {
                                                popup: 'rounded-xl',
                                                confirmButton: 'rounded-lg',
                                                cancelButton: 'rounded-lg'
                                            }
                                        }).then((result) => {
                                            if (result.isConfirmed) {
                                                document.getElementById('delete-employee-form-{{ $employee->id }}').submit();
                                            } else {
                                                Swal.fire({
                                                    icon: 'info',
                                                    title: 'Cancelado',
                                                    text: 'El empleado no fue eliminado.',
                                                    toast: true,
                                                    position: 'top-end',
                                                    showConfirmButton: false,
                                                    timer: 2000,
                                                    customClass: {
                                                        popup: 'rounded-xl'
                                                    }
                                                });
                                            }
                                        });
                                    }
                                    </script>
                                    @endif
                                    @endrole
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center">
                                <div class="flex flex-col items-center justify-center" :class="darkMode ? 'text-gray-400' : 'text-gray-600'">
                                    <i class="fa-solid fa-users text-4xl mb-3" :class="darkMode ? 'text-gray-600' : 'text-gray-500'"></i>
                                    <p class="text-lg font-medium">No hay empleados registrados</p>
                                    <p class="text-sm mt-1">Comienza agregando un nuevo empleado</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t flex justify-center" :class="darkMode ? 'bg-[#232B3E] border-[#232B3E]' : 'bg-gray-200 border-gray-200'">
            {{ $employees->links('pagination::tailwind') }}
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
@if(session('success'))
    Swal.fire({
        icon: 'success',
        title: 'Éxito',
        text: '{{ session('success') }}',
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 2000,
        customClass: {
            popup: 'rounded-xl'
        }
    });
@endif
@if(session('error'))
    Swal.fire({
        icon: 'error',
        title: 'Error',
        text: '{{ session('error') }}',
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 2000,
        customClass: {
            popup: 'rounded-xl'
        }
    });
@endif
</script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    if (document.getElementById('department')) {
        new TomSelect('#department', {
            render: {
                option: function(data, escape) {
                    return `<div class='tsg-dark-option'>${escape(data.text)}</div>`;
                },
                item: function(data, escape) {
                    return `<div class='tsg-dark-item'>${escape(data.text)}</div>`;
                }
            }
        });
    }
    if (document.getElementById('status')) {
        new TomSelect('#status', {
            render: {
                option: function(data, escape) {
                    return `<div class='tsg-dark-option'>${escape(data.text)}</div>`;
                },
                item: function(data, escape) {
                    return `<div class='tsg-dark-item'>${escape(data.text)}</div>`;
                }
            }
        });
    }
});
</script>

<style>
.tsg-dark-option, .ts-dropdown .option {
    background: #232B3E !important;
    color: #fff !important;
}
.tsg-dark-item, .ts-control .item {
    background: #232B3E !important;
    color: #fff !important;
}
.ts-dropdown, .ts-dropdown [data-selectable] {
    background: #232B3E !important;
    color: #fff !important;
}
.ts-dropdown .active {
    background: #334155 !important;
    color: #fff !important;
}
.ts-control {
    background: #232B3E !important;
    color: #fff !important;
    border-color: #334155 !important;
}
</style>
@endsection 