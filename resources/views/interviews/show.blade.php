@extends('layouts.admin')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-8">
    <div class="w-full mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Detalles de la Entrevista</h1>
                <p class="mt-2 text-gray-600 dark:text-gray-400">Información completa de la entrevista programada</p>
            </div>
            <div class="flex space-x-4">
                <a href="{{ route('candidates.show', $interview->candidate) }}" class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 text-gray-700 dark:text-white rounded-lg transition-colors duration-200 border border-gray-200 dark:border-gray-700">
                    <i class="fas fa-arrow-left mr-2"></i> Volver al Candidato
                </a>
                @if($interview->status === 'scheduled')
                    <button type="button" onclick="document.getElementById('completeModal').classList.remove('hidden')"
                        class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg transition-colors duration-200">
                        <i class="fas fa-check mr-2"></i> Completar Entrevista
                    </button>
                @endif
            </div>
        </div>

        <!-- Estado de la Entrevista -->
        <div class="mb-8">
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden">
                <div class="p-6">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-4">
                            <div class="p-3 rounded-full 
                                @if($interview->status === 'scheduled') bg-blue-100 text-blue-600 dark:bg-blue-900 dark:text-blue-300
                                @elseif($interview->status === 'completed') bg-green-100 text-green-600 dark:bg-green-900 dark:text-green-300
                                @endif">
                                <i class="fas 
                                    @if($interview->status === 'scheduled') fa-calendar-check
                                    @elseif($interview->status === 'completed') fa-check-circle
                                    @endif text-2xl"></i>
                            </div>
                            <div>
                                <h2 class="text-xl font-semibold text-gray-900 dark:text-white">
                                    {{ $interview->status === 'scheduled' ? 'Entrevista Programada' : 'Entrevista Completada' }}
                                </h2>
                                <p class="text-gray-600 dark:text-gray-400">
                                    @if($interview->status === 'scheduled')
                                        Programada para {{ $interview->scheduled_at->format('d/m/Y H:i') }}
                                    @else
                                        Completada el {{ $interview->completed_at->format('d/m/Y H:i') }}
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Información Principal -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Detalles de la Entrevista -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Detalles de la Entrevista</h3>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-600 dark:text-gray-400">Tipo de Entrevista</label>
                            <p class="mt-1 text-gray-900 dark:text-white">
                                <i class="fas fa-video mr-2"></i> Video (Google Meet)
                            </p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-600 dark:text-gray-400">Fecha y Hora</label>
                            <p class="mt-1 text-gray-900 dark:text-white">
                                <i class="fas fa-calendar-alt mr-2"></i>
                                {{ $interview->scheduled_at->format('d/m/Y H:i') }}
                            </p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-600 dark:text-gray-400">Enlace de la Reunión</label>
                            <a href="{{ $interview->meet_link }}" target="_blank" class="mt-1 text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300">
                                <i class="fas fa-link mr-2"></i>
                                {{ $interview->meet_link }}
                            </a>
                        </div>

                        @if($interview->notes)
                            <div>
                                <label class="block text-sm font-medium text-gray-600 dark:text-gray-400">Notas</label>
                                <p class="mt-1 text-gray-900 dark:text-white">
                                    {{ $interview->notes }}
                                </p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Información del Candidato -->
            <div class="space-y-8">
                <!-- Candidato -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Candidato</h3>
                        <div class="flex items-center space-x-4">
                            <div class="flex-shrink-0">
                                <div class="w-12 h-12 rounded-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center">
                                    <i class="fas fa-user text-gray-500 dark:text-gray-400 text-xl"></i>
                                </div>
                            </div>
                            <div>
                                <h4 class="text-lg font-medium text-gray-900 dark:text-white">
                                    {{ $interview->candidate->name }}
                                </h4>
                                <p class="text-gray-600 dark:text-gray-400">
                                    <i class="fas fa-envelope mr-2"></i>
                                    {{ $interview->candidate->email }}
                                </p>
                                <p class="text-gray-600 dark:text-gray-400">
                                    <i class="fas fa-phone mr-2"></i>
                                    {{ $interview->candidate->phone }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Vacante -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Vacante</h3>
                        <div>
                            <h4 class="text-lg font-medium text-gray-900 dark:text-white">
                                {{ $interview->jobPosting->title }}
                            </h4>
                            <p class="text-gray-600 dark:text-gray-400">
                                <i class="fas fa-building mr-2"></i>
                                {{ $interview->jobPosting->department->name }}
                            </p>
                            <p class="text-gray-600 dark:text-gray-400">
                                <i class="fas fa-map-marker-alt mr-2"></i>
                                {{ $interview->jobPosting->location }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Resultados de la Entrevista (si está completada) -->
        @if($interview->status === 'completed')
            <div class="mt-8">
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Resultados de la Entrevista</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-600 dark:text-gray-400">Calificación</label>
                                <div class="mt-2 flex items-center">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="fas fa-star {{ $i <= $interview->rating ? 'text-yellow-400' : 'text-gray-300 dark:text-gray-600' }}"></i>
                                    @endfor
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-600 dark:text-gray-400">Feedback</label>
                                <p class="mt-1 text-gray-900 dark:text-white">
                                    {{ $interview->feedback }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>

<!-- Modal para Completar Entrevista -->
<div id="completeModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white dark:bg-gray-800">
        <div class="mt-3">
            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Completar Entrevista</h3>
            <form action="{{ route('interviews.complete', $interview) }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="rating" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Calificación</label>
                    <select name="rating" id="rating" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        <option value="">Seleccionar calificación</option>
                        @for($i = 1; $i <= 5; $i++)
                            <option value="{{ $i }}">{{ $i }} {{ $i === 1 ? 'estrella' : 'estrellas' }}</option>
                        @endfor
                    </select>
                </div>
                <div class="mb-4">
                    <label for="feedback" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Feedback</label>
                    <textarea name="feedback" id="feedback" rows="4" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"></textarea>
                </div>
                <div class="flex justify-end space-x-4">
                    <button type="button" onclick="document.getElementById('completeModal').classList.add('hidden')"
                        class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300 dark:bg-gray-700 dark:text-white dark:hover:bg-gray-600">
                        Cancelar
                    </button>
                    <button type="submit"
                        class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">
                        Completar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection 