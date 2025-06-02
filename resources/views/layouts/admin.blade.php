<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'TSGroup') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/css/tom-select.css" rel="stylesheet">
    <script>
        // Modal functions
        function openCreateModal() {
            document.getElementById('createDepartmentModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeCreateModal() {
            document.getElementById('createDepartmentModal').classList.add('hidden');
            document.body.style.overflow = 'auto';
            if (document.getElementById('createDepartmentForm')) {
                document.getElementById('createDepartmentForm').reset();
                // Clear error messages
                document.querySelectorAll('[id$="-error"]').forEach(el => {
                    el.classList.add('hidden');
                    el.textContent = '';
                });
            }
        }

        // Delete confirmation
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

        // Form submission
        document.addEventListener('DOMContentLoaded', function() {
            const createDepartmentForm = document.getElementById('createDepartmentForm');
            if (createDepartmentForm) {
                createDepartmentForm.addEventListener('submit', function(e) {
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
            }
        });

        function openEditModal(department) {
            document.getElementById('edit-name').value = department.name || '';
            document.getElementById('edit-code').value = department.code || '';
            document.getElementById('edit-description').value = department.description || '';
            document.getElementById('edit-location').value = department.location || '';
            document.getElementById('edit-manager_id').value = department.manager_id || '';
            document.getElementById('edit-is_active').checked = department.is_active ? true : false;
            document.getElementById('editDepartmentForm').action = `/departments/${department.id}`;
            document.getElementById('editDepartmentModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
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

        document.addEventListener('DOMContentLoaded', function() {
            const editDepartmentForm = document.getElementById('editDepartmentForm');
            if (editDepartmentForm) {
                editDepartmentForm.addEventListener('submit', function(e) {
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
            }
        });
    </script>
    <style>
    .input-pro, .form-input-pro, select, textarea {
        border: 1.5px solid #e5e7eb;
        border-radius: 0.75rem;
        background: #f8fafc;
        padding: 0.85rem 1.2rem;
        font-size: 1.08rem;
        color: #374151;
        transition: border-color 0.2s, box-shadow 0.2s;
        box-shadow: 0 1px 4px 0 rgba(99,102,241,0.04);
        outline: none;
    }
    .input-pro:focus, .form-input-pro:focus, select:focus, textarea:focus {
        border-color: #6366f1;
        box-shadow: 0 0 0 3px #6366f133;
        background: #fff;
    }
    .input-pro[readonly], .form-input-pro[readonly] {
        background: #f1f5f9;
        color: #a1a1aa;
    }
    .error-message {
        color: #ef4444;
        font-size: 0.95rem;
        margin-top: 0.2rem;
        display: block;
    }
    </style>
</head>

<body class="min-h-screen font-sans antialiased" x-data="{ darkMode: localStorage.getItem('darkMode') === 'true', userMenu: false, showPasswordModal: false, redirecting: false, sidebarCollapsed: localStorage.getItem('sidebarCollapsed') === 'true' }" :class="darkMode ? 'bg-gray-900' : 'bg-gray-100'"
    x-init="$watch('darkMode', val => localStorage.setItem('darkMode', val));
    $watch('sidebarCollapsed', val => localStorage.setItem('sidebarCollapsed', val));
    @if(Auth::user()->force_password_change && !request()->is('password/change'))
    showPasswordModal = true;
    @endif">
    @if (Auth::user()->force_password_change && !request()->is('password/change'))
        <!-- Modal de Cambio de Contraseña -->
        <div x-show="showPasswordModal" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title"
            role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div x-show="showPasswordModal" x-transition:enter="ease-out duration-300"
                    x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                    x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0"
                    class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <div x-show="showPasswordModal" x-transition:enter="ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                    x-transition:leave="ease-in duration-200"
                    x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                    x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <form action="{{ route('password.change') }}" method="POST" class="p-6"
                        @submit="redirecting = true">
                        @csrf
                        <div>
                            <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white" id="modal-title">
                                Cambio de Contraseña Requerido
                            </h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500 dark:text-gray-400">
                                    Por seguridad, debes cambiar tu contraseña antes de continuar.
                                </p>
                            </div>
                        </div>

                        <div class="mt-4 space-y-4">
                            <div>
                                <label for="current_password"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Contraseña Actual
                                </label>
                                <input type="password" name="current_password" id="current_password" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            </div>

                            <div>
                                <label for="password"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Nueva Contraseña
                                </label>
                                <input type="password" name="password" id="password" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            </div>

                            <div>
                                <label for="password_confirmation"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Confirmar Nueva Contraseña
                                </label>
                                <input type="password" name="password_confirmation" id="password_confirmation" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            </div>
                        </div>

                        @if ($errors->any())
                            <div
                                class="mt-4 bg-red-50 dark:bg-red-900/50 border border-red-200 dark:border-red-800 rounded-md p-4">
                                <ul class="text-sm text-red-600 dark:text-red-400">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="mt-6">
                            <button type="submit"
                                class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:text-sm"
                                :disabled="redirecting">
                                <span x-show="!redirecting">Cambiar Contraseña</span>
                                <span x-show="redirecting" class="flex items-center">
                                    <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white"
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10"
                                            stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor"
                                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                        </path>
                                    </svg>
                                    Procesando...
                                </span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
    @include('components.sidebar')
    <div class="flex flex-col min-h-screen transition-all duration-300 ease-in-out" :class="[sidebarCollapsed ? 'ml-20' : 'ml-72', darkMode ? 'bg-gray-900' : 'bg-gray-100']">
        @include('components.topbar')
        <main class="flex-1 p-8 overflow-y-auto" :class="darkMode ? 'bg-gray-900 text-white' : 'bg-gray-100 text-gray-900'" style="height:calc(100vh - 5rem)">
            @yield('content')
        </main>
    </div>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/js/tom-select.complete.min.js"></script>
    @stack('scripts')
    <script>
        // Manejo de mensajes flash con SweetAlert2
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: '¡Éxito!',
                text: '{{ session('success') }}',
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true
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
                timer: 3000,
                timerProgressBar: true
            });
        @endif
    </script>
</body>

</html>
