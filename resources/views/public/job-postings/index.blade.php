@extends('layouts.app')

@section('content')
<div class="bg-gray-50 dark:bg-gray-900">
    <!-- Hero Section -->
    <div class="relative bg-white dark:bg-gray-800 overflow-hidden">
        <div class="max-w-7xl mx-auto">
            <div class="relative z-10 pb-8 bg-white dark:bg-gray-800 sm:pb-16 md:pb-20 lg:max-w-2xl lg:w-full lg:pb-28 xl:pb-32">
                <main class="mt-10 mx-auto max-w-7xl px-4 sm:mt-12 sm:px-6 md:mt-16 lg:mt-20 lg:px-8 xl:mt-28">
                    <div class="sm:text-center lg:text-left">
                        <h1 class="text-4xl tracking-tight font-extrabold text-gray-900 dark:text-white sm:text-5xl md:text-6xl">
                            <span class="block">Encuentra tu próximo</span>
                            <span class="block text-blue-600">trabajo ideal</span>
                        </h1>
                        <p class="mt-3 text-base text-gray-500 dark:text-gray-400 sm:mt-5 sm:text-lg sm:max-w-xl sm:mx-auto md:mt-5 md:text-xl lg:mx-0">
                            Únete a nuestro equipo y forma parte de una empresa en constante crecimiento. Ofrecemos oportunidades de desarrollo profesional y un ambiente de trabajo dinámico.
                        </p>
                    </div>
                </main>
            </div>
        </div>
    </div>

    <!-- Filtros -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6 mb-8">
            <form action="{{ route('public.job-postings.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label for="search" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Buscar</label>
                    <input type="text" name="search" id="search" value="{{ request('search') }}"
                        placeholder="Título, descripción..."
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                </div>

                <div>
                    <label for="department" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Departamento</label>
                    <select name="department" id="department"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        <option value="">Todos los departamentos</option>
                        @foreach($departments as $department)
                            <option value="{{ $department->id }}" {{ request('department') == $department->id ? 'selected' : '' }}>
                                {{ $department->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="type" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tipo de Contrato</label>
                    <select name="type" id="type"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        <option value="">Todos los tipos</option>
                        <option value="Permanente" {{ request('type') == 'Permanente' ? 'selected' : '' }}>Permanente</option>
                        <option value="Temporario" {{ request('type') == 'Temporario' ? 'selected' : '' }}>Temporario</option>
                        <option value="Pasante" {{ request('type') == 'Pasante' ? 'selected' : '' }}>Pasante</option>
                    </select>
                </div>

                <div class="flex items-end">
                    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-md transition duration-150 ease-in-out">
                        <i class="fas fa-search mr-2"></i>Buscar
                    </button>
                </div>
            </form>
        </div>

        <!-- Listado de Vacantes -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($jobPostings as $jobPosting)
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm overflow-hidden hover:shadow-md transition duration-150 ease-in-out">
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
                                <i class="fas fa-map-marker-alt w-5"></i>
                                <span class="ml-2">{{ $jobPosting->location }}</span>
                            </div>
                            <div class="flex items-center text-gray-600 dark:text-gray-400">
                                <i class="fas fa-clock w-5"></i>
                                <span class="ml-2">{{ $jobPosting->work_schedule }}</span>
                            </div>
                            @if($jobPosting->min_salary && $jobPosting->max_salary)
                                <div class="flex items-center text-gray-600 dark:text-gray-400">
                                    <i class="fas fa-money-bill-wave w-5"></i>
                                    <span class="ml-2">${{ number_format($jobPosting->min_salary, 0) }} - ${{ number_format($jobPosting->max_salary, 0) }}</span>
                                </div>
                            @endif
                        </div>

                        <div class="flex justify-between items-center">
                            <a href="{{ route('public.job-postings.show', $jobPosting) }}" 
                                class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 font-medium">
                                Ver detalles
                            </a>
                            <span class="text-sm text-gray-500 dark:text-gray-400">
                                {{ $jobPosting->created_at->diffForHumans() }}
                            </span>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-3">
                    <div class="text-center py-12">
                        <i class="fas fa-briefcase text-4xl text-gray-400 mb-4"></i>
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