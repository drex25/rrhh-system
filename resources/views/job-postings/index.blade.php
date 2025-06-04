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
    <div class="bg-gray-50 dark:bg-gray-900 rounded-2xl shadow-lg p-8 mb-12 border border-gray-200 dark:border-gray-700">
        <form action="{{ route('job-postings.index') }}" method="GET" class="flex flex-col md:flex-row md:items-end md:space-x-4 gap-4">
            <div class="flex-1">
                <label for="search" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Buscar</label>
                <div class="relative">
                    <span class="absolute left-3 top-3 text-gray-400"><i class="fas fa-search"></i></span>
                    <input type="text" name="search" id="search" value="{{ request('search') }}"
                        class="w-full pl-10 pr-4 py-3 rounded-lg border-2 border-gray-200 dark:border-gray-600 dark:bg-gray-800 dark:text-white focus:border-[#0A0E20] focus:ring-[#0A0E20] transition duration-150"
                        placeholder="Título o descripción...">
                </div>
            </div>
            <div class="flex-1">
                <label for="department" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Departamento</label>
                <select name="department" id="department"
                    class="w-full py-3 rounded-lg border-2 border-gray-200 dark:border-gray-600 dark:bg-gray-800 dark:text-white focus:border-[#0A0E20] focus:ring-[#0A0E20] transition duration-150">
                    <option value="">Todos</option>
                    @foreach($departments as $department)
                        <option value="{{ $department->id }}" {{ request('department') == $department->id ? 'selected' : '' }}>
                            {{ $department->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="flex-1">
                <label for="status" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Estado</label>
                <select name="status" id="status"
                    class="w-full py-3 rounded-lg border-2 border-gray-200 dark:border-gray-600 dark:bg-gray-800 dark:text-white focus:border-[#0A0E20] focus:ring-[#0A0E20] transition duration-150">
                    <option value="">Todos</option>
                    <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Borrador</option>
                    <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>Publicada</option>
                    <option value="closed" {{ request('status') == 'closed' ? 'selected' : '' }}>Cerrada</option>
                </select>
            </div>
            <div class="flex-1">
                <label for="modality" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Modalidad</label>
                <select name="modality" id="modality"
                    class="w-full py-3 rounded-lg border-2 border-gray-200 dark:border-gray-600 dark:bg-gray-800 dark:text-white focus:border-[#0A0E20] focus:ring-[#0A0E20] transition duration-150">
                    <option value="">Todas</option>
                    <option value="remoto" {{ request('modality') == 'remoto' ? 'selected' : '' }}>Remoto</option>
                    <option value="hibrido" {{ request('modality') == 'hibrido' ? 'selected' : '' }}>Híbrido</option>
                    <option value="presencial" {{ request('modality') == 'presencial' ? 'selected' : '' }}>Presencial</option>
                </select>
            </div>
            <div class="flex items-end">
                <button type="submit" class="inline-flex items-center px-6 py-3 bg-[#0A0E20] hover:bg-[#1E3A8A] text-white text-lg font-bold rounded-lg shadow-lg transition duration-150 ease-in-out focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#1E3A8A]">
                    <i class="fas fa-search mr-2"></i> Filtrar
                </button>
            </div>
        </form>
    </div>

    <!-- Listado de Vacantes -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse($jobPostings as $jobPosting)
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl overflow-hidden hover:shadow-2xl transition duration-300 ease-in-out transform hover:-translate-y-1 border border-gray-100 dark:border-gray-700 relative">
                <!-- Badge de estado -->
                <span class="absolute top-6 left-6 px-4 py-2 rounded-full text-xs font-bold flex items-center gap-2 z-10
                    @if($jobPosting->status == 'published') bg-green-100 text-green-800 dark:bg-green-900/50 dark:text-green-200
                    @elseif($jobPosting->status == 'draft') bg-gray-200 text-gray-800 dark:bg-gray-700 dark:text-gray-200
                    @else bg-red-100 text-red-800 dark:bg-red-900/50 dark:text-red-200 @endif">
                    @if($jobPosting->status == 'published')
                        <i class="fas fa-check-circle"></i> Publicada
                    @elseif($jobPosting->status == 'draft')
                        <i class="fas fa-pencil-alt"></i> Borrador
                    @else
                        <i class="fas fa-times-circle"></i> Cerrada
                    @endif
                </span>
                <!-- Badge de modalidad -->
                <span class="absolute top-6 right-6 px-4 py-2 rounded-full text-xs font-bold flex items-center gap-2 z-10
                    @if($jobPosting->modality == 'remoto') bg-green-100 text-green-800 dark:bg-green-900/50 dark:text-green-200
                    @elseif($jobPosting->modality == 'hibrido') bg-yellow-100 text-yellow-800 dark:bg-yellow-900/50 dark:text-yellow-200
                    @else bg-blue-100 text-blue-800 dark:bg-blue-900/50 dark:text-blue-200 @endif">
                    @if($jobPosting->modality == 'remoto')
                        <i class="fas fa-house-laptop"></i> Remoto
                    @elseif($jobPosting->modality == 'hibrido')
                        <i class="fas fa-exchange-alt"></i> Híbrido
                    @else
                        <i class="fas fa-building"></i> Presencial
                    @endif
                </span>
                <div class="p-8 pt-20">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-2 line-clamp-2">
                        {{ $jobPosting->title }}
                    </h2>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">
                        {{ $jobPosting->department->name }} - {{ $jobPosting->position->title }}
                    </p>
                    <div class="space-y-4 mb-6">
                        <div class="flex items-center text-gray-600 dark:text-gray-400">
                            <i class="fas fa-map-marker-alt w-5 text-[#0A0E20]"></i>
                            <span class="ml-3">{{ $jobPosting->location }}</span>
                        </div>
                        <div class="flex items-center text-gray-600 dark:text-gray-400">
                            <i class="fas fa-clock w-5 text-[#0A0E20]"></i>
                            <span class="ml-3">{{ $jobPosting->work_schedule }}</span>
                        </div>
                        @if($jobPosting->min_salary && $jobPosting->max_salary)
                            <div class="flex items-center text-gray-600 dark:text-gray-400">
                                <i class="fas fa-money-bill-wave w-5 text-[#0A0E20]"></i>
                                <span class="ml-3">${{ number_format($jobPosting->min_salary, 0) }} - ${{ number_format($jobPosting->max_salary, 0) }}</span>
                            </div>
                        @endif
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
                            class="text-[#0A0E20] hover:text-[#1E3A8A] dark:text-blue-400 dark:hover:text-blue-300 font-bold transition duration-150 ease-in-out">
                            Ver detalles
                        </a>
                        <div class="flex items-center gap-4">
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