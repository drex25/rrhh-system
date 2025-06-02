@extends('layouts.admin')

@section('content')
<div class="w-full mx-auto px-4 md:px-6 lg:px-8 py-6">
    <!-- Header -->
    <div class="flex flex-col md:flex-row items-center justify-between bg-white dark:bg-gray-900 rounded-2xl shadow-lg p-8 mb-8 border border-gray-200 dark:border-gray-800 transform transition-all duration-300 hover:shadow-xl hover:scale-[1.01]">
        <div class="flex items-center gap-6 mb-4 md:mb-0">
            @if($employee->profile_photo)
                <div class="relative group">
                    <img src="{{ asset('storage/' . $employee->profile_photo) }}" class="w-32 h-32 rounded-full object-cover border-4 border-indigo-100 dark:border-indigo-900 shadow-lg transform transition-all duration-300 group-hover:scale-110 group-hover:rotate-3" alt="Foto">
                    <div class="absolute inset-0 rounded-full bg-gradient-to-br from-blue-500/20 to-indigo-600/20 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                </div>
            @else
                <div class="w-32 h-32 rounded-full bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center text-4xl text-white border-4 border-indigo-100 dark:border-indigo-900 shadow-lg transform transition-all duration-300 hover:scale-110 hover:rotate-3">
                    {{ substr($employee->first_name, 0, 1) }}{{ substr($employee->last_name, 0, 1) }}
                </div>
            @endif
            <div class="animate-fade-in">
                <h2 class="text-3xl font-bold text-gray-800 dark:text-white">{{ $employee->first_name }} {{ $employee->last_name }}</h2>
                <div class="flex items-center gap-3 mt-2">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold transform transition-all duration-200 hover:scale-105
                        @if($employee->is_active) bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300
                        @else bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300
                        @endif">
                        <span class="w-2 h-2 rounded-full mr-2 @if($employee->is_active) bg-green-500 @else bg-red-500 @endif"></span>
                        {{ $employee->is_active ? 'Activo' : 'Inactivo' }}
                    </span>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300 transform transition-all duration-200 hover:scale-105">
                        <i class="fa-solid fa-id-card mr-2"></i>
                        {{ $employee->file_number }}
                    </span>
                </div>
            </div>
        </div>
        <div class="flex flex-wrap gap-3">
            <a href="{{ route('employees.edit', $employee) }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-600 text-white text-sm font-semibold rounded-xl shadow-sm hover:from-indigo-600 hover:to-blue-600 transition-all duration-200 hover:scale-105 hover:shadow-md @if(!$employee->is_active) opacity-50 cursor-not-allowed pointer-events-none @endif" @if(!$employee->is_active) title="No se puede editar un empleado dado de baja" @endif>
                <i class="fa-solid fa-pen"></i>
                Editar
            </a>
            <a href="{{ route('employee-leave-balances.index', ['employee' => $employee->id]) }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-gradient-to-r from-purple-600 to-indigo-600 text-white text-sm font-semibold rounded-xl shadow-sm hover:from-indigo-600 hover:to-purple-600 transition-all duration-200 hover:scale-105 hover:shadow-md">
                <i class="fa-solid fa-calendar-days"></i>
                Saldos de Licencia
            </a>
            @role('Admin')
                <form id="delete-employee-form" action="{{ route('employees.destroy', $employee) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="button" onclick="confirmDeleteEmployee(event)" class="inline-flex items-center gap-2 px-4 py-2.5 bg-gradient-to-r from-red-600 to-pink-600 text-white text-sm font-semibold rounded-xl shadow-sm hover:from-pink-600 hover:to-red-600 transition-all duration-200 hover:scale-105 hover:shadow-md">
                        <i class="fa-solid fa-trash"></i>
                        Eliminar
                    </button>
                </form>
            @endrole
            @if($employee->is_active)
                <a href="{{ route('employees.bajaForm', $employee) }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-gradient-to-r from-yellow-500 to-orange-500 text-white text-sm font-semibold rounded-xl shadow-sm hover:from-orange-500 hover:to-yellow-500 transition-all duration-200 hover:scale-105 hover:shadow-md">
                    <i class="fa-solid fa-arrow-right"></i>
                    Dar de baja
                </a>
            @endif
        </div>
    </div>

    <div class="flex justify-end mb-6">
        <a href="{{ route('employees.downloadPdf', $employee->id) }}" target="_blank" class="inline-flex items-center gap-2 px-4 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-600 text-white text-sm font-semibold rounded-xl shadow-sm hover:from-indigo-600 hover:to-blue-600 transition-all duration-200 hover:scale-105 hover:shadow-md">
            <i class="fa-solid fa-file-pdf"></i>
            Imprimir/Descargar PDF
        </a>
    </div>

    <!-- Secciones en grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Card Personal -->
        <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-lg p-6 border border-gray-200 dark:border-gray-800 transform transition-all duration-300 hover:shadow-xl">
            <div class="flex items-center gap-2 mb-6">
                <div class="p-2 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-lg shadow-lg">
                    <i class="fa-solid fa-user text-xl text-white"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-800 dark:text-white">Datos Personales</h3>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div class="transform transition-all duration-200 hover:scale-[1.02]">
                    <p class="text-sm text-gray-500 dark:text-gray-400">Nro. de Legajo</p>
                    <p class="font-medium text-gray-800 dark:text-white">{{ $employee->file_number }}</p>
                </div>
                <div class="transform transition-all duration-200 hover:scale-[1.02]">
                    <p class="text-sm text-gray-500 dark:text-gray-400">DNI</p>
                    <p class="font-medium text-gray-800 dark:text-white">{{ $employee->dni }}</p>
                </div>
                <div class="transform transition-all duration-200 hover:scale-[1.02]">
                    <p class="text-sm text-gray-500 dark:text-gray-400">CUIT</p>
                    <p class="font-medium text-gray-800 dark:text-white">{{ $employee->cuit }}</p>
                </div>
                <div class="transform transition-all duration-200 hover:scale-[1.02]">
                    <p class="text-sm text-gray-500 dark:text-gray-400">Fecha de Nacimiento</p>
                    <p class="font-medium text-gray-800 dark:text-white">{{ $employee->birth_date->format('d/m/Y') }}</p>
                </div>
                <div class="transform transition-all duration-200 hover:scale-[1.02]">
                    <p class="text-sm text-gray-500 dark:text-gray-400">País</p>
                    <p class="font-medium text-gray-800 dark:text-white">{{ $employee->birth_country ?? 'No especificado' }}</p>
                </div>
                <div class="transform transition-all duration-200 hover:scale-[1.02]">
                    <p class="text-sm text-gray-500 dark:text-gray-400">Provincia</p>
                    <p class="font-medium text-gray-800 dark:text-white">{{ $employee->birth_province_name }}</p>
                </div>
                <div class="transform transition-all duration-200 hover:scale-[1.02]">
                    <p class="text-sm text-gray-500 dark:text-gray-400">Ciudad de Nacimiento</p>
                    <p class="font-medium text-gray-800 dark:text-white">{{ $employee->birth_city ?? 'No especificada' }}</p>
                </div>
                <div class="transform transition-all duration-200 hover:scale-[1.02]">
                    <p class="text-sm text-gray-500 dark:text-gray-400">Nacionalidad</p>
                    <p class="font-medium text-gray-800 dark:text-white">{{ $employee->nationality ?? 'No especificada' }}</p>
                </div>
                <div class="transform transition-all duration-200 hover:scale-[1.02]">
                    <p class="text-sm text-gray-500 dark:text-gray-400">Género</p>
                    <p class="font-medium text-gray-800 dark:text-white">{{ $employee->gender ?? 'No especificado' }}</p>
                </div>
                <div class="transform transition-all duration-200 hover:scale-[1.02]">
                    <p class="text-sm text-gray-500 dark:text-gray-400">Dirección</p>
                    <p class="font-medium text-gray-800 dark:text-white">{{ $employee->address }}</p>
                </div>
                <div class="transform transition-all duration-200 hover:scale-[1.02]">
                    <p class="text-sm text-gray-500 dark:text-gray-400">Teléfono</p>
                    <p class="font-medium text-gray-800 dark:text-white">{{ $employee->phone }}</p>
                </div>
                <div class="transform transition-all duration-200 hover:scale-[1.02]">
                    <p class="text-sm text-gray-500 dark:text-gray-400">Email</p>
                    <p class="font-medium text-gray-800 dark:text-white">{{ $employee->email }}</p>
                </div>
            </div>
        </div>

        <!-- Card Laboral -->
        <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-lg p-6 border border-gray-200 dark:border-gray-800 transform transition-all duration-300 hover:shadow-xl">
            <div class="flex items-center gap-2 mb-6">
                <div class="p-2 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-lg shadow-lg">
                    <i class="fa-solid fa-briefcase text-xl text-white"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-800 dark:text-white">Datos Laborales</h3>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div class="transform transition-all duration-200 hover:scale-[1.02]">
                    <p class="text-sm text-gray-500 dark:text-gray-400">Departamento</p>
                    <p class="font-medium text-gray-800 dark:text-white">{{ $employee->department->name }}</p>
                </div>
                <div class="transform transition-all duration-200 hover:scale-[1.02]">
                    <p class="text-sm text-gray-500 dark:text-gray-400">Puesto</p>
                    <p class="font-medium text-gray-800 dark:text-white">{{ $employee->position->title }}</p>
                </div>
                <div class="transform transition-all duration-200 hover:scale-[1.02]">
                    <p class="text-sm text-gray-500 dark:text-gray-400">Fecha de Ingreso</p>
                    <p class="font-medium text-gray-800 dark:text-white">{{ $employee->hire_date->format('d/m/Y') }}</p>
                </div>
                <div class="transform transition-all duration-200 hover:scale-[1.02]">
                    <p class="text-sm text-gray-500 dark:text-gray-400">Tipo de Contratación</p>
                    <p class="font-medium text-gray-800 dark:text-white">{{ $employee->employment_type }}</p>
                </div>
                <div class="transform transition-all duration-200 hover:scale-[1.02]">
                    <p class="text-sm text-gray-500 dark:text-gray-400">Horario de Trabajo</p>
                    <p class="font-medium text-gray-800 dark:text-white">{{ $employee->work_schedule_from }} - {{ $employee->work_schedule_to }}</p>
                </div>
                <div class="transform transition-all duration-200 hover:scale-[1.02]">
                    <p class="text-sm text-gray-500 dark:text-gray-400">Sueldo Básico</p>
                    <p class="font-medium text-gray-800 dark:text-white">${{ number_format($employee->base_salary, 2, ',', '.') }}</p>
                </div>
                <div class="transform transition-all duration-200 hover:scale-[1.02]">
                    <p class="text-sm text-gray-500 dark:text-gray-400">Obra Social</p>
                    <p class="font-medium text-gray-800 dark:text-white">{{ $employee->health_insurance ?? 'No especificada' }}</p>
                </div>
                <div class="transform transition-all duration-200 hover:scale-[1.02]">
                    <p class="text-sm text-gray-500 dark:text-gray-400">Sindicato</p>
                    <p class="font-medium text-gray-800 dark:text-white">{{ $employee->union ?? 'No especificado' }}</p>
                </div>
            </div>
        </div>

        <!-- Card Bancaria -->
        <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-lg p-6 border border-gray-200 dark:border-gray-800 transform transition-all duration-300 hover:shadow-xl">
            <div class="flex items-center gap-2 mb-6">
                <div class="p-2 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-lg shadow-lg">
                    <i class="fa-solid fa-building-columns text-xl text-white"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-800 dark:text-white">Datos Bancarios</h3>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div class="transform transition-all duration-200 hover:scale-[1.02]">
                    <p class="text-sm text-gray-500 dark:text-gray-400">Banco</p>
                    <p class="font-medium text-gray-800 dark:text-white">{{ $employee->bank_name ?? 'No especificado' }}</p>
                </div>
                <div class="transform transition-all duration-200 hover:scale-[1.02]">
                    <p class="text-sm text-gray-500 dark:text-gray-400">Cuenta Bancaria</p>
                    <p class="font-medium text-gray-800 dark:text-white">{{ $employee->bank_account ?? 'No especificada' }}</p>
                </div>
                <div class="col-span-2">
                    <p class="text-sm text-gray-500 dark:text-gray-400">Comprobante de CBU</p>
                    @if($employee->cbu_attachment)
                        <a href="{{ asset('storage/' . $employee->cbu_attachment) }}" target="_blank" class="inline-flex items-center gap-2 px-4 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-600 text-white text-sm font-semibold rounded-xl shadow-sm hover:from-indigo-600 hover:to-blue-600 transition-all duration-200 hover:scale-105 hover:shadow-md">
                            <i class="fa-solid fa-download"></i>
                            Descargar/Ver archivo
                        </a>
                    @else
                        <span class="text-gray-400 dark:text-gray-500">No adjuntado</span>
                    @endif
                </div>
            </div>
        </div>

        <!-- Card Familiar -->
        <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-lg p-6 border border-gray-200 dark:border-gray-800 transform transition-all duration-300 hover:shadow-xl">
            <div class="flex items-center gap-2 mb-6">
                <div class="p-2 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-lg shadow-lg">
                    <i class="fa-solid fa-users text-xl text-white"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-800 dark:text-white">Datos Familiares</h3>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div class="transform transition-all duration-200 hover:scale-[1.02]">
                    <p class="text-sm text-gray-500 dark:text-gray-400">Madre</p>
                    <p class="font-medium text-gray-800 dark:text-white">{{ $employee->mother_name ?? 'No especificada' }}</p>
                </div>
                <div class="transform transition-all duration-200 hover:scale-[1.02]">
                    <p class="text-sm text-gray-500 dark:text-gray-400">Padre</p>
                    <p class="font-medium text-gray-800 dark:text-white">{{ $employee->father_name ?? 'No especificado' }}</p>
                </div>
                <div class="transform transition-all duration-200 hover:scale-[1.02]">
                    <p class="text-sm text-gray-500 dark:text-gray-400">Cónyuge</p>
                    <p class="font-medium text-gray-800 dark:text-white">{{ $employee->spouse_name ?? 'No especificado' }}</p>
                </div>
                <div class="transform transition-all duration-200 hover:scale-[1.02]">
                    <p class="text-sm text-gray-500 dark:text-gray-400">Hijos</p>
                    <p class="font-medium text-gray-800 dark:text-white">{{ $employee->children ?? 'No especificados' }}</p>
                </div>
            </div>
        </div>

        <!-- Card Emergencia -->
        <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-lg p-6 border border-gray-200 dark:border-gray-800 transform transition-all duration-300 hover:shadow-xl">
            <div class="flex items-center gap-2 mb-6">
                <div class="p-2 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-lg shadow-lg">
                    <i class="fa-solid fa-phone text-xl text-white"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-800 dark:text-white">Contacto de Emergencia</h3>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div class="transform transition-all duration-200 hover:scale-[1.02]">
                    <p class="text-sm text-gray-500 dark:text-gray-400">Nombre</p>
                    <p class="font-medium text-gray-800 dark:text-white">{{ $employee->emergency_contact_name ?? 'No especificado' }}</p>
                </div>
                <div class="transform transition-all duration-200 hover:scale-[1.02]">
                    <p class="text-sm text-gray-500 dark:text-gray-400">Teléfono</p>
                    <p class="font-medium text-gray-800 dark:text-white">{{ $employee->emergency_contact_phone ?? 'No especificado' }}</p>
                </div>
            </div>
        </div>

        <!-- Card Notas -->
        <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-lg p-6 border border-gray-200 dark:border-gray-800 transform transition-all duration-300 hover:shadow-xl md:col-span-2">
            <div class="flex items-center gap-2 mb-6">
                <div class="p-2 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-lg shadow-lg">
                    <i class="fa-solid fa-note-sticky text-xl text-white"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-800 dark:text-white">Notas y Estado</h3>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Estado</p>
                    <div class="flex items-center gap-3">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold transform transition-all duration-200 hover:scale-105
                            @if($employee->is_active) bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300
                            @else bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300
                            @endif">
                            <span class="w-2 h-2 rounded-full mr-2 @if($employee->is_active) bg-green-500 @else bg-red-500 @endif"></span>
                            {{ $employee->is_active ? 'Activo' : 'Inactivo' }}
                        </span>
                        @if(!$employee->is_active && $employee->termination_date)
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300 transform transition-all duration-200 hover:scale-105">
                                <i class="fa-solid fa-calendar-xmark mr-2"></i>
                                {{ \Carbon\Carbon::parse($employee->termination_date)->format('d/m/Y') }}
                            </span>
                        @endif
                    </div>
                    @if(!$employee->is_active && $employee->termination_reason)
                        <div class="mt-3 text-sm text-gray-500 dark:text-gray-400 flex items-center gap-2">
                            <i class="fa-solid fa-circle-info text-gray-400"></i>
                            <span>Motivo: {{ $employee->termination_reason }}</span>
                        </div>
                    @endif
                </div>
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Notas</p>
                    <p class="font-medium text-gray-800 dark:text-white">{{ $employee->notes ?? 'Sin notas' }}</p>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    @keyframes fade-in {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in {
        animation: fade-in 0.5s ease-out;
    }
</style>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function confirmDeleteEmployee(e) {
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
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('delete-employee-form').submit();
        } else {
            Swal.fire({
                icon: 'info',
                title: 'Cancelado',
                text: 'El empleado no fue eliminado.',
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 2000
            });
        }
    });
}
@if(session('success'))
    Swal.fire({
        icon: 'success',
        title: '¡Éxito!',
        text: '{{ session('success') }}',
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 2500
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
        timer: 2500
    });
@endif
</script>
@endsection 