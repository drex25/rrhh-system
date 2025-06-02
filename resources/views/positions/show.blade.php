@extends('layouts.admin')

@section('content')
<div class="w-full mx-auto px-4 md:px-6 lg:px-8 py-6">
    <!-- Header -->
    <div class="flex flex-col md:flex-row items-center justify-between bg-white dark:bg-gray-900 rounded-2xl shadow-lg p-8 mb-8 border border-gray-200 dark:border-gray-800 transform transition-all duration-300 hover:shadow-xl">
        <div class="flex items-center gap-4 mb-4 md:mb-0">
            <div class="p-3 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl shadow-lg">
                <i class="fa-solid fa-briefcase text-2xl text-white"></i>
            </div>
            <div>
                <h1 class="text-3xl md:text-4xl font-extrabold text-gray-800 dark:text-white tracking-tight">{{ $position->title }}</h1>
                <p class="text-gray-500 dark:text-gray-400 mt-1">Detalle del cargo</p>
            </div>
        </div>
        <div class="flex items-center gap-4">
            <a href="{{ route('positions.index') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-200 text-lg font-semibold rounded-xl shadow-lg hover:bg-gray-300 dark:hover:bg-gray-600 transition-all duration-200">
                <i class="fa-solid fa-arrow-left text-xl"></i>
                Volver
            </a>
            <a href="{{ route('positions.edit', $position) }}" class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-yellow-500 to-yellow-600 text-white text-lg font-semibold rounded-xl shadow-lg hover:scale-105 hover:from-yellow-600 hover:to-yellow-500 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-yellow-400">
                <i class="fa-solid fa-pen text-xl"></i>
                Editar
            </a>
        </div>
    </div>

    <!-- Información -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <!-- Información Básica -->
        <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-lg p-6 border border-gray-200 dark:border-gray-800 transform transition-all duration-300 hover:shadow-xl">
            <h2 class="text-xl font-bold text-gray-800 dark:text-white mb-4">Información Básica</h2>
            <div class="space-y-4">
                <div>
                    <div class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Código</div>
                    <div class="text-lg font-semibold text-gray-800 dark:text-white">{{ $position->code }}</div>
                </div>
                <div>
                    <div class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Departamento</div>
                    <div class="text-lg text-gray-800 dark:text-white">{{ $position->department->name ?? '-' }}</div>
                </div>
                <div>
                    <div class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Estado</div>
                    <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full {{ $position->is_active ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300' : 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300' }}">
                        {{ $position->is_active ? 'Activo' : 'Inactivo' }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Información Salarial -->
        <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-lg p-6 border border-gray-200 dark:border-gray-800 transform transition-all duration-300 hover:shadow-xl">
            <h2 class="text-xl font-bold text-gray-800 dark:text-white mb-4">Información Salarial</h2>
            <div class="space-y-4">
                <div>
                    <div class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Salario mínimo</div>
                    <div class="text-lg font-semibold text-gray-800 dark:text-white">{{ $position->min_salary ? number_format($position->min_salary, 2, ',', '.') : '-' }}</div>
                </div>
                <div>
                    <div class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Salario máximo</div>
                    <div class="text-lg font-semibold text-gray-800 dark:text-white">{{ $position->max_salary ? number_format($position->max_salary, 2, ',', '.') : '-' }}</div>
                </div>
            </div>
        </div>

        <!-- Descripción -->
        <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-lg p-6 border border-gray-200 dark:border-gray-800 transform transition-all duration-300 hover:shadow-xl md:col-span-2">
            <h2 class="text-xl font-bold text-gray-800 dark:text-white mb-4">Descripción</h2>
            <div class="prose dark:prose-invert max-w-none">
                {{ $position->description ?? 'No hay descripción disponible.' }}
            </div>
        </div>

        <!-- Responsabilidades -->
        <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-lg p-6 border border-gray-200 dark:border-gray-800 transform transition-all duration-300 hover:shadow-xl md:col-span-2">
            <h2 class="text-xl font-bold text-gray-800 dark:text-white mb-4">Responsabilidades</h2>
            <div class="prose dark:prose-invert max-w-none">
                {{ $position->responsibilities ?? 'No hay responsabilidades definidas.' }}
            </div>
        </div>
    </div>
</div>
@endsection 