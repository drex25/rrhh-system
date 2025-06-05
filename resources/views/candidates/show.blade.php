@extends('layouts.admin')

@section('content')
<div class="w-full mx-auto px-4 md:px-6 lg:px-8 py-6">
    <!-- Header -->
    <div class="flex flex-col md:flex-row items-center justify-between bg-white dark:bg-gray-900 rounded-2xl shadow-lg p-8 mb-8 border border-gray-200 dark:border-gray-800 transform transition-all duration-300 hover:shadow-xl hover:scale-[1.01]">
        <div class="flex items-center gap-6 mb-4 md:mb-0">
            <div class="w-32 h-32 rounded-full bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center text-4xl text-white border-4 border-indigo-100 dark:border-indigo-900 shadow-lg transform transition-all duration-300 hover:scale-110 hover:rotate-3">
                {{ strtoupper(substr($candidate->first_name, 0, 1)) }}{{ strtoupper(substr($candidate->last_name, 0, 1)) }}
            </div>
            <div class="animate-fade-in">
                <h2 class="text-3xl font-bold text-gray-800 dark:text-white">{{ $candidate->full_name }}</h2>
                <div class="flex items-center gap-3 mt-2">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold transform transition-all duration-200 hover:scale-105
                        @if($candidate->status == 'pending') bg-yellow-100 text-yellow-800 dark:bg-yellow-900/60 dark:text-yellow-200
                        @elseif($candidate->status == 'reviewing') bg-blue-100 text-blue-800 dark:bg-blue-900/60 dark:text-blue-200
                        @elseif($candidate->status == 'interviewed') bg-purple-100 text-purple-800 dark:bg-purple-900/60 dark:text-purple-200
                        @elseif($candidate->status == 'offered') bg-green-100 text-green-800 dark:bg-green-900/60 dark:text-green-200
                        @elseif($candidate->status == 'hired') bg-emerald-100 text-emerald-800 dark:bg-emerald-900/60 dark:text-emerald-200
                        @elseif($candidate->status == 'rejected') bg-red-100 text-red-800 dark:bg-red-900/60 dark:text-red-200
                        @else bg-gray-200 text-gray-800 dark:bg-gray-700 dark:text-gray-200 @endif">
                        <i class="fas fa-circle mr-1 text-xs"></i>
                        {{ ucfirst($candidate->status) }}
                    </span>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300 transform transition-all duration-200 hover:scale-105">
                        <i class="fa-solid fa-envelope mr-2"></i>
                        {{ $candidate->email }}
                    </span>
                </div>
            </div>
        </div>
        <div class="flex flex-wrap gap-3">
            <a href="{{ route('candidates.edit', $candidate) }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-600 text-white text-sm font-semibold rounded-xl shadow-sm hover:from-indigo-600 hover:to-blue-600 transition-all duration-200 hover:scale-105 hover:shadow-md" title="Editar">
                <i class="fa-solid fa-pen"></i>
                Editar
            </a>
            @if($candidate->resume_path)
                <a href="{{ route('candidates.download-resume', $candidate) }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-gradient-to-r from-green-600 to-emerald-600 text-white text-sm font-semibold rounded-xl shadow-sm hover:from-emerald-600 hover:to-green-600 transition-all duration-200 hover:scale-105 hover:shadow-md" title="Descargar CV">
                    <i class="fa-solid fa-download"></i>
                    CV
                </a>
            @endif
            <a href="{{ route('candidates.index') }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-gradient-to-r from-gray-500 to-gray-700 text-white text-sm font-semibold rounded-xl shadow-sm hover:from-gray-700 hover:to-gray-500 transition-all duration-200 hover:scale-105 hover:shadow-md" title="Volver">
                <i class="fa-solid fa-arrow-left"></i>
                Volver
            </a>
        </div>
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
                    <p class="text-sm text-gray-500 dark:text-gray-400">Teléfono</p>
                    <p class="font-medium text-gray-800 dark:text-white">{{ $candidate->phone ?? 'No especificado' }}</p>
                </div>
                <div class="transform transition-all duration-200 hover:scale-[1.02]">
                    <p class="text-sm text-gray-500 dark:text-gray-400">Fuente</p>
                    <p class="font-medium text-gray-800 dark:text-white">{{ $candidate->source ?? 'No especificado' }}</p>
                </div>
            </div>
        </div>

        <!-- Card Profesional -->
        <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-lg p-6 border border-gray-200 dark:border-gray-800 transform transition-all duration-300 hover:shadow-xl">
            <div class="flex items-center gap-2 mb-6">
                <div class="p-2 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-lg shadow-lg">
                    <i class="fa-solid fa-briefcase text-xl text-white"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-800 dark:text-white">Datos Profesionales</h3>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div class="transform transition-all duration-200 hover:scale-[1.02]">
                    <p class="text-sm text-gray-500 dark:text-gray-400">Vacante</p>
                    <p class="font-medium text-gray-800 dark:text-white">{{ $candidate->jobPosting->title }}</p>
                </div>
                <div class="transform transition-all duration-200 hover:scale-[1.02]">
                    <p class="text-sm text-gray-500 dark:text-gray-400">Cargo Actual</p>
                    <p class="font-medium text-gray-800 dark:text-white">{{ $candidate->current_position ?? 'No especificado' }}@if($candidate->current_company) en {{ $candidate->current_company }}@endif</p>
                </div>
                <div class="transform transition-all duration-200 hover:scale-[1.02]">
                    <p class="text-sm text-gray-500 dark:text-gray-400">Años de Experiencia</p>
                    <p class="font-medium text-gray-800 dark:text-white">{{ $candidate->years_of_experience ?? 'No especificado' }}</p>
                </div>
                <div class="transform transition-all duration-200 hover:scale-[1.02]">
                    <p class="text-sm text-gray-500 dark:text-gray-400">Nivel de Educación</p>
                    <p class="font-medium text-gray-800 dark:text-white">{{ $candidate->education_level ?? 'No especificado' }}</p>
                </div>
                <div class="transform transition-all duration-200 hover:scale-[1.02]">
                    <p class="text-sm text-gray-500 dark:text-gray-400">Salario Esperado</p>
                    <p class="font-medium text-gray-800 dark:text-white">{{ $candidate->expected_salary ? '$' . number_format($candidate->expected_salary, 2) : 'No especificado' }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Carta de Presentación -->
    @if($candidate->cover_letter)
        <div class="mt-10">
            <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-lg p-8 border border-gray-200 dark:border-gray-800 transform transition-all duration-300 hover:shadow-xl">
                <div class="flex items-center gap-2 mb-6">
                    <div class="p-2 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-lg shadow-lg">
                        <i class="fa-solid fa-envelope-open-text text-xl text-white"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-800 dark:text-white">Carta de Presentación</h3>
                </div>
                <div class="prose dark:prose-invert max-w-none">
                    {!! nl2br(e($candidate->cover_letter)) !!}
                </div>
            </div>
        </div>
    @endif

    <!-- Notas -->
    @if($candidate->notes)
        <div class="mt-10">
            <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-lg p-8 border border-gray-200 dark:border-gray-800 transform transition-all duration-300 hover:shadow-xl">
                <div class="flex items-center gap-2 mb-6">
                    <div class="p-2 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-lg shadow-lg">
                        <i class="fa-solid fa-sticky-note text-xl text-white"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-800 dark:text-white">Notas</h3>
                </div>
                <div class="prose dark:prose-invert max-w-none">
                    {!! nl2br(e($candidate->notes)) !!}
                </div>
            </div>
        </div>
    @endif

    <!-- Historial de Estados -->
    <div class="mt-10">
        <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-lg p-8 border border-gray-200 dark:border-gray-800 transform transition-all duration-300 hover:shadow-xl">
            <div class="flex items-center gap-2 mb-6">
                <div class="p-2 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-lg shadow-lg">
                    <i class="fa-solid fa-history text-xl text-white"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-800 dark:text-white">Historial de Estados</h3>
            </div>
            <div class="space-y-4">
                <!-- Aquí iría el historial de estados si lo implementamos -->
                <p class="text-gray-600 dark:text-gray-300">Estado actual: {{ ucfirst($candidate->status) }}</p>
            </div>
        </div>
    </div>
</div>
@endsection 