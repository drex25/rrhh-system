@extends('layouts.admin')

@section('content')
<div class="w-full mx-auto mt-8">
    <!-- Header -->
    <div class="flex flex-col md:flex-row items-center justify-between bg-white rounded-xl shadow p-6 mb-8">
        <div class="flex items-center gap-6">
            @if($employee->profile_photo)
                <img src="{{ asset('storage/' . $employee->profile_photo) }}" class="w-28 h-28 rounded-full object-cover border-4 border-indigo-100 shadow" alt="Foto">
            @else
                <div class="w-28 h-28 rounded-full bg-gray-200 flex items-center justify-center text-4xl text-gray-400 border-4 border-indigo-100 shadow">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-16 h-16"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 15c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                </div>
            @endif
            <div>
                <h2 class="text-3xl font-bold text-gray-800">{{ $employee->first_name }} {{ $employee->last_name }}</h2>
                <span class="inline-block mt-2 px-3 py-1 rounded-full text-sm font-semibold {{ $employee->is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                    {{ $employee->is_active ? 'Activo' : 'Inactivo' }}
                </span>
            </div>
        </div>
        <div class="flex gap-2 mt-4 md:mt-0">
            <a href="{{ route('employees.edit', $employee) }}" class="inline-flex items-center gap-2 px-4 py-2 min-w-[180px] bg-blue-600 text-white rounded-lg hover:bg-blue-700 shadow transition @if(!$employee->is_active) opacity-50 cursor-not-allowed pointer-events-none @endif" @if(!$employee->is_active) title="No se puede editar un empleado dado de baja" @endif>
                <i class="fa-solid fa-pen fa-lg"></i>
                Editar
            </a>
            <a href="{{ route('employee-leave-balances.index', ['employee' => $employee->id]) }}" class="inline-flex items-center gap-2 px-4 py-2 min-w-[180px] bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 shadow transition">
                <i class="fa-solid fa-calendar-days fa-lg"></i>
                Saldos de Licencia
            </a>
            @role('Admin')
                <form id="delete-employee-form" action="{{ route('employees.destroy', $employee) }}" method="POST" style="display: contents;">
                    @csrf
                    @method('DELETE')
                    <a href="#" onclick="confirmDeleteEmployee(event)" class="inline-flex items-center gap-2 px-4 py-2 min-w-[180px] bg-red-600 text-white rounded-lg hover:bg-red-700 shadow transition">
                        <i class="fa-solid fa-xmark fa-lg"></i>
                        Eliminar
                    </a>
                </form>
            @endrole
            @if($employee->is_active)
                <a href="{{ route('employees.bajaForm', $employee) }}" class="inline-flex items-center gap-2 px-4 py-2 min-w-[180px] bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 shadow transition">
                    <i class="fa-solid fa-arrow-right fa-lg"></i>
                    Dar de baja
                </a>
            @endif
        </div>
    </div>
    <div class="flex justify-end mb-6">
        <a href="{{ route('employees.downloadPdf', $employee->id) }}" target="_blank" class="inline-flex items-center px-5 py-2 bg-blue-600 text-white font-semibold rounded-lg shadow hover:bg-blue-700 transition">
            <i class="fa fa-file-pdf mr-2"></i> Imprimir/Descargar PDF
        </a>
    </div>
    <!-- Secciones en grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Card Personal -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center gap-2 mb-4">
                <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5.121 17.804A13.937 13.937 0 0112 15c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                <h3 class="font-semibold text-lg text-gray-700">Datos Personales</h3>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div><p class="text-sm text-gray-600">Nro. de Legajo</p><p class="font-medium">{{ $employee->file_number }}</p></div>
                <div><p class="text-sm text-gray-600">DNI</p><p class="font-medium">{{ $employee->dni }}</p></div>
                <div><p class="text-sm text-gray-600">CUIT</p><p class="font-medium">{{ $employee->cuit }}</p></div>
                <div><p class="text-sm text-gray-600">Fecha de Nacimiento</p><p class="font-medium">{{ $employee->birth_date->format('d/m/Y') }}</p></div>
                <div><p class="text-sm text-gray-600">País</p><p class="font-medium">{{ $employee->birth_country ?? 'No especificado' }}</p></div>
                <div><p class="text-sm text-gray-600">Provincia</p><p class="font-medium">{{ $employee->birth_province_name }}</p></div>
                <div><p class="text-sm text-gray-600">Ciudad</p><p class="font-medium">{{ $employee->birth_city ?? 'No especificada' }}</p></div>
                <div><p class="text-sm text-gray-600">Nacionalidad</p><p class="font-medium">{{ $employee->nationality ?? 'No especificada' }}</p></div>
                <div><p class="text-sm text-gray-600">Genero</p><p class="font-medium">{{ $employee->gender ?? 'No especificado' }}</p></div>
                <div><p class="text-sm text-gray-600">Dirección</p><p class="font-medium">{{ $employee->address }}</p></div>
                <div><p class="text-sm text-gray-600">Teléfono</p><p class="font-medium">{{ $employee->phone }}</p></div>
                <div><p class="text-sm text-gray-600">Email</p><p class="font-medium">{{ $employee->email }}</p></div>
            </div>
        </div>
        <!-- Card Laboral -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center gap-2 mb-4">
                <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9.75 17L9 21m5.25-4l.75 4m-8.5 0h12.5M4 21V5a2 2 0 012-2h12a2 2 0 012 2v16" /></svg>
                <h3 class="font-semibold text-lg text-gray-700">Datos Laborales</h3>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div><p class="text-sm text-gray-600">Departamento</p><p class="font-medium">{{ $employee->department->name }}</p></div>
                <div><p class="text-sm text-gray-600">Posición</p><p class="font-medium">{{ $employee->position->title }}</p></div>
                <div><p class="text-sm text-gray-600">Fecha de Ingreso</p><p class="font-medium">{{ $employee->hire_date->format('d/m/Y') }}</p></div>
                <div><p class="text-sm text-gray-600">Tipo de Contratación</p><p class="font-medium">{{ $employee->employment_type }}</p></div>
                <div><p class="text-sm text-gray-600">Horario de Trabajo</p><p class="font-medium">{{ $employee->work_schedule_from }} - {{ $employee->work_schedule_to }}</p></div>
                <div><p class="text-sm text-gray-600">Sueldo Básico</p><p class="font-medium">${{ number_format($employee->base_salary, 2, ',', '.') }}</p></div>
                <div><p class="text-sm text-gray-600">Obra Social</p><p class="font-medium">{{ $employee->health_insurance ?? 'No especificada' }}</p></div>
                <div><p class="text-sm text-gray-600">Sindicato</p><p class="font-medium">{{ $employee->union ?? 'No especificado' }}</p></div>
            </div>
        </div>
        <!-- Card Bancaria -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center gap-2 mb-4">
                <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 1.343-3 3s1.343 3 3 3 3-1.343 3-3-1.343-3-3-3zm0 0V4m0 10v4m8-8h2a2 2 0 012 2v8a2 2 0 01-2 2H4a2 2 0 01-2-2v-8a2 2 0 012-2h2" /></svg>
                <h3 class="font-semibold text-lg text-gray-700">Datos Bancarios</h3>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div><p class="text-sm text-gray-600">Banco</p><p class="font-medium">{{ $employee->bank_name ?? 'No especificado' }}</p></div>
                <div><p class="text-sm text-gray-600">Cuenta Bancaria</p><p class="font-medium">{{ $employee->bank_account ?? 'No especificada' }}</p></div>
                <div class="col-span-2">
                    <p class="text-sm text-gray-600">Comprobante de CBU</p>
                    @if($employee->cbu_attachment)
                        <a href="{{ asset('storage/' . $employee->cbu_attachment) }}" target="_blank" class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 shadow transition">
                            <i class="fa-solid fa-download"></i> Descargar/Ver archivo
                        </a>
                    @else
                        <span class="text-gray-400">No adjuntado</span>
                    @endif
                </div>
            </div>
        </div>
        <!-- Card Familiar -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center gap-2 mb-4">
                <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87m9-5a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                <h3 class="font-semibold text-lg text-gray-700">Datos Familiares</h3>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div><p class="text-sm text-gray-600">Madre</p><p class="font-medium">{{ $employee->mother_name ?? 'No especificada' }}</p></div>
                <div><p class="text-sm text-gray-600">Padre</p><p class="font-medium">{{ $employee->father_name ?? 'No especificado' }}</p></div>
                <div><p class="text-sm text-gray-600">Cónyuge</p><p class="font-medium">{{ $employee->spouse_name ?? 'No especificado' }}</p></div>
                <div><p class="text-sm text-gray-600">Hijos</p><p class="font-medium">{{ $employee->children ?? 'No especificados' }}</p></div>
            </div>
        </div>
        <!-- Card Emergencia -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center gap-2 mb-4">
                <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m4 0h-1v-4h-1m-4 0h-1v-4h-1" /></svg>
                <h3 class="font-semibold text-lg text-gray-700">Contacto de Emergencia</h3>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div><p class="text-sm text-gray-600">Nombre</p><p class="font-medium">{{ $employee->emergency_contact_name ?? 'No especificado' }}</p></div>
                <div><p class="text-sm text-gray-600">Teléfono</p><p class="font-medium">{{ $employee->emergency_contact_phone ?? 'No especificado' }}</p></div>
            </div>
        </div>
        <!-- Card Notas -->
        <div class="bg-white rounded-lg shadow p-6 md:col-span-2">
            <div class="flex items-center gap-2 mb-4">
                <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 17l4 4 4-4m0-5V3a1 1 0 00-1-1H7a1 1 0 00-1 1v9" /></svg>
                <h3 class="font-semibold text-lg text-gray-700">Notas y Estado</h3>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <p class="text-sm text-gray-600">Estado</p>
                    <p class="font-medium">
                        <span class="px-2 py-1 rounded text-sm {{ $employee->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $employee->is_active ? 'Activo' : 'Inactivo' }}
                        </span>
                    </p>
                    @if(!$employee->is_active && $employee->termination_date)
                        <div class="mt-3 flex items-center gap-2 text-red-700">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7" /></svg>
                            <span class="font-semibold">Baja:</span>
                            <span class="bg-red-100 text-red-800 px-2 py-1 rounded text-xs">{{ \Carbon\Carbon::parse($employee->termination_date)->format('d/m/Y') }}</span>
                        </div>
                        @if($employee->termination_reason)
                            <div class="mt-1 text-sm text-gray-500 flex items-center gap-2">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 13h6m-3-3v6" /></svg>
                                <span>Motivo: {{ $employee->termination_reason }}</span>
                            </div>
                        @endif
                    @endif
                </div>
                <div>
                    <p class="text-sm text-gray-600">Notas</p>
                    <p class="font-medium">{{ $employee->notes ?? 'Sin notas' }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
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