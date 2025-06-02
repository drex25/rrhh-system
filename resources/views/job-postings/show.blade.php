@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">{{ $jobPosting->title }}</h1>
                <p class="text-gray-600 dark:text-gray-400 mt-2">
                    {{ $jobPosting->department->name }} - {{ $jobPosting->position->name }}
                </p>
            </div>
            <div class="flex items-center space-x-4">
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
                <a href="{{ route('job-postings.index') }}" class="text-gray-600 hover:text-gray-800 dark:text-gray-400 dark:hover:text-gray-300">
                    <i class="fas fa-arrow-left"></i>
                </a>
            </div>
        </div>

        <!-- Estado y Acciones -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 mb-8">
            <div class="flex flex-wrap items-center justify-between gap-4">
                <div class="flex items-center space-x-4">
                    <span class="px-3 py-1 rounded-full text-sm font-medium {{ $jobPosting->status_badge['class'] }}">
                        {{ $jobPosting->status_badge['text'] }}
                    </span>
                    @if($jobPosting->is_featured)
                        <span class="px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                            Destacada
                        </span>
                    @endif
                    @if($jobPosting->is_active)
                        <span class="px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                            Activa
                        </span>
                    @endif
                </div>
                <div class="flex items-center space-x-4">
                    <form action="{{ route('job-postings.toggle-status', $jobPosting) }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="text-gray-600 hover:text-gray-800 dark:text-gray-400 dark:hover:text-gray-300">
                            <i class="fas fa-power-off"></i>
                        </button>
                    </form>
                    <form action="{{ route('job-postings.toggle-featured', $jobPosting) }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="text-gray-600 hover:text-gray-800 dark:text-gray-400 dark:hover:text-gray-300">
                            <i class="fas fa-star"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Información Principal -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Detalles del Puesto -->
            <div class="space-y-8">
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Detalles del Puesto</h2>
                    <div class="space-y-4">
                        <div class="flex items-center text-gray-600 dark:text-gray-400">
                            <i class="fas fa-briefcase w-5"></i>
                            <span class="ml-2">{{ $jobPosting->employment_type }} - {{ $jobPosting->work_schedule }}</span>
                        </div>
                        <div class="flex items-center text-gray-600 dark:text-gray-400">
                            <i class="fas fa-map-marker-alt w-5"></i>
                            <span class="ml-2">{{ $jobPosting->location }}</span>
                        </div>
                        <div class="flex items-center text-gray-600 dark:text-gray-400">
                            <i class="fas fa-money-bill-wave w-5"></i>
                            <span class="ml-2">{{ $jobPosting->salary_range }}</span>
                        </div>
                        <div class="flex items-center text-gray-600 dark:text-gray-400">
                            <i class="fas fa-users w-5"></i>
                            <span class="ml-2">{{ $jobPosting->vacancies }} vacante(s)</span>
                        </div>
                        @if($jobPosting->application_deadline)
                            <div class="flex items-center text-gray-600 dark:text-gray-400">
                                <i class="fas fa-calendar-alt w-5"></i>
                                <span class="ml-2">Fecha límite: {{ $jobPosting->application_deadline->format('d/m/Y') }}</span>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Descripción</h2>
                    <div class="prose dark:prose-invert max-w-none">
                        {!! nl2br(e($jobPosting->description)) !!}
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Requisitos</h2>
                    <div class="prose dark:prose-invert max-w-none">
                        {!! nl2br(e($jobPosting->requirements)) !!}
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Responsabilidades</h2>
                    <div class="prose dark:prose-invert max-w-none">
                        {!! nl2br(e($jobPosting->responsibilities)) !!}
                    </div>
                </div>

                @if($jobPosting->benefits)
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
                        <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Beneficios</h2>
                        <div class="prose dark:prose-invert max-w-none">
                            {!! nl2br(e($jobPosting->benefits)) !!}
                        </div>
                    </div>
                @endif
            </div>

            <!-- Candidatos -->
            <div class="space-y-8">
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Candidatos</h2>
                        <span class="px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                            {{ $jobPosting->candidates->count() }} aplicaciones
                        </span>
                    </div>

                    @if($jobPosting->candidates->count() > 0)
                        <div class="space-y-4">
                            @foreach($jobPosting->candidates as $candidate)
                                <div class="border dark:border-gray-700 rounded-lg p-4">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <h3 class="font-medium text-gray-900 dark:text-white">{{ $candidate->name }}</h3>
                                            <p class="text-sm text-gray-600 dark:text-gray-400">{{ $candidate->email }}</p>
                                        </div>
                                        <span class="px-3 py-1 rounded-full text-sm font-medium {{ $candidate->status_badge['class'] }}">
                                            {{ $candidate->status_badge['text'] }}
                                        </span>
                                    </div>
                                    <div class="mt-2 flex items-center text-sm text-gray-600 dark:text-gray-400">
                                        <i class="fas fa-calendar w-5"></i>
                                        <span class="ml-2">Aplicó el {{ $candidate->created_at->format('d/m/Y') }}</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8">
                            <i class="fas fa-users text-4xl text-gray-400 mb-4"></i>
                            <p class="text-gray-600 dark:text-gray-400">No hay candidatos aplicados aún.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 