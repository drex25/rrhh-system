@extends('layouts.public')

@section('title', $jobPosting->title)

@section('content')
<div class="bg-gray-50 dark:bg-gray-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Breadcrumb -->
        <nav class="mb-8">
            <ol class="flex items-center space-x-2 text-sm">
                <li>
                    <a href="{{ route('public.job-postings.index') }}" class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300 flex items-center">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Volver a vacantes
                    </a>
                </li>
                <li class="text-gray-500 dark:text-gray-400">/</li>
                <li class="text-gray-900 dark:text-white font-medium truncate max-w-md">{{ $jobPosting->title }}</li>
            </ol>
        </nav>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Detalles de la Vacante -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Header Card -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden">
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
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-4">
                                <div class="flex items-center text-gray-600 dark:text-gray-400 p-3 rounded-lg bg-gray-50 dark:bg-gray-700">
                                    <i class="fas fa-map-marker-alt w-5 text-blue-500"></i>
                                    <span class="ml-3">{{ $jobPosting->location }}</span>
                                </div>
                                <div class="flex items-center text-gray-600 dark:text-gray-400 p-3 rounded-lg bg-gray-50 dark:bg-gray-700">
                                    <i class="fas fa-clock w-5 text-blue-500"></i>
                                    <span class="ml-3">{{ $jobPosting->work_schedule }}</span>
                                </div>
                            </div>
                            <div class="space-y-4">
                                @if($jobPosting->min_salary && $jobPosting->max_salary)
                                    <div class="flex items-center text-gray-600 dark:text-gray-400 p-3 rounded-lg bg-gray-50 dark:bg-gray-700">
                                        <i class="fas fa-money-bill-wave w-5 text-blue-500"></i>
                                        <span class="ml-3">${{ number_format($jobPosting->min_salary, 0) }} - ${{ number_format($jobPosting->max_salary, 0) }}</span>
                                    </div>
                                @endif
                                <div class="flex items-center text-gray-600 dark:text-gray-400 p-3 rounded-lg bg-gray-50 dark:bg-gray-700">
                                    <i class="fas fa-calendar-alt w-5 text-blue-500"></i>
                                    <span class="ml-3">Publicado {{ $jobPosting->created_at->diffForHumans() }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Descripción -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden">
                    <div class="p-6">
                        <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4 flex items-center">
                            <i class="fas fa-align-left mr-3 text-blue-500"></i>
                            Descripción
                        </h2>
                        <div class="prose dark:prose-invert max-w-none">
                            {!! $jobPosting->description !!}
                        </div>
                    </div>
                </div>

                <!-- Requisitos -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden">
                    <div class="p-6">
                        <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4 flex items-center">
                            <i class="fas fa-list-check mr-3 text-blue-500"></i>
                            Requisitos
                        </h2>
                        <div class="prose dark:prose-invert max-w-none">
                            {!! $jobPosting->requirements !!}
                        </div>
                    </div>
                </div>

                <!-- Responsabilidades -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden">
                    <div class="p-6">
                        <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4 flex items-center">
                            <i class="fas fa-tasks mr-3 text-blue-500"></i>
                            Responsabilidades
                        </h2>
                        <div class="prose dark:prose-invert max-w-none">
                            {!! $jobPosting->responsibilities !!}
                        </div>
                    </div>
                </div>

                <!-- Beneficios -->
                @if($jobPosting->benefits)
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden">
                        <div class="p-6">
                            <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4 flex items-center">
                                <i class="fas fa-gift mr-3 text-blue-500"></i>
                                Beneficios
                            </h2>
                            <div class="prose dark:prose-invert max-w-none">
                                {!! $jobPosting->benefits !!}
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Formulario de Aplicación -->
            <div class="lg:col-span-1">
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden sticky top-8">
                    <div class="p-6">
                        <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-6 flex items-center">
                            <i class="fas fa-paper-plane mr-3 text-blue-500"></i>
                            Aplicar a esta vacante
                        </h2>

                        @if(session('success'))
                            <div class="mb-4 p-4 rounded-lg bg-green-50 dark:bg-green-900 text-green-700 dark:text-green-200 flex items-center">
                                <i class="fas fa-check-circle mr-2"></i>
                                {{ session('success') }}
                            </div>
                        @endif

                        <form action="{{ route('public.job-postings.apply', $jobPosting) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                            @csrf

                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nombre completo</label>
                                <div class="mt-1 relative rounded-md shadow-sm">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-user text-gray-400"></i>
                                    </div>
                                    <input type="text" name="name" id="name" value="{{ old('name') }}" required
                                        class="block w-full pl-10 rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                </div>
                                @error('name')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Correo electrónico</label>
                                <div class="mt-1 relative rounded-md shadow-sm">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-envelope text-gray-400"></i>
                                    </div>
                                    <input type="email" name="email" id="email" value="{{ old('email') }}" required
                                        class="block w-full pl-10 rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                </div>
                                @error('email')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Teléfono</label>
                                <div class="mt-1 relative rounded-md shadow-sm">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-phone text-gray-400"></i>
                                    </div>
                                    <input type="tel" name="phone" id="phone" value="{{ old('phone') }}" required
                                        class="block w-full pl-10 rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                </div>
                                @error('phone')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="resume" class="block text-sm font-medium text-gray-700 dark:text-gray-300">CV (PDF, DOC, DOCX)</label>
                                <div class="mt-1">
                                    <div class="flex items-center justify-center w-full">
                                        <label for="resume" class="flex flex-col items-center justify-center w-full h-32 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-gray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
                                            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                                <i class="fas fa-file-upload text-3xl text-gray-400 mb-2"></i>
                                                <p class="mb-2 text-sm text-gray-500 dark:text-gray-400">
                                                    <span class="font-semibold">Haz clic para subir</span> o arrastra y suelta
                                                </p>
                                                <p class="text-xs text-gray-500 dark:text-gray-400">PDF, DOC o DOCX</p>
                                            </div>
                                            <input id="resume" name="resume" type="file" class="hidden" required accept=".pdf,.doc,.docx" />
                                        </label>
                                    </div>
                                </div>
                                @error('resume')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="cover_letter" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Carta de presentación</label>
                                <div class="mt-1 relative rounded-md shadow-sm">
                                    <div class="absolute top-3 left-3 pointer-events-none">
                                        <i class="fas fa-pen text-gray-400"></i>
                                    </div>
                                    <textarea name="cover_letter" id="cover_letter" rows="4" required
                                        class="block w-full pl-10 rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">{{ old('cover_letter') }}</textarea>
                                </div>
                                @error('cover_letter')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded-lg transition duration-150 ease-in-out flex items-center justify-center">
                                <i class="fas fa-paper-plane mr-2"></i>
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