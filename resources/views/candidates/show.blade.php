@extends('layouts.admin')

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                            {{ __('Detalles del Candidato') }}
                        </h2>
                        <div class="flex space-x-2">
                            <a href="{{ route('candidates.edit', $candidate) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                <i class="fas fa-edit mr-2"></i>Editar
                            </a>
                            <a href="{{ route('candidates.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                <i class="fas fa-arrow-left mr-2"></i>Volver
                            </a>
                        </div>
                    </div>

                    <!-- Estado del Candidato -->
                    <div class="mb-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-2xl font-bold text-gray-900 dark:text-white">
                                    {{ $candidate->full_name }}
                                </h3>
                                <p class="text-gray-600 dark:text-gray-300">
                                    {{ $candidate->email }}
                                </p>
                            </div>
                            <div class="flex items-center space-x-4">
                                <span class="px-3 py-1 text-sm font-semibold rounded-full {{ $candidate->status_badge }}">
                                    {{ ucfirst($candidate->status) }}
                                </span>
                                @if($candidate->resume_path)
                                    <a href="{{ route('candidates.download-resume', $candidate) }}" 
                                       class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                        <i class="fas fa-download mr-2"></i>Descargar CV
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Información Personal -->
                        <div class="space-y-6">
                            <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6">
                                <h4 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Información Personal</h4>
                                <div class="space-y-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Teléfono</label>
                                        <p class="mt-1 text-sm text-gray-900 dark:text-white">
                                            {{ $candidate->phone ?? 'No especificado' }}
                                        </p>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Fuente</label>
                                        <p class="mt-1 text-sm text-gray-900 dark:text-white">
                                            {{ $candidate->source ?? 'No especificado' }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Información Profesional -->
                        <div class="space-y-6">
                            <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6">
                                <h4 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Información Profesional</h4>
                                <div class="space-y-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Vacante</label>
                                        <p class="mt-1 text-sm text-gray-900 dark:text-white">
                                            {{ $candidate->jobPosting->title }}
                                        </p>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Cargo Actual</label>
                                        <p class="mt-1 text-sm text-gray-900 dark:text-white">
                                            {{ $candidate->current_position ?? 'No especificado' }}
                                            @if($candidate->current_company)
                                                en {{ $candidate->current_company }}
                                            @endif
                                        </p>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Años de Experiencia</label>
                                        <p class="mt-1 text-sm text-gray-900 dark:text-white">
                                            {{ $candidate->years_of_experience ?? 'No especificado' }}
                                        </p>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nivel de Educación</label>
                                        <p class="mt-1 text-sm text-gray-900 dark:text-white">
                                            {{ $candidate->education_level ?? 'No especificado' }}
                                        </p>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Salario Esperado</label>
                                        <p class="mt-1 text-sm text-gray-900 dark:text-white">
                                            {{ $candidate->expected_salary ? '$' . number_format($candidate->expected_salary, 2) : 'No especificado' }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Carta de Presentación -->
                    @if($candidate->cover_letter)
                        <div class="mt-6">
                            <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6">
                                <h4 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Carta de Presentación</h4>
                                <div class="prose dark:prose-invert max-w-none">
                                    {!! nl2br(e($candidate->cover_letter)) !!}
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Notas -->
                    @if($candidate->notes)
                        <div class="mt-6">
                            <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6">
                                <h4 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Notas</h4>
                                <div class="prose dark:prose-invert max-w-none">
                                    {!! nl2br(e($candidate->notes)) !!}
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Historial de Estados -->
                    <div class="mt-6">
                        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6">
                            <h4 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Historial de Estados</h4>
                            <div class="space-y-4">
                                <!-- Aquí iría el historial de estados si lo implementamos -->
                                <p class="text-gray-600 dark:text-gray-300">Estado actual: {{ ucfirst($candidate->status) }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection 