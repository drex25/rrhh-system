@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Header -->
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Gestión de Vacantes</h1>
        <a href="{{ route('job-postings.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg flex items-center gap-2">
            <i class="fas fa-plus"></i>
            Nueva Vacante
        </a>
    </div>

    <!-- Filtros -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 mb-8">
        <form action="{{ route('job-postings.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label for="search" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Buscar</label>
                <input type="text" name="search" id="search" value="{{ request('search') }}" 
                    class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-blue-500 focus:border-blue-500"
                    placeholder="Título o descripción...">
            </div>
            <div>
                <label for="department" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Departamento</label>
                <select name="department" id="department" 
                    class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Todos</option>
                    @foreach($departments as $department)
                        <option value="{{ $department->id }}" {{ request('department') == $department->id ? 'selected' : '' }}>
                            {{ $department->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Estado</label>
                <select name="status" id="status" 
                    class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Todos</option>
                    <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Borrador</option>
                    <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>Publicada</option>
                    <option value="closed" {{ request('status') == 'closed' ? 'selected' : '' }}>Cerrada</option>
                </select>
            </div>
            <div>
                <label for="type" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tipo de Contrato</label>
                <select name="type" id="type" 
                    class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Todos</option>
                    <option value="Permanente" {{ request('type') == 'Permanente' ? 'selected' : '' }}>Permanente</option>
                    <option value="Temporario" {{ request('type') == 'Temporario' ? 'selected' : '' }}>Temporario</option>
                    <option value="Pasante" {{ request('type') == 'Pasante' ? 'selected' : '' }}>Pasante</option>
                </select>
            </div>
            <div class="md:col-span-4 flex justify-end">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg flex items-center gap-2">
                    <i class="fas fa-search"></i>
                    Filtrar
                </button>
            </div>
        </form>
    </div>

    <!-- Listado de Vacantes -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($jobPostings as $jobPosting)
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
                <div class="p-6">
                    <div class="flex justify-between items-start mb-4">
                        <h2 class="text-xl font-semibold text-gray-900 dark:text-white">{{ $jobPosting->title }}</h2>
                        <span class="px-3 py-1 rounded-full text-sm font-medium {{ $jobPosting->status_badge['class'] }}">
                            {{ $jobPosting->status_badge['text'] }}
                        </span>
                    </div>
                    
                    <div class="space-y-3 mb-4">
                        <div class="flex items-center text-gray-600 dark:text-gray-400">
                            <i class="fas fa-building w-5"></i>
                            <span class="ml-2">{{ $jobPosting->department->name }}</span>
                        </div>
                        <div class="flex items-center text-gray-600 dark:text-gray-400">
                            <i class="fas fa-briefcase w-5"></i>
                            <span class="ml-2">{{ $jobPosting->position->name }}</span>
                        </div>
                        <div class="flex items-center text-gray-600 dark:text-gray-400">
                            <i class="fas fa-map-marker-alt w-5"></i>
                            <span class="ml-2">{{ $jobPosting->location }}</span>
                        </div>
                        <div class="flex items-center text-gray-600 dark:text-gray-400">
                            <i class="fas fa-clock w-5"></i>
                            <span class="ml-2">{{ $jobPosting->employment_type }} - {{ $jobPosting->work_schedule }}</span>
                        </div>
                    </div>

                    <div class="flex items-center justify-between text-sm text-gray-600 dark:text-gray-400 mb-4">
                        <div class="flex items-center">
                            <i class="fas fa-users w-5"></i>
                            <span class="ml-2">{{ $jobPosting->applications_count }} candidatos</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-calendar w-5"></i>
                            <span class="ml-2">{{ $jobPosting->created_at->format('d/m/Y') }}</span>
                        </div>
                    </div>

                    <div class="flex justify-between items-center">
                        <a href="{{ route('job-postings.show', $jobPosting) }}" 
                            class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 font-medium">
                            Ver detalles
                        </a>
                        <div class="flex items-center gap-2">
                            <a href="{{ route('job-postings.edit', $jobPosting) }}" 
                                class="text-gray-600 hover:text-gray-800 dark:text-gray-400 dark:hover:text-gray-300">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('job-postings.destroy', $jobPosting) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300"
                                    onclick="return confirm('¿Estás seguro de eliminar esta vacante?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full">
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 text-center">
                    <i class="fas fa-briefcase text-4xl text-gray-400 mb-4"></i>
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">No hay vacantes disponibles</h3>
                    <p class="text-gray-600 dark:text-gray-400">Crea una nueva vacante para comenzar a recibir aplicaciones.</p>
                </div>
            </div>
        @endforelse
    </div>

    <!-- Paginación -->
    <div class="mt-8">
        {{ $jobPostings->links() }}
    </div>
</div>
@endsection 