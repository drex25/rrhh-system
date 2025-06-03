@extends('layouts.app')

@section('content')
<div class="bg-gray-50 dark:bg-gray-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Breadcrumb -->
        <nav class="mb-8">
            <ol class="flex items-center space-x-2 text-sm">
                <li>
                    <a href="{{ route('public.job-postings.index') }}" class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300">
                        Vacantes
                    </a>
                </li>
                <li class="text-gray-500 dark:text-gray-400">/</li>
                <li class="text-gray-900 dark:text-white font-medium">{{ $jobPosting->title }}</li>
            </ol>
        </nav>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Detalles de la Vacante -->
            <div class="lg:col-span-2">
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm overflow-hidden">
                    <div class="p-6">
                        <div class="flex justify-between items-start mb-6">
                            <div>
                                <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">
                                    {{ $jobPosting->title }}
                                </h1>
                                <p class="text-gray-600 dark:text-gray-400">
                                    {{ $jobPosting->department->name }} - {{ $jobPosting->position->name }}
                                </p>
                            </div>
                            <span class="px-4 py-2 rounded-full text-sm font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                {{ $jobPosting->employment_type }}
                            </span>
                        </div>

                        <!-- Información Principal -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                            <div class="space-y-4">
                                <div class="flex items-center text-gray-600 dark:text-gray-400">
                                    <i class="fas fa-map-marker-alt w-5"></i>
                                    <span class="ml-2">{{ $jobPosting->location }}</span>
                                </div>
                                <div class="flex items-center text-gray-600 dark:text-gray-400">
                                    <i class="fas fa-clock w-5"></i>
                                    <span class="ml-2">{{ $jobPosting->work_schedule }}</span>
                                </div>
                            </div>
                            <div class="space-y-4">
                                @if($jobPosting->min_salary && $jobPosting->max_salary)
                                    <div class="flex items-center text-gray-600 dark:text-gray-400">
                                        <i class="fas fa-money-bill-wave w-5"></i>
                                        <span class="ml-2">${{ number_format($jobPosting->min_salary, 0) }} - ${{ number_format($jobPosting->max_salary, 0) }}</span>
                                    </div>
                                @endif
                                <div class="flex items-center text-gray-600 dark:text-gray-400">
                                    <i class="fas fa-calendar-alt w-5"></i>
                                    <span class="ml-2">Publicado {{ $jobPosting->created_at->diffForHumans() }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Descripción -->
                        <div class="mb-8">
                            <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Descripción</h2>
                            <div class="prose dark:prose-invert max-w-none">
                                {!! $jobPosting->description !!}
                            </div>
                        </div>

                        <!-- Requisitos -->
                        <div class="mb-8">
                            <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Requisitos</h2>
                            <div class="prose dark:prose-invert max-w-none">
                                {!! $jobPosting->requirements !!}
                            </div>
                        </div>

                        <!-- Responsabilidades -->
                        <div class="mb-8">
                            <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Responsabilidades</h2>
                            <div class="prose dark:prose-invert max-w-none">
                                {!! $jobPosting->responsibilities !!}
                            </div>
                        </div>

                        <!-- Beneficios -->
                        @if($jobPosting->benefits)
                            <div>
                                <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Beneficios</h2>
                                <div class="prose dark:prose-invert max-w-none">
                                    {!! $jobPosting->benefits !!}
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Formulario de Aplicación -->
            <div class="lg:col-span-1">
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm overflow-hidden sticky top-8">
                    <div class="p-6">
                        <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-6">Aplicar a esta vacante</h2>

                        @if(session('success'))
                            <div class="mb-4 p-4 rounded-md bg-green-50 dark:bg-green-900 text-green-700 dark:text-green-200">
                                {{ session('success') }}
                            </div>
                        @endif

                        <form action="{{ route('public.job-postings.apply', $jobPosting) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                            @csrf

                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nombre completo</label>
                                <input type="text" name="name" id="name" value="{{ old('name') }}" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                @error('name')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Correo electrónico</label>
                                <input type="email" name="email" id="email" value="{{ old('email') }}" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                @error('email')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Teléfono</label>
                                <input type="tel" name="phone" id="phone" value="{{ old('phone') }}" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                @error('phone')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="resume" class="block text-sm font-medium text-gray-700 dark:text-gray-300">CV (PDF, DOC, DOCX)</label>
                                <input type="file" name="resume" id="resume" required
                                    class="mt-1 block w-full text-sm text-gray-500 dark:text-gray-400
                                    file:mr-4 file:py-2 file:px-4
                                    file:rounded-md file:border-0
                                    file:text-sm file:font-semibold
                                    file:bg-blue-50 file:text-blue-700
                                    dark:file:bg-blue-900 dark:file:text-blue-200
                                    hover:file:bg-blue-100 dark:hover:file:bg-blue-800">
                                @error('resume')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="cover_letter" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Carta de presentación</label>
                                <textarea name="cover_letter" id="cover_letter" rows="4" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">{{ old('cover_letter') }}</textarea>
                                @error('cover_letter')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-md transition duration-150 ease-in-out">
                                Enviar aplicación
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 