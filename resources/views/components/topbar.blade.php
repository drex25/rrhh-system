<header :class="darkMode ? 'bg-[#181F2A] border-[#232B3E]' : 'bg-white border-gray-200'" class="sticky top-0 z-20 w-full backdrop-blur-lg shadow-md flex items-center justify-between px-8 h-20 transition-all border-b">
    <div class="flex items-center gap-4">
        <button @click="sidebarCollapsed = !sidebarCollapsed" :class="darkMode ? 'bg-[#232B3E] text-gray-300 hover:text-white' : 'bg-gray-200 text-blue-900 hover:text-blue-700'" class="p-2 rounded-full focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-400 shadow">
            <i class="fa-solid fa-bars text-2xl"></i>
        </button>
        <span :class="darkMode ? 'text-white' : 'text-blue-900'" class="text-2xl font-bold drop-shadow">Panel de Administración</span>
    </div>
    <div class="flex items-center gap-4">
        <!-- Search -->
        <div class="relative hidden md:block">
            <input type="text" placeholder="Buscar..." :class="darkMode ? 'bg-[#232B3E] text-gray-200' : 'bg-gray-200 text-blue-900'" class="pl-10 pr-4 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 transition w-64 shadow" />
            <span :class="darkMode ? 'text-blue-400' : 'text-blue-700'" class="absolute left-3 top-1/2 -translate-y-1/2">
                <i class="fa-solid fa-magnifying-glass"></i>
            </span>
        </div>
        <!-- Help -->
        <button :class="darkMode ? 'bg-[#232B3E] text-gray-300 hover:text-white' : 'bg-gray-200 text-blue-900 hover:text-blue-700'" class="p-2 rounded-full focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-400 shadow" aria-label="Ayuda">
            <i class="fa-solid fa-circle-question text-xl"></i>
        </button>
        <!-- Notifications -->
        <button :class="darkMode ? 'bg-[#232B3E] text-gray-300 hover:text-white' : 'bg-gray-200 text-blue-900 hover:text-blue-700'" class="p-2 rounded-full focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-400 shadow relative" aria-label="Notificaciones">
            <i class="fa-solid fa-bell text-xl"></i>
            <span class="absolute top-1 right-1 w-2.5 h-2.5 bg-red-500 rounded-full border-2 border-white"></span>
        </button>
        <!-- Dark Mode Toggle -->
        <button @click="darkMode = !darkMode" :class="darkMode ? 'bg-[#232B3E] text-gray-300 hover:text-white' : 'bg-gray-200 text-blue-900 hover:text-blue-700'" class="p-2 rounded-full focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-400 shadow" aria-label="Cambiar modo oscuro">
            <i x-show="!darkMode" class="fa-solid fa-moon text-xl"></i>
            <i x-show="darkMode" class="fa-solid fa-sun text-xl"></i>
        </button>
        <!-- User Dropdown -->
        <div class="relative" x-data="{ open: false }">
            <button @click="open = !open" :class="darkMode ? 'bg-[#232B3E]' : 'bg-gray-200'" class="flex items-center space-x-2 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-400 transition rounded-full px-2 py-1 shadow">
                @if (Auth::user()->profile_photo_url ?? false)
                    <img class="h-10 w-10 rounded-full object-cover border-2 border-blue-400 shadow" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}">
                @else
                    <span class="inline-flex items-center justify-center h-10 w-10 rounded-full bg-blue-600 text-white font-bold border-2 border-blue-400 shadow">
                        {{ strtoupper(Str::substr(Auth::user()->name, 0, 2)) }}
                    </span>
                @endif
                <span :class="darkMode ? 'text-gray-200' : 'text-blue-900'" class="hidden md:block text-sm font-medium">{{ Auth::user()->name }}</span>
                <i :class="darkMode ? 'text-gray-300' : 'text-blue-900'" class="fa-solid fa-chevron-down"></i>
            </button>
            <div x-show="open" @click.away="open = false" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95" :class="darkMode ? 'bg-[#232B3E] ring-[#181F2A]' : 'bg-gray-100 ring-gray-200'" class="absolute right-0 mt-2 w-56 rounded-xl shadow-lg ring-1 z-50 transition-all duration-200 origin-top-right">
                <div class="py-1">
                    <a href="#" :class="darkMode ? 'text-gray-200 hover:bg-blue-800' : 'text-blue-900 hover:bg-blue-100'" class="block px-4 py-2 text-sm transition">Perfil</a>
                    <a href="#" :class="darkMode ? 'text-gray-200 hover:bg-blue-800' : 'text-blue-900 hover:bg-blue-100'" class="block px-4 py-2 text-sm transition">Configuración</a>
                    <div :class="darkMode ? 'border-[#181F2A]' : 'border-gray-200'" class="border-t my-1"></div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" :class="darkMode ? 'text-red-400 hover:bg-blue-800' : 'text-red-600 hover:bg-blue-100'" class="block w-full text-left px-4 py-2 text-sm transition">Cerrar Sesión</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</header> 