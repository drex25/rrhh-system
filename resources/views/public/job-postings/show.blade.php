@extends('layouts.public')

@section('title', $jobPosting->title)

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900">
    <!-- Hero Section Mejorada -->
    <div class="relative bg-gradient-to-r from-[#0A0E20] to-[#1E3A8A] dark:from-[#0A0E20] dark:to-[#1E3A8A] overflow-hidden">
        <div class="absolute inset-0 bg-grid-white/[0.05] bg-[size:60px_60px]"></div>
        @if($jobPosting->is_featured)
            <div class="absolute top-6 right-6 bg-gradient-to-r from-yellow-400 to-yellow-600 text-white px-6 py-2 rounded-full font-bold text-sm flex items-center gap-2 z-20 shadow-lg">
                <i class="fas fa-star"></i>
                Vacante Destacada
            </div>
        @endif
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div class="relative z-10">
                <!-- Breadcrumb -->
                <nav class="flex mb-8" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-1 md:space-x-3">
                        <li class="inline-flex items-center">
                            <a href="{{ route('public.job-postings.index') }}" class="text-blue-100 hover:text-white transition duration-150 ease-in-out">
                                <i class="fas fa-home mr-2"></i>
                                Inicio
                            </a>
                        </li>
                        <li>
                            <div class="flex items-center">
                                <i class="fas fa-chevron-right text-blue-100 mx-2"></i>
                                <span class="text-white">Detalles de la Vacante</span>
                            </div>
                        </li>
                    </ol>
                </nav>

                <!-- Título y datos clave sobre fondo azul -->
                <div class="text-center md:text-left">
                    <h1 class="text-4xl sm:text-5xl md:text-6xl font-extrabold text-white mb-6 drop-shadow-lg">
                        {{ $jobPosting->title }}
                    </h1>
                    <div class="flex flex-wrap gap-6 items-center justify-center md:justify-start mb-6">
                        <div class="flex items-center text-blue-100 text-lg">
                            <i class="fas fa-building w-6 mr-2"></i>
                            {{ $jobPosting->department->name }}
                        </div>
                        <div class="flex items-center text-blue-100 text-lg">
                            <i class="fas fa-briefcase w-6 mr-2"></i>
                            {{ $jobPosting->position->title }}
                        </div>
                        <div class="flex items-center text-blue-100 text-lg">
                            <i class="fas fa-map-marker-alt w-6 mr-2"></i>
                            {{ $jobPosting->location }}
                        </div>
                        <span class="inline-block px-4 py-2 rounded-full text-base font-semibold flex items-center gap-2
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
                    </div>
                    <div class="flex flex-wrap gap-6 items-center justify-center md:justify-start">
                        <div class="flex items-center text-blue-200 text-base">
                            <i class="fas fa-clock w-5 mr-2"></i>
                            {{ $jobPosting->work_schedule }}
                        </div>
                        @if($jobPosting->min_salary && $jobPosting->max_salary)
                        <div class="flex items-center text-blue-200 text-base">
                            <i class="fas fa-money-bill-wave w-5 mr-2"></i>
                            ${{ number_format($jobPosting->min_salary, 0) }} - ${{ number_format($jobPosting->max_salary, 0) }}
                        </div>
                        @endif
                        <div class="flex items-center text-blue-200 text-base">
                            <i class="fas fa-calendar-alt w-5 mr-2"></i>
                            Publicado {{ $jobPosting->created_at->diffForHumans() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Contenido Principal -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Detalles de la Vacante -->
            <div class="lg:col-span-2 space-y-8">
                <!-- Descripción -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-8 border border-gray-100 dark:border-gray-700">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6 flex items-center">
                        <i class="fas fa-align-left w-8 text-[#0A0E20]"></i>
                        <span class="ml-2">Descripción del Puesto</span>
                    </h2>
                    <div class="prose dark:prose-invert max-w-none">
                        {!! nl2br(e($jobPosting->description)) !!}
                    </div>
                </div>

                <!-- Requisitos -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-8 border border-gray-100 dark:border-gray-700">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6 flex items-center">
                        <i class="fas fa-list-check w-8 text-[#0A0E20]"></i>
                        <span class="ml-2">Requisitos</span>
                    </h2>
                    <div class="prose dark:prose-invert max-w-none">
                        {!! nl2br(e($jobPosting->requirements)) !!}
                    </div>
                </div>

                <!-- Responsabilidades -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-8 border border-gray-100 dark:border-gray-700">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6 flex items-center">
                        <i class="fas fa-tasks w-8 text-[#0A0E20]"></i>
                        <span class="ml-2">Responsabilidades</span>
                    </h2>
                    <div class="prose dark:prose-invert max-w-none">
                        {!! nl2br(e($jobPosting->responsibilities)) !!}
                    </div>
                </div>

                <!-- Beneficios -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-8 border border-gray-100 dark:border-gray-700">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6 flex items-center">
                        <i class="fas fa-gift w-8 text-[#0A0E20]"></i>
                        <span class="ml-2">Beneficios</span>
                    </h2>
                    <div class="prose dark:prose-invert max-w-none">
                        {!! nl2br(e($jobPosting->benefits)) !!}
                    </div>
                </div>
            </div>

            <!-- Formulario de Aplicación -->
            <div class="lg:col-span-1">
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-8 border border-gray-100 dark:border-gray-700 sticky top-24">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6 flex items-center">
                        <i class="fas fa-paper-plane w-8 text-[#0A0E20]"></i>
                        <span class="ml-2">Aplicar Ahora</span>
                    </h2>
                    <form action="{{ route('public.job-postings.apply', $jobPosting) }}" method="POST" enctype="multipart/form-data" class="space-y-6 max-w-xl mx-auto">
                        @csrf
                        
                        @if(session('error'))
                            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                                <span class="block sm:inline">{{ session('error') }}</span>
                            </div>
                        @endif

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="first_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Nombre *</label>
                                <input type="text" name="first_name" id="first_name" required value="{{ old('first_name') }}"
                                    class="block w-full rounded-xl border-2 border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-[#0A0E20] focus:ring-[#0A0E20] transition duration-150 px-4 py-3 text-base shadow-sm">
                                @error('first_name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="last_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Apellido *</label>
                                <input type="text" name="last_name" id="last_name" required value="{{ old('last_name') }}"
                                    class="block w-full rounded-xl border-2 border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-[#0A0E20] focus:ring-[#0A0E20] transition duration-150 px-4 py-3 text-base shadow-sm">
                                @error('last_name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="years_of_experience" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Años de Experiencia</label>
                                <input type="number" name="years_of_experience" id="years_of_experience" min="0" value="{{ old('years_of_experience') }}"
                                    class="block w-full rounded-xl border-2 border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-[#0A0E20] focus:ring-[#0A0E20] transition duration-150 px-4 py-3 text-base shadow-sm">
                                @error('years_of_experience')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="education_level" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Nivel de Educación</label>
                                <select name="education_level" id="education_level"
                                    class="block w-full rounded-xl border-2 border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-[#0A0E20] focus:ring-[#0A0E20] transition duration-150 px-4 py-3 text-base shadow-sm">
                                    <option value="">Seleccione...</option>
                                    <option value="Secundaria" {{ old('education_level') == 'Secundaria' ? 'selected' : '' }}>Secundaria</option>
                                    <option value="Técnico" {{ old('education_level') == 'Técnico' ? 'selected' : '' }}>Técnico</option>
                                    <option value="Universitario" {{ old('education_level') == 'Universitario' ? 'selected' : '' }}>Universitario</option>
                                    <option value="Maestría" {{ old('education_level') == 'Maestría' ? 'selected' : '' }}>Maestría</option>
                                    <option value="Doctorado" {{ old('education_level') == 'Doctorado' ? 'selected' : '' }}>Doctorado</option>
                                </select>
                                @error('education_level')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="space-y-4">
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Correo Electrónico *</label>
                                <input type="email" name="email" id="email" required value="{{ old('email') }}"
                                    class="block w-full rounded-xl border-2 border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-[#0A0E20] focus:ring-[#0A0E20] transition duration-150 px-4 py-3 text-base shadow-sm">
                                @error('email')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Teléfono *</label>
                                <input type="tel" name="phone" id="phone" required value="{{ old('phone') }}"
                                    class="block w-full rounded-xl border-2 border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-[#0A0E20] focus:ring-[#0A0E20] transition duration-150 px-4 py-3 text-base shadow-sm">
                                @error('phone')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="resume" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">CV (PDF, DOC, DOCX) *</label>
                                <input type="file" name="resume" id="resume" accept=".pdf,.doc,.docx" required
                                    class="block w-full text-sm text-gray-500 dark:text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-medium file:bg-[#0A0E20] file:text-white hover:file:bg-[#1E3A8A] dark:file:bg-[#0A0E20] dark:file:text-white transition duration-150 ease-in-out">
                                @error('resume')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="cover_letter" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Carta de Presentación</label>
                                <textarea name="cover_letter" id="cover_letter" rows="4"
                                    class="block w-full rounded-xl border-2 border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-[#0A0E20] focus:ring-[#0A0E20] transition duration-150 px-4 py-3 text-base shadow-sm">{{ old('cover_letter') }}</textarea>
                                @error('cover_letter')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <button type="submit" class="w-full bg-[#0A0E20] hover:bg-[#1E3A8A] text-white font-bold py-3 px-6 rounded-xl transition duration-150 ease-in-out flex items-center justify-center text-lg shadow-md">
                                    <i class="fas fa-paper-plane mr-2"></i>
                                    Enviar Aplicación
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 