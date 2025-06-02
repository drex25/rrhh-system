<style>
    .sidebar-pro { scrollbar-width: none !important; -ms-overflow-style: none !important; }
    .sidebar-logo img { height: 100% !important; max-height: 80px !important; width: auto !important; object-fit: contain; margin: 0 !important; padding: 0 !important; display: block; }
    .sidebar-logo { padding: 0 !important; margin: 0 !important; height: 80px !important; position: sticky; top: 0; z-index: 40; background: inherit; }
    .sidebar-nav-scroll {
        flex: 1 1 0%;
        overflow-y: auto;
        overflow-x: hidden;
        scrollbar-width: none; /* Firefox */
        -ms-overflow-style: none; /* IE 10+ */
    }
    .sidebar-nav-scroll::-webkit-scrollbar {
        display: none; /* Chrome/Safari */
    }
    .sidebar-link {
        font-size: 1rem; /* text-base */
        font-weight: 500; /* font-medium */
        color: #1e293b; /* text-blue-900 */
    }
    [data-theme="dark"] .sidebar-link {
        color: #fff;
    }
</style>
<aside class="fixed z-30 inset-y-0 left-0 transition-all duration-300 ease-in-out" :class="sidebarCollapsed ? 'w-20' : 'w-72'">
    <div :class="darkMode ? 'bg-[#181F2A] border-[#232B3E]' : 'bg-white border-gray-200'" class="flex flex-col h-screen border-r sidebar-pro" style="scrollbar-width: none;">
        <div :class="darkMode ? 'bg-[#232B3E] border-[#232B3E]' : 'bg-white border-gray-200'" class="flex items-center justify-center h-20 border-b sidebar-logo">
            <template x-if="!sidebarCollapsed">
                <img src="/images/tsg.png" alt="TSGroup Logo">
            </template>
            <template x-if="sidebarCollapsed">
                <img src="/images/favicon.png" alt="TSGroup Favicon" class="w-10 h-10 object-contain">
            </template>
        </div>
        <nav class="sidebar-nav-scroll py-6 space-y-2">
            <!-- Dashboard -->
            @php
                $isActive = request()->is('dashboard');
                $baseClasses = 'flex items-center rounded-none transition-all duration-200 group relative border-l-4 sidebar-link';
                $activeClasses = $isActive ? 'border-blue-500 bg-blue-50 text-blue-900 dark:bg-[#181F2A] dark:text-white shadow-md' : 'border-transparent text-blue-900 hover:bg-blue-100 dark:text-white dark:hover:bg-[#232B3E] hover:border-blue-400';
            @endphp
            <a href="/dashboard"
               :class="sidebarCollapsed ? 'justify-center px-0 py-3 border-l-0' : 'gap-4 px-4 py-3'"
               class="{{ $baseClasses }} {{ $activeClasses }}"
               x-data="{ tooltip: false }"
               @mouseenter="if(sidebarCollapsed) tooltip = true"
               @mouseleave="tooltip = false">
                <i class="fa-solid fa-gauge-high text-xl"></i>
                <span x-show="!sidebarCollapsed">Panel</span>
                <span x-show="tooltip" :class="darkMode ? 'bg-[#232B3E] text-white' : 'bg-gray-200 text-blue-900'" class="absolute left-full ml-2 px-2 py-1 rounded text-xs z-50" x-cloak>Panel</span>
            </a>
            <!-- Gestión -->
            @role('Admin|HR')
            <div class="mt-6 mb-2 text-xs text-gray-400 uppercase pl-2 tracking-widest" x-show="!sidebarCollapsed">Gestión</div>
            @php
                $isActive = request()->is('employees*');
                $activeClasses = $isActive ? 'border-blue-500 bg-blue-50 text-blue-900 dark:bg-[#181F2A] dark:text-white shadow-md' : 'border-transparent text-blue-900 hover:bg-blue-100 dark:text-white dark:hover:bg-[#232B3E] hover:border-blue-400';
            @endphp
            <a href="{{ route('employees.index') }}"
               :class="sidebarCollapsed ? 'justify-center px-0 py-3 border-l-0' : 'gap-4 px-4 py-3'"
               class="{{ $baseClasses }} {{ $activeClasses }}"
               x-data="{ tooltip: false }"
               @mouseenter="if(sidebarCollapsed) tooltip = true"
               @mouseleave="tooltip = false">
                <i class="fa-solid fa-users"></i>
                <span x-show="!sidebarCollapsed">Colaboradores</span>
                <span x-show="tooltip" :class="darkMode ? 'bg-[#232B3E] text-white' : 'bg-gray-200 text-blue-900'" class="absolute left-full ml-2 px-2 py-1 rounded text-xs z-50" x-cloak>Empleados</span>
            </a>
            @php
                $isActive = request()->is('departments*');
                $activeClasses = $isActive ? 'border-blue-500 bg-blue-50 text-blue-900 dark:bg-[#181F2A] dark:text-white shadow-md' : 'border-transparent text-blue-900 hover:bg-blue-100 dark:text-white dark:hover:bg-[#232B3E] hover:border-blue-400';
            @endphp
            <a href="{{ route('departments.index') }}"
               :class="sidebarCollapsed ? 'justify-center px-0 py-3 border-l-0' : 'gap-4 px-4 py-3'"
               class="{{ $baseClasses }} {{ $activeClasses }}"
               x-data="{ tooltip: false }"
               @mouseenter="if(sidebarCollapsed) tooltip = true"
               @mouseleave="tooltip = false">
                <i class="fa-solid fa-building-user"></i>
                <span x-show="!sidebarCollapsed">Departamentos</span>
                <span x-show="tooltip" :class="darkMode ? 'bg-[#232B3E] text-white' : 'bg-gray-200 text-blue-900'" class="absolute left-full ml-2 px-2 py-1 rounded text-xs z-50" x-cloak>Departamentos</span>
            </a>
            @php
                $isActive = request()->is('positions*');
                $activeClasses = $isActive ? 'border-blue-500 bg-blue-50 text-blue-900 dark:bg-[#181F2A] dark:text-white shadow-md' : 'border-transparent text-blue-900 hover:bg-blue-100 dark:text-white dark:hover:bg-[#232B3E] hover:border-blue-400';
            @endphp
            <a href="{{ route('positions.index') }}"
               :class="sidebarCollapsed ? 'justify-center px-0 py-3 border-l-0' : 'gap-4 px-4 py-3'"
               class="{{ $baseClasses }} {{ $activeClasses }}"
               x-data="{ tooltip: false }"
               @mouseenter="if(sidebarCollapsed) tooltip = true"
               @mouseleave="tooltip = false">
                <i class="fa-solid fa-briefcase"></i>
                <span x-show="!sidebarCollapsed">Puestos</span>
                <span x-show="tooltip" :class="darkMode ? 'bg-[#232B3E] text-white' : 'bg-gray-200 text-blue-900'" class="absolute left-full ml-2 px-2 py-1 rounded text-xs z-50" x-cloak>Puestos</span>
            </a>
            @endrole
            <!-- Recibos y Licencias -->
            @role('Admin|HR')
            <div class="mt-6 mb-2 text-xs text-gray-400 uppercase pl-2 tracking-widest" x-show="!sidebarCollapsed">Recibos y Licencias</div>
            @php
                $isActive = request()->is('payslips*');
                $activeClasses = $isActive ? 'border-blue-500 bg-blue-50 text-blue-900 dark:bg-[#181F2A] dark:text-white shadow-md' : 'border-transparent text-blue-900 hover:bg-blue-100 dark:text-white dark:hover:bg-[#232B3E] hover:border-blue-400';
            @endphp
            <a href="{{ route('payslips.index') }}"
               :class="sidebarCollapsed ? 'justify-center px-0 py-3 border-l-0' : 'gap-4 px-4 py-3'"
               class="{{ $baseClasses }} {{ $activeClasses }}"
               x-data="{ tooltip: false }"
               @mouseenter="if(sidebarCollapsed) tooltip = true"
               @mouseleave="tooltip = false">
                <i class="fa-solid fa-file-invoice-dollar"></i>
                <span x-show="!sidebarCollapsed">Recibos</span>
                <span x-show="tooltip" :class="darkMode ? 'bg-[#232B3E] text-white' : 'bg-gray-200 text-blue-900'" class="absolute left-full ml-2 px-2 py-1 rounded text-xs z-50" x-cloak>Recibos</span>
            </a>
            @php
                $isActive = request()->is('leave-requests*');
                $activeClasses = $isActive ? 'border-blue-500 bg-blue-50 text-blue-900 dark:bg-[#181F2A] dark:text-white shadow-md' : 'border-transparent text-blue-900 hover:bg-blue-100 dark:text-white dark:hover:bg-[#232B3E] hover:border-blue-400';
            @endphp
            <a href="{{ route('leave-requests.index') }}"
               :class="sidebarCollapsed ? 'justify-center px-0 py-3 border-l-0' : 'gap-4 px-4 py-3'"
               class="{{ $baseClasses }} {{ $activeClasses }}"
               x-data="{ tooltip: false }"
               @mouseenter="if(sidebarCollapsed) tooltip = true"
               @mouseleave="tooltip = false">
                <i class="fa-solid fa-calendar-check"></i>
                <span x-show="!sidebarCollapsed">Licencias</span>
                <span x-show="tooltip" :class="darkMode ? 'bg-[#232B3E] text-white' : 'bg-gray-200 text-blue-900'" class="absolute left-full ml-2 px-2 py-1 rounded text-xs z-50" x-cloak>Licencias</span>
            </a>
            @php
                $isActive = request()->is('leave-types*');
                $activeClasses = $isActive ? 'border-blue-500 bg-blue-50 text-blue-900 dark:bg-[#181F2A] dark:text-white shadow-md' : 'border-transparent text-blue-900 hover:bg-blue-100 dark:text-white dark:hover:bg-[#232B3E] hover:border-blue-400';
            @endphp
            <a href="{{ route('leave-types.index') }}"
               :class="sidebarCollapsed ? 'justify-center px-0 py-3 border-l-0' : 'gap-4 px-4 py-3'"
               class="{{ $baseClasses }} {{ $activeClasses }}"
               x-data="{ tooltip: false }"
               @mouseenter="if(sidebarCollapsed) tooltip = true"
               @mouseleave="tooltip = false">
                <i class="fa-solid fa-list-check"></i>
                <span x-show="!sidebarCollapsed">Tipos de Licencia</span>
                <span x-show="tooltip" :class="darkMode ? 'bg-[#232B3E] text-white' : 'bg-gray-200 text-blue-900'" class="absolute left-full ml-2 px-2 py-1 rounded text-xs z-50" x-cloak>Tipos de Licencia</span>
            </a>
            @endrole
            <!-- Desarrollo (Submenú) -->
            @role('Admin')
            <div class="mt-6 mb-2 text-xs text-gray-400 uppercase pl-2 tracking-widest" x-show="!sidebarCollapsed">Desarrollo</div>
            <div x-data="{ open: false }">
                <button @click="open = !open"
                        :class="[
                           'flex items-center w-full rounded-none transition-all duration-200 group relative border-l-4 sidebar-link',
                           sidebarCollapsed ? 'justify-center px-0 py-3 border-l-0' : 'gap-4 px-4 py-3',
                           darkMode
                             ? 'hover:bg-[#232B3E] text-white'
                             : 'hover:bg-blue-100 text-blue-900'
                        ]"
                        class="focus:outline-none sidebar-link">
                    <i class="fa-solid fa-graduation-cap"></i>
                    <span x-show="!sidebarCollapsed">Desarrollo</span>
                    <i :class="open ? 'fa-chevron-up' : 'fa-chevron-down'" class="fa-solid ml-auto transition-transform" x-show="!sidebarCollapsed"></i>
                </button>
                <div x-show="open && !sidebarCollapsed" x-transition class="pl-10 space-y-1 border-l-2 border-[#232B3E] ml-2">
                    <a href="{{ route('documents.index') }}" :class="darkMode ? 'text-white hover:text-blue-400' : 'text-blue-900 hover:text-blue-400'" class="flex items-center gap-2 py-2 text-sm sidebar-link">
                        <span class="w-2 h-2 bg-blue-400 rounded-full inline-block"></span> Documentos
                    </a>
                    <a href="{{ route('academic-history.index') }}" :class="darkMode ? 'text-white hover:text-blue-400' : 'text-blue-900 hover:text-blue-400'" class="flex items-center gap-2 py-2 text-sm sidebar-link">
                        <span class="w-2 h-2 bg-blue-400 rounded-full inline-block"></span> Historial Académico
                    </a>
                    <a href="{{ route('training.index') }}" :class="darkMode ? 'text-white hover:text-blue-400' : 'text-blue-900 hover:text-blue-400'" class="flex items-center gap-2 py-2 text-sm sidebar-link">
                        <span class="w-2 h-2 bg-blue-400 rounded-full inline-block"></span> Capacitación
                    </a>
                    <a href="{{ route('performance.index') }}" :class="darkMode ? 'text-white hover:text-blue-400' : 'text-blue-900 hover:text-blue-400'" class="flex items-center gap-2 py-2 text-sm sidebar-link">
                        <span class="w-2 h-2 bg-blue-400 rounded-full inline-block"></span> Desempeño
                    </a>
                </div>
            </div>
            @endrole
            <!-- Reclutamiento (Submenú) -->
            @role('Admin')
            <div class="mt-6 mb-2 text-xs text-gray-400 uppercase pl-2 tracking-widest" x-show="!sidebarCollapsed">Reclutamiento</div>
            <div x-data="{ open: false }">
                <button @click="open = !open"
                        :class="[
                           'flex items-center w-full rounded-none transition-all duration-200 group relative border-l-4 sidebar-link',
                           sidebarCollapsed ? 'justify-center px-0 py-3 border-l-0' : 'gap-4 px-4 py-3',
                           darkMode
                             ? 'hover:bg-[#232B3E] text-white'
                             : 'hover:bg-blue-100 text-blue-900'
                        ]"
                        class="focus:outline-none sidebar-link">
                    <i class="fa-solid fa-user-plus"></i>
                    <span x-show="!sidebarCollapsed">Reclutamiento</span>
                    <i :class="open ? 'fa-chevron-up' : 'fa-chevron-down'" class="fa-solid ml-auto transition-transform" x-show="!sidebarCollapsed"></i>
                </button>
                <div x-show="open && !sidebarCollapsed" x-transition class="pl-10 space-y-1 border-l-2 border-[#232B3E] ml-2">
                    <a href="{{ route('job-postings.index') }}" :class="darkMode ? 'text-white hover:text-blue-400' : 'text-blue-900 hover:text-blue-400'" class="flex items-center gap-2 py-2 text-sm sidebar-link">
                        <span class="w-2 h-2 bg-blue-400 rounded-full inline-block"></span> Vacantes
                    </a>
                    <a href="{{ route('candidates.index') }}" :class="darkMode ? 'text-white hover:text-blue-400' : 'text-blue-900 hover:text-blue-400'" class="flex items-center gap-2 py-2 text-sm sidebar-link">
                        <span class="w-2 h-2 bg-blue-400 rounded-full inline-block"></span> Candidatos
                    </a>
                </div>
            </div>
            @endrole
            <!-- Reportes y Analíticas (Submenú) -->
            @role('Admin')
            <div class="mt-6 mb-2 text-xs text-gray-400 uppercase pl-2 tracking-widest" x-show="!sidebarCollapsed">Reportes y Analíticas</div>
            <div x-data="{ open: false }">
                <button @click="open = !open"
                        :class="[
                           'flex items-center w-full rounded-none transition-all duration-200 group relative border-l-4 sidebar-link',
                           sidebarCollapsed ? 'justify-center px-0 py-3 border-l-0' : 'gap-4 px-4 py-3',
                           darkMode
                             ? 'hover:bg-[#232B3E] text-white'
                             : 'hover:bg-blue-100 text-blue-900'
                        ]"
                        class="focus:outline-none sidebar-link">
                    <i class="fa-solid fa-chart-pie"></i>
                    <span x-show="!sidebarCollapsed">Reportes y Analíticas</span>
                    <i :class="open ? 'fa-chevron-up' : 'fa-chevron-down'" class="fa-solid ml-auto transition-transform" x-show="!sidebarCollapsed"></i>
                </button>
                <div x-show="open && !sidebarCollapsed" x-transition class="pl-10 space-y-1 border-l-2 border-[#232B3E] ml-2">
                    <a href="{{ route('reports.index') }}" :class="darkMode ? 'text-white hover:text-blue-400' : 'text-blue-900 hover:text-blue-400'" class="flex items-center gap-2 py-2 text-sm sidebar-link">
                        <span class="w-2 h-2 bg-blue-400 rounded-full inline-block"></span> Reportes
                    </a>
                    <a href="{{ route('analytics.index') }}" :class="darkMode ? 'text-white hover:text-blue-400' : 'text-blue-900 hover:text-blue-400'" class="flex items-center gap-2 py-2 text-sm sidebar-link">
                        <span class="w-2 h-2 bg-blue-400 rounded-full inline-block"></span> Analíticas
                    </a>
                </div>
            </div>
            @endrole
            <!-- Usuario y Admin -->
            <div class="mt-6 mb-2 text-xs text-gray-400 uppercase pl-2 tracking-widest" x-show="!sidebarCollapsed">Usuario</div>
            @php
                $isActive = request()->is('profile');
                $activeClasses = $isActive ? 'border-blue-500 bg-blue-50 text-blue-900 dark:bg-[#181F2A] dark:text-white shadow-md' : 'border-transparent text-blue-900 hover:bg-blue-100 dark:text-white dark:hover:bg-[#232B3E] hover:border-blue-400';
            @endphp
            <a href="#"
               :class="sidebarCollapsed ? 'justify-center px-0 py-3 border-l-0' : 'gap-4 px-4 py-3'"
               class="{{ $baseClasses }} {{ $activeClasses }}"
               x-data="{ tooltip: false }"
               @mouseenter="if(sidebarCollapsed) tooltip = true"
               @mouseleave="tooltip = false">
                <i class="fa-solid fa-user-circle"></i>
                <span x-show="!sidebarCollapsed">Perfil</span>
                <span x-show="tooltip" :class="darkMode ? 'bg-[#232B3E] text-white' : 'bg-gray-200 text-blue-900'" class="absolute left-full ml-2 px-2 py-1 rounded text-xs z-50" x-cloak>Perfil</span>
            </a>
            @role('Admin')
            <div class="mt-6 mb-2 text-xs text-gray-400 uppercase pl-2 tracking-widest" x-show="!sidebarCollapsed">Admin</div>
            @php
                $isActive = request()->is('admin/settings');
                $activeClasses = $isActive ? 'border-blue-500 bg-blue-50 text-blue-900 dark:bg-[#181F2A] dark:text-white shadow-md' : 'border-transparent text-blue-900 hover:bg-blue-100 dark:text-white dark:hover:bg-[#232B3E] hover:border-blue-400';
            @endphp
            <a href="#"
               :class="sidebarCollapsed ? 'justify-center px-0 py-3 border-l-0' : 'gap-4 px-4 py-3'"
               class="{{ $baseClasses }} {{ $activeClasses }}"
               x-data="{ tooltip: false }"
               @mouseenter="if(sidebarCollapsed) tooltip = true"
               @mouseleave="tooltip = false">
                <i class="fa-solid fa-gear"></i>
                <span x-show="!sidebarCollapsed">Configuración</span>
                <span x-show="tooltip" :class="darkMode ? 'bg-[#232B3E] text-white' : 'bg-gray-200 text-blue-900'" class="absolute left-full ml-2 px-2 py-1 rounded text-xs z-50" x-cloak>Configuración</span>
            </a>
            @php
                $isActive = request()->is('admin/audit');
                $activeClasses = $isActive ? 'border-blue-500 bg-blue-50 text-blue-900 dark:bg-[#181F2A] dark:text-white shadow-md' : 'border-transparent text-blue-900 hover:bg-blue-100 dark:text-white dark:hover:bg-[#232B3E] hover:border-blue-400';
            @endphp
            <a href="#"
               :class="sidebarCollapsed ? 'justify-center px-0 py-3 border-l-0' : 'gap-4 px-4 py-3'"
               class="{{ $baseClasses }} {{ $activeClasses }}"
               x-data="{ tooltip: false }"
               @mouseenter="if(sidebarCollapsed) tooltip = true"
               @mouseleave="tooltip = false">
                <i class="fa-solid fa-shield-halved"></i>
                <span x-show="!sidebarCollapsed">Auditoría</span>
                <span x-show="tooltip" :class="darkMode ? 'bg-[#232B3E] text-white' : 'bg-gray-200 text-blue-900'" class="absolute left-full ml-2 px-2 py-1 rounded text-xs z-50" x-cloak>Auditoría</span>
            </a>
            @endrole
        </nav>
    </div>
</aside> 