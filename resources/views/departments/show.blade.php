@extends('layouts.admin')

@section('content')
<style>
/* Animación gradiente header */
.animated-gradient {
    background: linear-gradient(270deg, #2563eb, #6366f1, #38bdf8, #2563eb);
    background-size: 800% 800%;
    animation: gradientMove 10s ease-in-out infinite;
}
@keyframes gradientMove {
    0% {background-position:0% 50%}
    50% {background-position:100% 50%}
    100% {background-position:0% 50%}
}
/* Avatar glow */
.avatar-glow {
    box-shadow: 0 0 0 6px #3b82f6, 0 0 24px 0 #6366f1;
    transition: box-shadow 0.3s;
}
.avatar-glow:hover {
    box-shadow: 0 0 0 10px #38bdf8, 0 0 40px 0 #6366f1;
}
/* Badge pulso */
.badge-pulse {
    position: relative;
}
.badge-pulse::before {
    content: '';
    position: absolute;
    left: 8px; top: 8px;
    width: 10px; height: 10px;
    background: #22c55e;
    border-radius: 9999px;
    opacity: 0.5;
    animation: pulse 1.5s infinite;
    z-index: 0;
}
@keyframes pulse {
    0% {transform: scale(1); opacity: 0.5;}
    70% {transform: scale(2.2); opacity: 0;}
    100% {transform: scale(2.2); opacity: 0;}
}
/* Glassmorphism */
.glass-card {
    background: rgba(255,255,255,0.7);
    backdrop-filter: blur(8px);
    border-radius: 1.25rem;
    box-shadow: 0 8px 32px 0 rgba(31,38,135,0.10);
    border: 1.5px solid rgba(255,255,255,0.18);
}
/* Animación entrada */
.fade-in-up {animation: fadeInUp 1s cubic-bezier(.39,.575,.565,1) both;}
@keyframes fadeInUp {
    0% {opacity:0; transform:translateY(40px)}
    100% {opacity:1; transform:translateY(0)}
}
/* Tabla empleados */
.employee-row:hover {box-shadow:0 4px 24px 0 #2563eb22; transform:translateY(-2px) scale(1.01);}
.employee-avatar {
    border: 3px solid #22c55e;
    transition: border-color 0.3s;
}
.employee-avatar.inactive {border-color: #ef4444;}
</style>
<div class="w-full mx-auto px-4 md:px-6 lg:px-8 py-8">
    <!-- Header WOW -->
    <div class="relative rounded-2xl shadow-lg mb-10 overflow-hidden border border-gray-200 dark:border-gray-800 fade-in-up">
        <div class="animated-gradient h-44 flex items-center px-8 relative">
            <div class="flex items-center gap-8">
                <div class="w-28 h-28 rounded-full bg-white avatar-glow flex items-center justify-center text-5xl font-extrabold text-blue-600 border-4 border-blue-200">
                    {{ strtoupper(substr($department->name,0,1)) }}
                </div>
                <div>
                    <h1 class="text-4xl font-extrabold text-white tracking-tight flex items-center gap-3">
                        {{ $department->name }}
                        @if($department->is_active)
                            <span class="inline-flex items-center gap-1 px-3 py-1 text-xs font-bold rounded-full bg-green-100 text-green-800 badge-pulse ml-2 relative z-10">
                                <i class="fa-solid fa-circle-check"></i> Activo
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1 px-3 py-1 text-xs font-bold rounded-full bg-red-100 text-red-800 ml-2">
                                <i class="fa-solid fa-circle-xmark"></i> Inactivo
                            </span>
                        @endif
                    </h1>
                    <div class="text-blue-100 mt-2 flex items-center gap-2">
                        <i class="fa-solid fa-hashtag"></i> <span class="font-mono text-lg">{{ $department->code }}</span>
                        <button onclick="navigator.clipboard.writeText('{{ $department->code }}'); Swal.fire({icon:'success',title:'¡Copiado!',text:'Código copiado al portapapeles',toast:true,position:'top-end',showConfirmButton:false,timer:1200})" class="ml-2 px-2 py-1 rounded bg-white/20 hover:bg-white/40 text-white text-xs font-semibold transition" title="Copiar código"><i class="fa-regular fa-copy"></i></button>
                    </div>
                </div>
            </div>
        </div>
        <div class="absolute top-4 right-4">
            <span class="inline-flex items-center gap-2 px-4 py-2 bg-white/80 dark:bg-gray-900/80 rounded-xl shadow text-blue-700 dark:text-blue-300 font-semibold text-sm">
                <i class="fa-solid fa-users"></i> {{ $department->employees->count() }} empleados
            </span>
        </div>
    </div>

    <!-- Tarjetas glassmorphism -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-10 fade-in-up">
        <div class="glass-card p-8 flex flex-col gap-8">
            <div class="flex items-center gap-3 group relative">
                <i class="fa-solid fa-circle-info text-blue-500" title="Descripción"></i>
                <div>
                    <div class="text-gray-500 dark:text-gray-400 text-xs uppercase">DESCRIPCIÓN</div>
                    <div class="text-base text-gray-800 dark:text-gray-100">
                        @if($department->description)
                            {{ $department->description }}
                        @else
                            <span class="italic text-gray-400">Este departamento aún no tiene descripción. ¡Puedes agregar una para motivar al equipo!</span>
                        @endif
                    </div>
                </div>
            </div>
            <div class="flex items-center gap-3 group relative">
                <i class="fa-solid fa-user-tie text-blue-500" title="Manager"></i>
                <div>
                    <div class="text-gray-500 dark:text-gray-400 text-xs uppercase">MANAGER</div>
                    <div class="text-base text-gray-800 dark:text-gray-100">
                        @if($department->manager)
                            <span class="inline-flex items-center gap-2">
                                <span class="inline-flex items-center justify-center h-8 w-8 rounded-full bg-gradient-to-br from-blue-500 to-indigo-600 text-white font-bold shadow-lg border-2 border-blue-200">
                                    {{ strtoupper(substr($department->manager->first_name,0,1)) }}{{ strtoupper(substr($department->manager->last_name,0,1)) }}
                                </span>
                                {{ $department->manager->first_name }} {{ $department->manager->last_name }}
                                <span class="ml-2 px-2 py-0.5 rounded bg-blue-100 text-blue-700 text-xs font-semibold" title="Líder del área"><i class="fa-solid fa-crown"></i> Líder</span>
                            </span>
                        @else
                            <span class="text-gray-400">Sin asignar</span>
                        @endif
                    </div>
                </div>
            </div>
            <div class="flex items-center gap-3 group relative">
                <i class="fa-solid fa-location-dot text-blue-500" title="Ubicación"></i>
                <div>
                    <div class="text-gray-500 dark:text-gray-400 text-xs uppercase">UBICACIÓN</div>
                    <div class="text-base text-gray-800 dark:text-gray-100">{{ $department->location ?? '-' }}</div>
                </div>
            </div>
        </div>
        <div class="glass-card p-8 flex flex-col gap-8 justify-center">
            <div class="flex items-center gap-3 group relative">
                <i class="fa-solid fa-hashtag text-blue-500" title="Código"></i>
                <div>
                    <div class="text-gray-500 dark:text-gray-400 text-xs uppercase">CÓDIGO</div>
                    <div class="text-lg font-mono text-blue-700 dark:text-blue-300">{{ $department->code }}</div>
                </div>
            </div>
            <div class="flex items-center gap-3 group relative">
                <i class="fa-solid fa-circle-dot text-blue-500" title="Estado"></i>
                <div>
                    <div class="text-gray-500 dark:text-gray-400 text-xs uppercase">ESTADO</div>
                    @if($department->is_active)
                        <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300 items-center"><i class="fa-solid fa-circle-check mr-1 text-base"></i>Activo</span>
                    @else
                        <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300 items-center"><i class="fa-solid fa-circle-xmark mr-1 text-base"></i>Inactivo</span>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <h2 class="text-xl font-bold text-gray-700 dark:text-gray-200 mb-4 flex items-center gap-2 fade-in-up">
        <i class="fa-solid fa-users"></i> Empleados del área
    </h2>
    <div class="glass-card fade-in-up">
        <table class="w-full divide-y divide-gray-200 dark:divide-gray-700">
            <thead class="bg-gray-50 dark:bg-gray-800">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Nombre</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Email</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Posición</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Estado</th>
                </tr>
            </thead>
            <tbody class="bg-white dark:bg-gray-900 divide-y divide-gray-200 dark:divide-gray-700">
                @forelse($department->employees as $employee)
                    <tr class="employee-row transition-all duration-200">
                        <td class="px-6 py-4 whitespace-nowrap font-semibold text-gray-800 dark:text-gray-100 flex items-center gap-3">
                            <span class="inline-flex items-center justify-center h-8 w-8 rounded-full bg-gradient-to-br from-blue-500 to-indigo-600 text-white font-bold employee-avatar {{ $employee->is_active ? '' : 'inactive' }}">
                                {{ strtoupper(substr($employee->first_name,0,1)) }}{{ strtoupper(substr($employee->last_name,0,1)) }}
                            </span>
                            {{ $employee->first_name }} {{ $employee->last_name }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-gray-600 dark:text-gray-300 truncate max-w-xs">
                            {{ $employee->email }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-gray-600 dark:text-gray-300 truncate max-w-xs">
                            {{ $employee->position->title ?? '-' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($employee->is_active)
                                <span class="inline-flex items-center gap-1 px-3 py-1 text-xs font-bold rounded-full bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300 items-center"><i class="fa-solid fa-circle-check text-base"></i> Activo</span>
                            @else
                                <span class="inline-flex items-center gap-1 px-3 py-1 text-xs font-bold rounded-full bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300 items-center"><i class="fa-solid fa-circle-xmark text-base"></i> Inactivo</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">
                            <div class="flex flex-col items-center justify-center">
                                <svg width="120" height="80" viewBox="0 0 120 80" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <ellipse cx="60" cy="70" rx="50" ry="8" fill="#e0e7ef"/>
                                    <circle cx="40" cy="40" r="18" fill="#a5b4fc"/>
                                    <circle cx="80" cy="40" r="18" fill="#93c5fd"/>
                                    <ellipse cx="60" cy="50" rx="12" ry="6" fill="#fff"/>
                                </svg>
                                <p class="text-lg font-medium mt-2">No hay empleados en este departamento.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection 