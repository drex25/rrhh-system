@extends('layouts.admin')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900">
    <div class="container mx-auto px-4 py-8">
        <div class="w-full mx-auto max-w-7xl">
            <!-- Header with gradient background -->
            <div class="bg-gradient-to-r from-blue-600 to-indigo-700 dark:from-gray-800 dark:to-gray-900 rounded-2xl shadow-xl p-8 mb-8">
                <div class="flex justify-between items-center">
                    <div>
                        <h1 class="text-4xl font-bold text-white mb-3">{{ $jobPosting->title }}</h1>
                        <p class="text-blue-100 dark:text-gray-300 text-lg">
                            {{ $jobPosting->department->name }} - {{ $jobPosting->position->name }}
                        </p>
                    </div>
                    <div class="flex items-center space-x-4">
                        <a href="{{ route('job-postings.edit', $jobPosting) }}" 
                            class="p-2 rounded-full bg-white/10 hover:bg-white/20 text-white transition-colors">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('job-postings.destroy', $jobPosting) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="p-2 rounded-full bg-white/10 hover:bg-white/20 text-white transition-colors"
                                onclick="return confirm('¿Estás seguro de eliminar esta vacante?')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                        <a href="{{ route('job-postings.index') }}" class="p-2 rounded-full bg-white/10 hover:bg-white/20 text-white transition-colors">
                            <i class="fas fa-arrow-left"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Estado y Acciones -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 mb-8 backdrop-blur-sm bg-opacity-90 dark:bg-opacity-90">
                <div class="flex flex-wrap items-center justify-between gap-4">
                    <div class="flex items-center space-x-4">
                        <span class="px-4 py-2 rounded-full text-sm font-medium shadow-sm {{ $jobPosting->status_badge['class'] }}">
                            {{ $jobPosting->status_badge['text'] }}
                        </span>
                        @if($jobPosting->is_featured)
                            <span class="px-4 py-2 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800 shadow-sm">
                                <i class="fas fa-star mr-1"></i> Destacada
                            </span>
                        @endif
                        @if($jobPosting->is_active)
                            <span class="px-4 py-2 rounded-full text-sm font-medium bg-green-100 text-green-800 shadow-sm">
                                <i class="fas fa-check-circle mr-1"></i> Activa
                            </span>
                        @endif
                    </div>
                    <div class="flex items-center space-x-4">
                        <form action="{{ route('job-postings.toggle-status', $jobPosting) }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="p-2 rounded-full bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-600 dark:text-gray-300 transition-colors">
                                <i class="fas fa-power-off"></i>
                            </button>
                        </form>
                        <form action="{{ route('job-postings.toggle-featured', $jobPosting) }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="p-2 rounded-full bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-600 dark:text-gray-300 transition-colors">
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
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 hover:shadow-xl transition-shadow">
                        <h2 class="text-2xl font-semibold text-gray-900 dark:text-white mb-6 flex items-center">
                            <i class="fas fa-briefcase mr-3 text-blue-500"></i>
                            Detalles del Puesto
                        </h2>
                        <div class="space-y-4">
                            <div class="flex items-center text-gray-600 dark:text-gray-400 p-3 rounded-lg bg-gray-50 dark:bg-gray-700">
                                <i class="fas fa-briefcase w-5 text-blue-500"></i>
                                <span class="ml-3">{{ $jobPosting->employment_type }} - {{ $jobPosting->work_schedule }}</span>
                            </div>
                            <div class="flex items-center text-gray-600 dark:text-gray-400 p-3 rounded-lg bg-gray-50 dark:bg-gray-700">
                                <i class="fas fa-map-marker-alt w-5 text-blue-500"></i>
                                <span class="ml-3">{{ $jobPosting->location }}</span>
                            </div>
                            <div class="flex items-center text-gray-600 dark:text-gray-400 p-3 rounded-lg bg-gray-50 dark:bg-gray-700">
                                <i class="fas fa-money-bill-wave w-5 text-blue-500"></i>
                                <span class="ml-3">{{ $jobPosting->salary_range }}</span>
                            </div>
                            <div class="flex items-center text-gray-600 dark:text-gray-400 p-3 rounded-lg bg-gray-50 dark:bg-gray-700">
                                <i class="fas fa-users w-5 text-blue-500"></i>
                                <span class="ml-3">{{ $jobPosting->vacancies }} vacante(s)</span>
                            </div>
                            @if($jobPosting->application_deadline)
                                <div class="flex items-center text-gray-600 dark:text-gray-400 p-3 rounded-lg bg-gray-50 dark:bg-gray-700">
                                    <i class="fas fa-calendar-alt w-5 text-blue-500"></i>
                                    <span class="ml-3">Fecha límite: {{ $jobPosting->application_deadline->format('d/m/Y') }}</span>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 hover:shadow-xl transition-shadow">
                        <h2 class="text-2xl font-semibold text-gray-900 dark:text-white mb-6 flex items-center">
                            <i class="fas fa-align-left mr-3 text-blue-500"></i>
                            Descripción
                        </h2>
                        <div class="prose dark:prose-invert max-w-none">
                            {!! $jobPosting->description !!}
                        </div>
                    </div>

                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 hover:shadow-xl transition-shadow">
                        <h2 class="text-2xl font-semibold text-gray-900 dark:text-white mb-6 flex items-center">
                            <i class="fas fa-list-check mr-3 text-blue-500"></i>
                            Requisitos
                        </h2>
                        <div class="prose dark:prose-invert max-w-none">
                            {!! $jobPosting->requirements !!}
                        </div>
                    </div>

                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 hover:shadow-xl transition-shadow">
                        <h2 class="text-2xl font-semibold text-gray-900 dark:text-white mb-6 flex items-center">
                            <i class="fas fa-tasks mr-3 text-blue-500"></i>
                            Responsabilidades
                        </h2>
                        <div class="prose dark:prose-invert max-w-none">
                            {!! $jobPosting->responsibilities !!}
                        </div>
                    </div>

                    @if($jobPosting->benefits)
                        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 hover:shadow-xl transition-shadow">
                            <h2 class="text-2xl font-semibold text-gray-900 dark:text-white mb-6 flex items-center">
                                <i class="fas fa-gift mr-3 text-blue-500"></i>
                                Beneficios
                            </h2>
                            <div class="prose dark:prose-invert max-w-none">
                                {!! $jobPosting->benefits !!}
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Candidatos -->
                <div class="space-y-8">
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 hover:shadow-xl transition-shadow">
                        <div class="flex justify-between items-center mb-6">
                            <h2 class="text-2xl font-semibold text-gray-900 dark:text-white flex items-center">
                                <i class="fas fa-users mr-3 text-blue-500"></i>
                                Candidatos
                            </h2>
                            <span class="px-4 py-2 rounded-full text-sm font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200 shadow-sm">
                                {{ $jobPosting->candidates->count() }} aplicaciones
                            </span>
                        </div>

                        @if($jobPosting->candidates->count() > 0)
                            <div class="space-y-4">
                                @foreach($jobPosting->candidates as $candidate)
                                    <div class="border dark:border-gray-700 rounded-xl p-4 hover:shadow-md transition-shadow bg-gray-50 dark:bg-gray-700">
                                        <div class="flex items-center justify-between">
                                            <div>
                                                <h3 class="font-medium text-gray-900 dark:text-white text-lg">{{ $candidate->name }}</h3>
                                                <p class="text-sm text-gray-600 dark:text-gray-400">{{ $candidate->email }}</p>
                                            </div>
                                            <span class="px-3 py-1 rounded-full text-sm font-medium shadow-sm {{ $candidate->status_badge['class'] }}">
                                                {{ $candidate->status_badge['text'] }}
                                            </span>
                                        </div>
                                        <div class="mt-3 flex items-center text-sm text-gray-600 dark:text-gray-400">
                                            <i class="fas fa-calendar w-5 text-blue-500"></i>
                                            <span class="ml-2">Aplicó el {{ $candidate->created_at->format('d/m/Y') }}</span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-12">
                                <div class="bg-gray-100 dark:bg-gray-700 rounded-full w-20 h-20 flex items-center justify-center mx-auto mb-4">
                                    <i class="fas fa-users text-4xl text-gray-400"></i>
                                </div>
                                <p class="text-gray-600 dark:text-gray-400 text-lg">No hay candidatos aplicados aún.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@if(session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'success',
                title: '¡Éxito!',
                text: '{{ session('success') }}',
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 2500,
                customClass: { popup: 'rounded-xl' }
            });
        });
    </script>
@endif
@endsection 