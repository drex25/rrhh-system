<style>
    .sidebar-pro::-webkit-scrollbar { width: 0 !important; height: 0 !important; }
    .sidebar-pro { scrollbar-width: none !important; -ms-overflow-style: none !important; }
</style>
<aside class="fixed z-30 inset-y-0 left-0 transition-all duration-300 ease-in-out" :class="sidebarCollapsed ? 'w-20' : 'w-72'">
    <div class="bg-[#181F2A] flex flex-col h-screen overflow-y-auto border-r border-[#232B3E] sidebar-pro" style="scrollbar-width: none;">
        <div class="flex items-center justify-center h-20 border-b border-[#232B3E] bg-[#232B3E]">
            <template x-if="!sidebarCollapsed">
               
                    <img src="/images/TSG logo.png" alt="TSGroup Logo" class="w-10 h-10 object-contain">
              
            </template>
            <template x-if="sidebarCollapsed">
                <img src="/images/favicon.png" alt="TSGroup Favicon" class="w-10 h-10 object-contain">
            </template>
        </div>
        <nav class="flex-1 px-2 py-6 space-y-2">
            <!-- Dashboard -->
            <a href="/dashboard"
               class="flex items-center rounded-none font-semibold transition-all duration-200 group hover:bg-[#232B3E] text-white relative border-l-4 {{ request()->is('dashboard') ? 'border-blue-500 bg-[#181F2A]' : 'border-transparent' }} {{ (isset($sidebarCollapsed) && $sidebarCollapsed) ? 'justify-center px-0 py-3 border-l-0' : 'gap-4 px-4 py-3' }}"
               x-data="{ tooltip: false }"
               @mouseenter="if(sidebarCollapsed) tooltip = true"
               @mouseleave="tooltip = false">
                <i class="fa-solid fa-gauge-high text-xl"></i>
                <span x-show="!sidebarCollapsed">Panel</span>
                <span x-show="tooltip" class="absolute left-full ml-2 px-2 py-1 rounded bg-[#232B3E] text-white text-xs z-50" x-cloak>Panel</span>
            </a>
            <!-- Gestión -->
            @role('Admin|HR')
            <div class="mt-6 mb-2 text-xs text-gray-400 uppercase pl-2 tracking-widest" x-show="!sidebarCollapsed">Gestión</div>
            <a href="{{ route('employees.index') }}"
               class="flex items-center rounded-none transition-all duration-200 group hover:bg-[#232B3E] text-white relative border-l-4 {{ request()->is('employees*') ? 'border-blue-500 bg-[#181F2A]' : 'border-transparent' }} {{ (isset($sidebarCollapsed) && $sidebarCollapsed) ? 'justify-center px-0 py-3 border-l-0' : 'gap-4 px-4 py-3' }}"
               x-data="{ tooltip: false }"
               @mouseenter="if(sidebarCollapsed) tooltip = true"
               @mouseleave="tooltip = false">
                <i class="fa-solid fa-users"></i>
                <span x-show="!sidebarCollapsed">Empleados</span>
                <span x-show="tooltip" class="absolute left-full ml-2 px-2 py-1 rounded bg-[#232B3E] text-white text-xs z-50" x-cloak>Empleados</span>
            </a>
            <a href="{{ route('departments.index') }}"
               class="flex items-center rounded-none transition-all duration-200 group hover:bg-[#232B3E] text-white relative border-l-4 {{ request()->is('departments*') ? 'border-blue-500 bg-[#181F2A]' : 'border-transparent' }} {{ (isset($sidebarCollapsed) && $sidebarCollapsed) ? 'justify-center px-0 py-3 border-l-0' : 'gap-4 px-4 py-3' }}"
               x-data="{ tooltip: false }"
               @mouseenter="if(sidebarCollapsed) tooltip = true"
               @mouseleave="tooltip = false">
                <i class="fa-solid fa-building-user"></i>
                <span x-show="!sidebarCollapsed">Departamentos</span>
                <span x-show="tooltip" class="absolute left-full ml-2 px-2 py-1 rounded bg-[#232B3E] text-white text-xs z-50" x-cloak>Departamentos</span>
            </a>
            <a href="{{ route('positions.index') }}"
               class="flex items-center rounded-none transition-all duration-200 group hover:bg-[#232B3E] text-white relative border-l-4 {{ request()->is('positions*') ? 'border-blue-500 bg-[#181F2A]' : 'border-transparent' }} {{ (isset($sidebarCollapsed) && $sidebarCollapsed) ? 'justify-center px-0 py-3 border-l-0' : 'gap-4 px-4 py-3' }}"
               x-data="{ tooltip: false }"
               @mouseenter="if(sidebarCollapsed) tooltip = true"
               @mouseleave="tooltip = false">
                <i class="fa-solid fa-briefcase"></i>
                <span x-show="!sidebarCollapsed">Puestos</span>
                <span x-show="tooltip" class="absolute left-full ml-2 px-2 py-1 rounded bg-[#232B3E] text-white text-xs z-50" x-cloak>Puestos</span>
            </a>
            @endrole
            <!-- Recibos y Licencias -->
            @role('Admin|HR')
            <div class="mt-6 mb-2 text-xs text-gray-400 uppercase pl-2 tracking-widest" x-show="!sidebarCollapsed">Recibos y Licencias</div>
            <a href="{{ route('payslips.index') }}"
               class="flex items-center rounded-none transition-all duration-200 group hover:bg-[#232B3E] text-white relative border-l-4 {{ request()->is('payslips*') ? 'border-blue-500 bg-[#181F2A]' : 'border-transparent' }} {{ (isset($sidebarCollapsed) && $sidebarCollapsed) ? 'justify-center px-0 py-3 border-l-0' : 'gap-4 px-4 py-3' }}"
               x-data="{ tooltip: false }"
               @mouseenter="if(sidebarCollapsed) tooltip = true"
               @mouseleave="tooltip = false">
                <i class="fa-solid fa-file-invoice-dollar"></i>
                <span x-show="!sidebarCollapsed">Recibos</span>
                <span x-show="tooltip" class="absolute left-full ml-2 px-2 py-1 rounded bg-[#232B3E] text-white text-xs z-50" x-cloak>Recibos</span>
            </a>
            <a href="{{ route('leave-requests.index') }}"
               class="flex items-center rounded-none transition-all duration-200 group hover:bg-[#232B3E] text-white relative border-l-4 {{ request()->is('leave-requests*') ? 'border-blue-500 bg-[#181F2A]' : 'border-transparent' }} {{ (isset($sidebarCollapsed) && $sidebarCollapsed) ? 'justify-center px-0 py-3 border-l-0' : 'gap-4 px-4 py-3' }}"
               x-data="{ tooltip: false }"
               @mouseenter="if(sidebarCollapsed) tooltip = true"
               @mouseleave="tooltip = false">
                <i class="fa-solid fa-calendar-check"></i>
                <span x-show="!sidebarCollapsed">Licencias</span>
                <span x-show="tooltip" class="absolute left-full ml-2 px-2 py-1 rounded bg-[#232B3E] text-white text-xs z-50" x-cloak>Licencias</span>
            </a>
            <a href="{{ route('leave-types.index') }}"
               class="flex items-center rounded-none transition-all duration-200 group hover:bg-[#232B3E] text-white relative border-l-4 {{ request()->is('leave-types*') ? 'border-blue-500 bg-[#181F2A]' : 'border-transparent' }} {{ (isset($sidebarCollapsed) && $sidebarCollapsed) ? 'justify-center px-0 py-3 border-l-0' : 'gap-4 px-4 py-3' }}"
               x-data="{ tooltip: false }"
               @mouseenter="if(sidebarCollapsed) tooltip = true"
               @mouseleave="tooltip = false">
                <i class="fa-solid fa-list-check"></i>
                <span x-show="!sidebarCollapsed">Tipos de Licencia</span>
                <span x-show="tooltip" class="absolute left-full ml-2 px-2 py-1 rounded bg-[#232B3E] text-white text-xs z-50" x-cloak>Tipos de Licencia</span>
            </a>
            @endrole
            <!-- Desarrollo (Submenú) -->
            @role('Admin')
            <div class="mt-6 mb-2 text-xs text-gray-400 uppercase pl-2 tracking-widest" x-show="!sidebarCollapsed">Desarrollo</div>
            <div x-data="{ open: false }">
                <button @click="open = !open"
                        class="flex items-center w-full rounded-none transition-all duration-200 group hover:bg-[#232B3E] text-white focus:outline-none relative border-l-4 {{ (isset($sidebarCollapsed) && $sidebarCollapsed) ? 'justify-center px-0 py-3 border-l-0' : 'gap-4 px-4 py-3 border-transparent' }}">
                    <i class="fa-solid fa-graduation-cap"></i>
                    <span x-show="!sidebarCollapsed">Desarrollo</span>
                    <i :class="open ? 'fa-chevron-up' : 'fa-chevron-down'" class="fa-solid ml-auto transition-transform" x-show="!sidebarCollapsed"></i>
                </button>
                <div x-show="open && !sidebarCollapsed" x-transition class="pl-10 space-y-1 border-l-2 border-[#232B3E] ml-2">
                    <a href="{{ route('documents.index') }}" class="flex items-center gap-2 py-2 text-sm text-gray-200 hover:text-blue-400">
                        <span class="w-2 h-2 bg-blue-400 rounded-full inline-block"></span> Documentos
                    </a>
                    <a href="{{ route('academic-history.index') }}" class="flex items-center gap-2 py-2 text-sm text-gray-200 hover:text-blue-400">
                        <span class="w-2 h-2 bg-blue-400 rounded-full inline-block"></span> Historial Académico
                    </a>
                    <a href="{{ route('training.index') }}" class="flex items-center gap-2 py-2 text-sm text-gray-200 hover:text-blue-400">
                        <span class="w-2 h-2 bg-blue-400 rounded-full inline-block"></span> Capacitación
                    </a>
                    <a href="{{ route('performance.index') }}" class="flex items-center gap-2 py-2 text-sm text-gray-200 hover:text-blue-400">
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
                        class="flex items-center w-full rounded-none transition-all duration-200 group hover:bg-[#232B3E] text-white focus:outline-none relative border-l-4 {{ (isset($sidebarCollapsed) && $sidebarCollapsed) ? 'justify-center px-0 py-3 border-l-0' : 'gap-4 px-4 py-3 border-transparent' }}">
                    <i class="fa-solid fa-user-plus"></i>
                    <span x-show="!sidebarCollapsed">Reclutamiento</span>
                    <i :class="open ? 'fa-chevron-up' : 'fa-chevron-down'" class="fa-solid ml-auto transition-transform" x-show="!sidebarCollapsed"></i>
                </button>
                <div x-show="open && !sidebarCollapsed" x-transition class="pl-10 space-y-1 border-l-2 border-[#232B3E] ml-2">
                    <a href="{{ route('job-postings.index') }}" class="flex items-center gap-2 py-2 text-sm text-gray-200 hover:text-blue-400">
                        <span class="w-2 h-2 bg-blue-400 rounded-full inline-block"></span> Vacantes
                    </a>
                    <a href="{{ route('candidates.index') }}" class="flex items-center gap-2 py-2 text-sm text-gray-200 hover:text-blue-400">
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
                        class="flex items-center w-full rounded-none transition-all duration-200 group hover:bg-[#232B3E] text-white focus:outline-none relative border-l-4 {{ (isset($sidebarCollapsed) && $sidebarCollapsed) ? 'justify-center px-0 py-3 border-l-0' : 'gap-4 px-4 py-3 border-transparent' }}">
                    <i class="fa-solid fa-chart-pie"></i>
                    <span x-show="!sidebarCollapsed">Reportes y Analíticas</span>
                    <i :class="open ? 'fa-chevron-up' : 'fa-chevron-down'" class="fa-solid ml-auto transition-transform" x-show="!sidebarCollapsed"></i>
                </button>
                <div x-show="open && !sidebarCollapsed" x-transition class="pl-10 space-y-1 border-l-2 border-[#232B3E] ml-2">
                    <a href="{{ route('reports.index') }}" class="flex items-center gap-2 py-2 text-sm text-gray-200 hover:text-blue-400">
                        <span class="w-2 h-2 bg-blue-400 rounded-full inline-block"></span> Reportes
                    </a>
                    <a href="{{ route('analytics.index') }}" class="flex items-center gap-2 py-2 text-sm text-gray-200 hover:text-blue-400">
                        <span class="w-2 h-2 bg-blue-400 rounded-full inline-block"></span> Analíticas
                    </a>
                </div>
            </div>
            @endrole
            <!-- Usuario y Admin -->
            <div class="mt-6 mb-2 text-xs text-gray-400 uppercase pl-2 tracking-widest" x-show="!sidebarCollapsed">Usuario</div>
            <a href="#"
               class="flex items-center rounded-none transition-all duration-200 group hover:bg-[#232B3E] text-white relative border-l-4 {{ request()->is('profile*') ? 'border-blue-500 bg-[#181F2A]' : 'border-transparent' }} {{ (isset($sidebarCollapsed) && $sidebarCollapsed) ? 'justify-center px-0 py-3 border-l-0' : 'gap-4 px-4 py-3' }}"
               x-data="{ tooltip: false }"
               @mouseenter="if(sidebarCollapsed) tooltip = true"
               @mouseleave="tooltip = false">
                <i class="fa-solid fa-user-circle"></i>
                <span x-show="!sidebarCollapsed">Perfil</span>
                <span x-show="tooltip" class="absolute left-full ml-2 px-2 py-1 rounded bg-[#232B3E] text-white text-xs z-50" x-cloak>Perfil</span>
            </a>
            @role('Admin')
            <div class="mt-6 mb-2 text-xs text-gray-400 uppercase pl-2 tracking-widest" x-show="!sidebarCollapsed">Admin</div>
            <a href="#"
               class="flex items-center rounded-none transition-all duration-200 group hover:bg-[#232B3E] text-white relative border-l-4 {{ request()->is('settings*') ? 'border-blue-500 bg-[#181F2A]' : 'border-transparent' }} {{ (isset($sidebarCollapsed) && $sidebarCollapsed) ? 'justify-center px-0 py-3 border-l-0' : 'gap-4 px-4 py-3' }}"
               x-data="{ tooltip: false }"
               @mouseenter="if(sidebarCollapsed) tooltip = true"
               @mouseleave="tooltip = false">
                <i class="fa-solid fa-gear"></i>
                <span x-show="!sidebarCollapsed">Configuración</span>
                <span x-show="tooltip" class="absolute left-full ml-2 px-2 py-1 rounded bg-[#232B3E] text-white text-xs z-50" x-cloak>Configuración</span>
            </a>
            <a href="#"
               class="flex items-center rounded-none transition-all duration-200 group hover:bg-[#232B3E] text-white relative border-l-4 {{ request()->is('audit*') ? 'border-blue-500 bg-[#181F2A]' : 'border-transparent' }} {{ (isset($sidebarCollapsed) && $sidebarCollapsed) ? 'justify-center px-0 py-3 border-l-0' : 'gap-4 px-4 py-3' }}"
               x-data="{ tooltip: false }"
               @mouseenter="if(sidebarCollapsed) tooltip = true"
               @mouseleave="tooltip = false">
                <i class="fa-solid fa-shield-halved"></i>
                <span x-show="!sidebarCollapsed">Auditoría</span>
                <span x-show="tooltip" class="absolute left-full ml-2 px-2 py-1 rounded bg-[#232B3E] text-white text-xs z-50" x-cloak>Auditoría</span>
            </a>
            @endrole
        </nav>
    </div>
</aside> 