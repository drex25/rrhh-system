@extends('layouts.public')

@section('title', 'Empleos Disponibles')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900">
    <!-- Hero Section -->
    <div class="relative bg-gradient-to-r from-[#0A0E20] to-[#1E3A8A] dark:from-[#0A0E20] dark:to-[#1E3A8A] overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24">
            <div class="text-center">
                <h1 class="text-4xl tracking-tight font-extrabold text-white sm:text-5xl md:text-6xl">
                    <span class="block">Encuentra tu próximo</span>
                    <span class="block text-blue-200">trabajo ideal</span>
                </h1>
                <p class="mt-6 max-w-2xl mx-auto text-xl text-blue-100">
                    Únete a nuestro equipo y forma parte de una empresa en constante crecimiento. Ofrecemos oportunidades de desarrollo profesional y un ambiente de trabajo dinámico.
                </p>
            </div>
        </div>
        <div class="absolute inset-0 bg-grid-white/[0.05] bg-[size:60px_60px]"></div>
    </div>

    <!-- Filtros -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-8">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-xl p-6 mb-8 backdrop-blur-sm bg-opacity-90 dark:bg-opacity-90">
            <form action="{{ route('public.job-postings.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label for="search" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Buscar</label>
                    <div class="mt-1 relative rounded-md shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-search text-gray-400"></i>
                        </div>
                        <input type="text" name="search" id="search" value="{{ request('search') }}" 
                            placeholder="Título, descripción..."
                            class="block w-full pl-10 rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    </div>
                </div>

                <div>
                    <label for="department" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Departamento</label>
                    <div class="mt-1 relative rounded-md shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-building text-gray-400"></i>
                        </div>
                        <select name="department" id="department" 
                            class="block w-full pl-10 rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            <option value="">Todos los departamentos</option>
                            @foreach($departments as $department)
                                <option value="{{ $department->id }}" {{ request('department') == $department->id ? 'selected' : '' }}>
                                    {{ $department->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div>
                    <label for="type" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tipo de Contrato</label>
                    <div class="mt-1 relative rounded-md shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-file-contract text-gray-400"></i>
                        </div>
                        <select name="type" id="type"
                            class="block w-full pl-10 rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            <option value="">Todos los tipos</option>
                            <option value="Permanente" {{ request('type') == 'Permanente' ? 'selected' : '' }}>Permanente</option>
                            <option value="Temporario" {{ request('type') == 'Temporario' ? 'selected' : '' }}>Temporario</option>
                            <option value="Pasante" {{ request('type') == 'Pasante' ? 'selected' : '' }}>Pasante</option>
                        </select>
                    </div>
                </div>

                <div class="flex items-end">
                    <button type="submit" class="w-full bg-[#0A0E20] hover:bg-[#1E3A8A] text-white font-bold py-2 px-4 rounded-lg transition duration-150 ease-in-out flex items-center justify-center">
                        <i class="fas fa-search mr-2"></i>Buscar
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Listado de Vacantes -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($jobPostings as $jobPosting)
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition duration-150 ease-in-out transform hover:-translate-y-1">
                    <div class="p-6">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">
                                    {{ $jobPosting->title }}
                                </h2>
                                <p class="text-sm text-gray-600 dark:text-gray-400">
                                    {{ $jobPosting->department->name }} - {{ $jobPosting->position->name }}
                                </p>
                            </div>
                            <span class="px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                {{ $jobPosting->employment_type }}
                            </span>
                        </div>

                        <div class="space-y-3 mb-4">
                            <div class="flex items-center text-gray-600 dark:text-gray-400">
                                <i class="fas fa-map-marker-alt w-5 text-[#0A0E20]"></i>
                                <span class="ml-2">{{ $jobPosting->location }}</span>
                            </div>
                            <div class="flex items-center text-gray-600 dark:text-gray-400">
                                <i class="fas fa-clock w-5 text-[#0A0E20]"></i>
                                <span class="ml-2">{{ $jobPosting->work_schedule }}</span>
                            </div>
                            @if($jobPosting->min_salary && $jobPosting->max_salary)
                                <div class="flex items-center text-gray-600 dark:text-gray-400">
                                    <i class="fas fa-money-bill-wave w-5 text-[#0A0E20]"></i>
                                    <span class="ml-2">${{ number_format($jobPosting->min_salary, 0) }} - ${{ number_format($jobPosting->max_salary, 0) }}</span>
                                </div>
                            @endif
                        </div>

                        <div class="flex justify-between items-center">
                            <a href="{{ route('public.job-postings.show', $jobPosting) }}" 
                                class="inline-flex items-center text-[#0A0E20] hover:text-[#1E3A8A] dark:text-blue-400 dark:hover:text-blue-300 font-medium">
                                Ver detalles
                                <i class="fas fa-arrow-right ml-2"></i>
                            </a>
                            <span class="text-sm text-gray-500 dark:text-gray-400">
                                {{ $jobPosting->created_at->diffForHumans() }}
                            </span>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-3">
                    <div class="text-center py-12 bg-white dark:bg-gray-800 rounded-xl shadow-lg">
                        <div class="bg-gray-100 dark:bg-gray-700 rounded-full w-20 h-20 flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-briefcase text-4xl text-gray-400"></i>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">No se encontraron vacantes</h3>
                        <p class="text-gray-500 dark:text-gray-400">No hay vacantes disponibles que coincidan con tus criterios de búsqueda.</p>
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Paginación -->
        <div class="mt-8">
            {{ $jobPostings->links() }}
        </div>
    </div>
</div>
@endsection 