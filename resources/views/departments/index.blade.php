@extends('layouts.admin')

@section('content')
<div class="w-full mx-auto px-4 md:px-6 lg:px-8 py-6">
    <!-- Header -->
    <div class="flex flex-col md:flex-row items-center justify-between bg-white dark:bg-gray-900 rounded-2xl shadow-lg p-8 mb-8 border border-gray-200 dark:border-gray-800 transform transition-all duration-300 hover:shadow-xl">
        <div class="flex items-center gap-4 mb-4 md:mb-0">
            <div class="p-3 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl shadow-lg">
                <i class="fa-solid fa-building text-2xl text-white"></i>
            </div>
            <div>
                <h1 class="text-3xl md:text-4xl font-extrabold text-gray-800 dark:text-white tracking-tight">Departamentos</h1>
                <p class="text-gray-500 dark:text-gray-400 mt-1">Gestión de departamentos</p>
            </div>
        </div>
        <button onclick="openCreateModal()" class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white text-lg font-semibold rounded-xl shadow-lg hover:scale-105 hover:from-indigo-600 hover:to-blue-600 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-blue-400">
            <i class="fa-solid fa-plus text-xl"></i>
            Nuevo departamento
        </button>
    </div>

    @if(session('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-800 rounded-lg flex items-center">
            <i class="fa-solid fa-circle-check mr-2"></i>
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="mb-4 p-4 bg-red-100 text-red-800 rounded-lg flex items-center">
            <i class="fa-solid fa-circle-exclamation mr-2"></i>
            {{ session('error') }}
        </div>
    @endif

    <!-- Table -->
    <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-lg overflow-hidden border border-gray-200 dark:border-gray-800 transform transition-all duration-300 hover:shadow-xl">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-800">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Nombre</th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Código</th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Manager</th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Ubicación</th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Estado</th>
                        <th class="px-6 py-4 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-900 divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($departments as $department)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-800 transition-all duration-200">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        <div class="h-10 w-10 rounded-full bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center text-white font-bold">
                                            {{ substr($department->name, 0, 1) }}
                                        </div>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $department->name }}</div>
                                        @if($department->description)
                                            <div class="text-sm text-gray-500 dark:text-gray-400">{{ Str::limit($department->description, 30) }}</div>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-bold bg-blue-50 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300">
                                    {{ $department->code }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                {{ $department->manager ? $department->manager->first_name . ' ' . $department->manager->last_name : '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                {{ $department->location ?? '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full {{ $department->is_active ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300' : 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300' }}">
                                    {{ $department->is_active ? 'Activo' : 'Inactivo' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('departments.show', $department) }}" class="group flex items-center justify-center w-9 h-9 rounded-lg bg-indigo-50 dark:bg-indigo-900/30 hover:bg-indigo-100 dark:hover:bg-indigo-900/50 shadow-sm transition-all duration-200" title="Ver Detalles">
                                        <i class="fa-solid fa-eye text-indigo-600 dark:text-indigo-300 text-sm group-hover:scale-110 transition-transform"></i>
                                    </a>
                                    <a href="#" onclick="openEditModal({{ $department }})" class="group flex items-center justify-center w-9 h-9 rounded-lg bg-blue-50 dark:bg-blue-900/30 hover:bg-blue-100 dark:hover:bg-blue-900/50 shadow-sm transition-all duration-200" title="Editar">
                                        <i class="fa-solid fa-pen text-blue-600 dark:text-blue-300 text-sm group-hover:scale-110 transition-transform"></i>
                                    </a>
                                    <form action="{{ route('departments.destroy', $department) }}" method="POST" class="inline-block" onsubmit="return confirmDelete(event)">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="group flex items-center justify-center w-9 h-9 rounded-lg bg-red-50 dark:bg-red-900/30 hover:bg-red-100 dark:hover:bg-red-900/50 shadow-sm transition-all duration-200" title="Eliminar">
                                            <i class="fa-solid fa-trash text-red-600 dark:text-red-300 text-sm group-hover:scale-110 transition-transform"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center">
                                <div class="flex flex-col items-center justify-center text-gray-500 dark:text-gray-400">
                                    <i class="fa-solid fa-building text-4xl mb-3 text-gray-300 dark:text-gray-600"></i>
                                    <p class="text-lg font-medium">No hay departamentos registrados</p>
                                    <p class="text-sm mt-1">Comienza agregando un nuevo departamento</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 bg-white dark:bg-gray-900 border-t border-gray-200 dark:border-gray-700 flex justify-center">
            {{ $departments->links() }}
        </div>
    </div>
</div>

<!-- Create Department Modal -->
<div id="createDepartmentModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center z-50 hidden" aria-modal="true">
    <div class="w-full max-w-2xl p-5 border shadow-lg rounded-2xl bg-white dark:bg-gray-900">
        <div class="flex justify-between items-center pb-3 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-2xl font-bold text-gray-800 dark:text-white">Nuevo Departamento</h3>
            <button onclick="closeCreateModal()" class="text-gray-400 hover:text-gray-500 dark:hover:text-gray-300">
                <i class="fa-solid fa-xmark text-2xl"></i>
            </button>
        </div>

        <form id="createDepartmentForm" action="{{ route('departments.store') }}" method="POST" class="mt-4 space-y-6">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Nombre *</label>
                    <input type="text" name="name" class="w-full px-4 py-2.5 rounded-xl border border-gray-300 dark:border-gray-700 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-800 dark:text-gray-100" required>
                    <div class="text-red-600 text-xs mt-1 hidden" id="name-error"></div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Código *</label>
                    <input type="text" name="code" class="w-full px-4 py-2.5 rounded-xl border border-gray-300 dark:border-gray-700 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-800 dark:text-gray-100" required>
                    <div class="text-red-600 text-xs mt-1 hidden" id="code-error"></div>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Descripción</label>
                <textarea name="description" rows="2" class="w-full px-4 py-2.5 rounded-xl border border-gray-300 dark:border-gray-700 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-800 dark:text-gray-100"></textarea>
                <div class="text-red-600 text-xs mt-1 hidden" id="description-error"></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Manager</label>
                    <select name="manager_id" class="w-full px-4 py-2.5 rounded-xl border border-gray-300 dark:border-gray-700 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-800 dark:text-gray-100">
                        <option value="">Sin asignar</option>
                        @foreach($employees as $employee)
                            <option value="{{ $employee->id }}">{{ $employee->first_name }} {{ $employee->last_name }}</option>
                        @endforeach
                    </select>
                    <div class="text-red-600 text-xs mt-1 hidden" id="manager_id-error"></div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Ubicación</label>
                    <input type="text" name="location" class="w-full px-4 py-2.5 rounded-xl border border-gray-300 dark:border-gray-700 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-800 dark:text-gray-100">
                    <div class="text-red-600 text-xs mt-1 hidden" id="location-error"></div>
                </div>
            </div>

            <div class="flex items-center gap-4">
                <label class="inline-flex items-center">
                    <input type="checkbox" name="is_active" value="1" class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500" checked>
                    <span class="ml-2 text-gray-700 dark:text-gray-300">Activo</span>
                </label>
            </div>

            <div class="flex justify-end gap-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                <button type="button" onclick="closeCreateModal()" class="px-6 py-2.5 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-xl hover:bg-gray-300 dark:hover:bg-gray-600 transition-all duration-200">
                    Cancelar
                </button>
                <button type="submit" class="px-6 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-xl hover:from-indigo-600 hover:to-blue-600 transition-all duration-200 font-semibold">
                    Guardar
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Edit Department Modal -->
<div id="editDepartmentModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center z-50 hidden" aria-modal="true">
    <div class="w-full max-w-2xl p-5 border shadow-lg rounded-2xl bg-white dark:bg-gray-900">
        <div class="flex justify-between items-center pb-3 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-2xl font-bold text-gray-800 dark:text-white">Editar Departamento</h3>
            <button onclick="closeEditModal()" class="text-gray-400 hover:text-gray-500 dark:hover:text-gray-300">
                <i class="fa-solid fa-xmark text-2xl"></i>
            </button>
        </div>
        <form id="editDepartmentForm" method="POST" class="mt-4 space-y-6">
            @csrf
            @method('PATCH')
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Nombre *</label>
                    <input type="text" name="name" id="edit-name" class="w-full px-4 py-2.5 rounded-xl border border-gray-300 dark:border-gray-700 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-800 dark:text-gray-100" required>
                    <div class="text-red-600 text-xs mt-1 hidden" id="edit-name-error"></div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Código *</label>
                    <input type="text" name="code" id="edit-code" class="w-full px-4 py-2.5 rounded-xl border border-gray-300 dark:border-gray-700 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-800 dark:text-gray-100" required>
                    <div class="text-red-600 text-xs mt-1 hidden" id="edit-code-error"></div>
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Descripción</label>
                <textarea name="description" id="edit-description" rows="2" class="w-full px-4 py-2.5 rounded-xl border border-gray-300 dark:border-gray-700 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-800 dark:text-gray-100"></textarea>
                <div class="text-red-600 text-xs mt-1 hidden" id="edit-description-error"></div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Manager</label>
                    <select name="manager_id" id="edit-manager_id" class="w-full px-4 py-2.5 rounded-xl border border-gray-300 dark:border-gray-700 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-800 dark:text-gray-100">
                        <option value="">Sin asignar</option>
                        @foreach($employees as $employee)
                            <option value="{{ $employee->id }}">{{ $employee->first_name }} {{ $employee->last_name }}</option>
                        @endforeach
                    </select>
                    <div class="text-red-600 text-xs mt-1 hidden" id="edit-manager_id-error"></div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Ubicación</label>
                    <input type="text" name="location" id="edit-location" class="w-full px-4 py-2.5 rounded-xl border border-gray-300 dark:border-gray-700 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-800 dark:text-gray-100">
                    <div class="text-red-600 text-xs mt-1 hidden" id="edit-location-error"></div>
                </div>
            </div>
            <div class="flex items-center gap-4">
                <label class="inline-flex items-center">
                    <input type="checkbox" name="is_active" id="edit-is_active" value="1" class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500">
                    <span class="ml-2 text-gray-700 dark:text-gray-300">Activo</span>
                </label>
            </div>
            <div class="flex justify-end gap-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                <button type="button" onclick="closeEditModal()" class="px-6 py-2.5 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-xl hover:bg-gray-300 dark:hover:bg-gray-600 transition-all duration-200">
                    Cancelar
                </button>
                <button type="submit" class="px-6 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-xl hover:from-indigo-600 hover:to-blue-600 transition-all duration-200 font-semibold">
                    Actualizar
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
function openCreateModal() {
    document.getElementById('createDepartmentModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeCreateModal() {
    document.getElementById('createDepartmentModal').classList.add('hidden');
    document.body.style.overflow = 'auto';
    document.getElementById('createDepartmentForm').reset();
    // Clear error messages
    document.querySelectorAll('[id$="-error"]').forEach(el => {
        el.classList.add('hidden');
        el.textContent = '';
    });
}

function confirmDelete(event) {
    event.preventDefault();
    const form = event.target;
    
    Swal.fire({
        title: '¿Estás seguro?',
        text: 'Esta acción eliminará permanentemente el departamento y no se podrá deshacer.',
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
            form.submit();
        }
    });
}

document.getElementById('createDepartmentForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    
    fetch(this.action, {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            Swal.fire({
                icon: 'success',
                title: 'Éxito',
                text: data.message,
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 2000,
                customClass: {
                    popup: 'rounded-xl'
                }
            }).then(() => {
                window.location.reload();
            });
        } else {
            // Show validation errors
            Object.keys(data.errors).forEach(field => {
                const errorElement = document.getElementById(`${field}-error`);
                if (errorElement) {
                    errorElement.textContent = data.errors[field][0];
                    errorElement.classList.remove('hidden');
                }
            });
        }
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Ha ocurrido un error al crear el departamento.',
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 2000,
            customClass: {
                popup: 'rounded-xl'
            }
        });
    });
});

