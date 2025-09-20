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
    <!-- Quill CSS -->
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet">
    <!-- Quill JS -->
    <script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <x-head.tinymce-config/>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/css/tom-select.css" rel="stylesheet">
    <style>
        [x-cloak] { display: none !important; }
        
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
</head>

<body class="min-h-screen font-sans antialiased" 
    x-data="{ 
        darkMode: localStorage.getItem('darkMode') === 'true', 
        userMenu: false, 
        showPasswordModal: false, 
        redirecting: false, 
        sidebarCollapsed: localStorage.getItem('sidebarCollapsed') === 'true',
        sidebarOpen: false
    }" 
    :class="darkMode ? 'dark bg-gray-900' : 'bg-gray-100'"
    x-init="
        $watch('darkMode', val => {
            localStorage.setItem('darkMode', val);
            document.documentElement.classList.toggle('dark', val);
        });
        $watch('sidebarCollapsed', val => localStorage.setItem('sidebarCollapsed', val));
        // Cerrar drawer en ESC
        window.addEventListener('keydown', (e) => { if (e.key === 'Escape') sidebarOpen = false; });
        // Ajustar estado al cambiar tamaño
        window.addEventListener('resize', () => { if (window.innerWidth >= 1024) sidebarOpen = false; });
        @if(Auth::user()->force_password_change && !request()->is('password/change'))
        showPasswordModal = true;
        @endif
    "
>
    <div x-cloak x-show="true">
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
                                        <li>
                                            <a href="/admin/companies" class="flex items-center px-4 py-2 text-sm font-medium rounded-md text-gray-300 hover:text-white hover:bg-gray-700">
                                                <span class="material-icons-outlined text-base mr-3">business</span>
                                                Companies
                                            </a>
                                        </li>
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
    <!-- Overlay para mobile -->
    <div x-show="sidebarOpen" x-cloak class="fixed inset-0 z-20 bg-black/50 lg:hidden" @click="sidebarOpen = false"></div>
    <div class="flex flex-col min-h-screen transition-all duration-300 ease-in-out" :class="[sidebarCollapsed ? 'lg:ml-20' : 'lg:ml-72', darkMode ? 'bg-gray-900' : 'bg-gray-100']">
            @include('components.topbar')
            @auth
            <div class="px-8 pt-4" x-data="companySwitcher" x-cloak>
                <template x-if="companies.length">
                    <div class="inline-block relative mb-4">
                        <button @click="open = !open" class="px-3 py-2 bg-gray-100 dark:bg-gray-800 text-sm rounded-md flex items-center gap-2 border dark:border-gray-700">
                            <span class="font-medium" x-text="currentCompany ? currentCompany.name : 'Compañía'"></span>
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" /></svg>
                        </button>
                        <div x-show="open" @click.outside="open=false" class="absolute z-50 mt-2 w-60 rounded-md shadow-lg bg-white dark:bg-gray-800 ring-1 ring-black ring-opacity-5">
                            <div class="py-1 max-h-64 overflow-auto">
                                <template x-for="c in companies" :key="c.id">
                                    <button @click="switchCompany(c.id)" type="button" class="w-full text-left px-4 py-2 text-sm flex justify-between items-center hover:bg-gray-100 dark:hover:bg-gray-700"
                                        :class="{'bg-blue-50 dark:bg-gray-700': currentCompany && currentCompany.id === c.id}">
                                        <span x-text="c.name"></span>
                                        <span x-show="currentCompany && currentCompany.id === c.id" class="text-blue-500"><i class="fa fa-check"></i></span>
                                    </button>
                                </template>
                            </div>
                        </div>
                    </div>
                </template>
            </div>
            @endauth
            <main class="flex-1 p-8 overflow-y-auto" :class="darkMode ? 'bg-gray-900 text-white' : 'bg-gray-100 text-gray-900'" style="height:calc(100vh - 5rem)">
                @yield('content')
            </main>
        </div>
    </div>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/js/tom-select.complete.min.js"></script>
    @stack('scripts')
    <script>
    document.addEventListener('alpine:init', () => {
        if (!Alpine.store('companySwitcherRegistered')) {
            Alpine.store('companySwitcherRegistered', true);
            Alpine.data('companySwitcher', () => ({
                open:false, companies:[], currentCompany:null,
                init(){ this.fetchCurrent(); this.fetchCompanies(); },
                async fetchCurrent(){ try{ const {data}= await axios.get('/api/company/current'); this.currentCompany=data.data; }catch(e){console.error(e);} },
                async fetchCompanies(){ try{ const {data}= await axios.get('/api/companies/mine'); this.companies=data.data; }catch(e){console.error(e);} },
                async switchCompany(id){ if(!id || (this.currentCompany && this.currentCompany.id===id)){ this.open=false; return;} try{ await axios.post('/api/company/switch',{company_id:id}); await this.fetchCurrent(); this.open=false; window.location.reload(); }catch(e){ console.error(e); alert('No se pudo cambiar de compañía'); } }
            }));
        }
    });
    </script>
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
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Tom Select para entrevistadores
        if(document.getElementById('interviewers')) {
            new TomSelect('#interviewers', {
                plugins: ['remove_button'],
                persist: false,
                create: false,
                maxItems: null,
                searchField: ['text'],
                placeholder: 'Buscar y seleccionar entrevistadores...'
            });
        }

        // Quill para campos de texto enriquecido
        const quillFields = [
            { editor: '#description-editor', input: '#description' },
            { editor: '#requirements-editor', input: '#requirements' },
            { editor: '#responsibilities-editor', input: '#responsibilities' },
            { editor: '#benefits-editor', input: '#benefits' }
        ];
        let quillInstances = {};
        quillFields.forEach(function(field) {
            if(document.querySelector(field.editor)) {
                quillInstances[field.input] = new Quill(field.editor, { theme: 'snow' });
            }
        });
        // Copiar contenido de Quill a los inputs antes de enviar el formulario
        const form = document.querySelector('form');
        if(form) {
            form.addEventListener('submit', function() {
                Object.keys(quillInstances).forEach(function(inputId) {
                    const quill = quillInstances[inputId];
                    if(document.querySelector(inputId)) {
                        document.querySelector(inputId).value = quill.root.innerHTML;
                    }
                });
            });
        }
    });
    </script>
</body>

</html>