function openEditModal(department) {
    // Rellenar los campos del modal con los datos del departamento
    document.getElementById('edit-name').value = department.name || '';
    document.getElementById('edit-code').value = department.code || '';
    document.getElementById('edit-description').value = department.description || '';
    document.getElementById('edit-location').value = department.location || '';
    document.getElementById('edit-manager_id').value = department.manager_id || '';
    document.getElementById('edit-is_active').checked = department.is_active ? true : false;
    // Setear la acción del formulario
    document.getElementById('editDepartmentForm').action = `/departments/${department.id}`;
    document.getElementById('editDepartmentModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
    // Limpiar errores
    document.querySelectorAll('[id^="edit-"][id$="-error"]').forEach(el => {
        el.classList.add('hidden');
        el.textContent = '';
    });
}

function closeEditModal() {
    document.getElementById('editDepartmentModal').classList.add('hidden');
    document.body.style.overflow = 'auto';
    document.getElementById('editDepartmentForm').reset();
    document.querySelectorAll('[id^="edit-"][id$="-error"]').forEach(el => {
        el.classList.add('hidden');
        el.textContent = '';
    });
}

document.getElementById('editDepartmentForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const formData = new FormData(this);
    formData.append('_method', 'PATCH');
    fetch(this.action, {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            Swal.fire({
                icon: 'success',
                title: 'Éxito',
                text: data.message,
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 2000,
                customClass: {
                    popup: 'rounded-xl'
                }
            }).then(() => {
                window.location.reload();
            });
        } else {
            // Mostrar errores de validación
            Object.keys(data.errors).forEach(field => {
                const errorElement = document.getElementById(`edit-${field}-error`);
                if (errorElement) {
                    errorElement.textContent = data.errors[field][0];
                    errorElement.classList.remove('hidden');
                }
            });
        }
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Ha ocurrido un error al actualizar el departamento.',
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 2000,
            customClass: {
                popup: 'rounded-xl'
            }
        });
    });
});
</script>
@endsection 