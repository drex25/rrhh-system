@extends('layouts.admin')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Detalles de la Entrevista</h1>
                <p class="mt-2 text-gray-600 dark:text-gray-400">Información completa de la entrevista programada</p>
            </div>
            <div class="flex space-x-4">
                <a href="{{ route('interviews.index') }}" class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 text-gray-700 dark:text-white rounded-lg transition-colors duration-200 border border-gray-200 dark:border-gray-700">
                    <i class="fas fa-arrow-left mr-2"></i> Volver
                </a>
                @if($interview->status !== 'completed')
                    <a href="{{ route('interviews.edit', $interview) }}" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors duration-200">
                        <i class="fas fa-edit mr-2"></i> Editar
                    </a>
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
                                @elseif($interview->status === 'cancelled') bg-red-100 text-red-600 dark:bg-red-900 dark:text-red-300
                                @endif">
                                <i class="fas 
                                    @if($interview->status === 'scheduled') fa-calendar-check
                                    @elseif($interview->status === 'completed') fa-check-circle
                                    @elseif($interview->status === 'cancelled') fa-times-circle
                                    @endif text-2xl"></i>
                            </div>
                            <div>
                                <h2 class="text-xl font-semibold text-gray-900 dark:text-white">
                                    {{ ucfirst($interview->status) }}
                                </h2>
                                <p class="text-gray-600 dark:text-gray-400">
                                    @if($interview->status === 'scheduled')
                                        Programada para {{ $interview->scheduled_at->format('d/m/Y H:i') }}
                                    @elseif($interview->status === 'completed')
                                        Completada el {{ $interview->completed_at->format('d/m/Y H:i') }}
                                    @elseif($interview->status === 'cancelled')
                                        Cancelada el {{ $interview->cancelled_at->format('d/m/Y H:i') }}
                                    @endif
                                </p>
                            </div>
                        </div>
                        @if($interview->status === 'scheduled')
                            <div class="flex space-x-4">
                                <button type="button" onclick="document.getElementById('completeModal').classList.remove('hidden')"
                                    class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg transition-colors duration-200">
                                    <i class="fas fa-check mr-2"></i> Completar
                                </button>
                                <button type="button" onclick="document.getElementById('cancelModal').classList.remove('hidden')"
                                    class="inline-flex items-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg transition-colors duration-200">
                                    <i class="fas fa-times mr-2"></i> Cancelar
                                </button>
                                <button type="button" onclick="document.getElementById('rescheduleModal').classList.remove('hidden')"
                                    class="inline-flex items-center px-4 py-2 bg-yellow-600 hover:bg-yellow-700 text-white rounded-lg transition-colors duration-200">
                                    <i class="fas fa-calendar-alt mr-2"></i> Reprogramar
                                </button>
                            </div>
                        @endif
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
                                @if($interview->type === 'phone')
                                    <i class="fas fa-phone mr-2"></i> Teléfono
                                @elseif($interview->type === 'video')
                                    <i class="fas fa-video mr-2"></i> Video
                                @else
                                    <i class="fas fa-user mr-2"></i> Presencial
                                @endif
                            </p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-600 dark:text-gray-400">Fecha y Hora</label>
                            <p class="mt-1 text-gray-900 dark:text-white">
                                <i class="fas fa-calendar-alt mr-2"></i>
                                {{ $interview->scheduled_at->format('d/m/Y H:i') }}
                            </p>
                        </div>

                        @if($interview->type === 'in_person' && $interview->location)
                            <div>
                                <label class="block text-sm font-medium text-gray-600 dark:text-gray-400">Ubicación</label>
                                <p class="mt-1 text-gray-900 dark:text-white">
                                    <i class="fas fa-map-marker-alt mr-2"></i>
                                    {{ $interview->location }}
                                </p>
                            </div>
                        @endif

                        @if($interview->type === 'video' && $interview->meeting_link)
                            <div>
                                <label class="block text-sm font-medium text-gray-600 dark:text-gray-400">Enlace de la Reunión</label>
                                <a href="{{ $interview->meeting_link }}" target="_blank" class="mt-1 text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300">
                                    <i class="fas fa-link mr-2"></i>
                                    {{ $interview->meeting_link }}
                                </a>
                            </div>
                        @endif

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

            <!-- Información del Candidato y Vacante -->
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
                                    {{ $interview->candidate->full_name }}
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

                <!-- Entrevistador -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Entrevistador</h3>
                        <div class="flex items-center space-x-4">
                            <div class="flex-shrink-0">
                                <div class="w-12 h-12 rounded-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center">
                                    <i class="fas fa-user-tie text-gray-500 dark:text-gray-400 text-xl"></i>
                                </div>
                            </div>
                            <div>
                                <h4 class="text-lg font-medium text-gray-900 dark:text-white">
                                    {{ $interview->interviewer->name }}
                                </h4>
                                <p class="text-gray-600 dark:text-gray-400">
                                    <i class="fas fa-envelope mr-2"></i>
                                    {{ $interview->interviewer->email }}
                                </p>
                            </div>
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
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-600 dark:text-gray-400">Calificación</label>
                                <div class="mt-2 flex items-center">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="fas fa-star {{ $i <= $interview->rating ? 'text-yellow-400' : 'text-gray-300 dark:text-gray-600' }}"></i>
                                    @endfor
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-600 dark:text-gray-400">Recomendación</label>
                                <p class="mt-1 text-gray-900 dark:text-white">
                                    @if($interview->recommendation === 'hire')
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300">
                                            <i class="fas fa-check-circle mr-2"></i> Contratar
                                        </span>
                                    @elseif($interview->recommendation === 'maybe')
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300">
                                            <i class="fas fa-question-circle mr-2"></i> Considerar
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300">
                                            <i class="fas fa-times-circle mr-2"></i> Rechazar
                                        </span>
                                    @endif
                                </p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-600 dark:text-gray-400">Fecha de Completado</label>
                                <p class="mt-1 text-gray-900 dark:text-white">
                                    <i class="fas fa-calendar-check mr-2"></i>
                                    {{ $interview->completed_at->format('d/m/Y H:i') }}
                                </p>
                            </div>
                        </div>

                        @if($interview->feedback)
                            <div class="mt-6">
                                <label class="block text-sm font-medium text-gray-600 dark:text-gray-400">Feedback</label>
                                <div class="mt-2 p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                    <p class="text-gray-900 dark:text-white">
                                        {{ $interview->feedback }}
                                    </p>
                                </div>
                            </div>
                        @endif
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
                <div class="space-y-4">
                    <div>
                        <label for="rating" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Calificación</label>
                        <select name="rating" id="rating" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            <option value="">Seleccionar calificación</option>
                            @for($i = 1; $i <= 5; $i++)
                                <option value="{{ $i }}">{{ $i }} {{ $i === 1 ? 'estrella' : 'estrellas' }}</option>
                            @endfor
                        </select>
                    </div>

                    <div>
                        <label for="recommendation" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Recomendación</label>
                        <select name="recommendation" id="recommendation" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            <option value="">Seleccionar recomendación</option>
                            <option value="hire">Contratar</option>
                            <option value="maybe">Considerar</option>
                            <option value="reject">Rechazar</option>
                        </select>
                    </div>

                    <div>
                        <label for="feedback" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Feedback</label>
                        <textarea name="feedback" id="feedback" rows="4" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"></textarea>
                    </div>
                </div>

                <div class="mt-6 flex justify-end space-x-3">
                    <button type="button" onclick="document.getElementById('completeModal').classList.add('hidden')"
                        class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500">
                        Cancelar
                    </button>
                    <button type="submit"
                        class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500">
                        Completar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal para Cancelar Entrevista -->
<div id="cancelModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white dark:bg-gray-800">
        <div class="mt-3">
            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Cancelar Entrevista</h3>
            <form action="{{ route('interviews.cancel', $interview) }}" method="POST">
                @csrf
                <div>
                    <label for="cancellation_reason" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Razón de la Cancelación</label>
                    <textarea name="cancellation_reason" id="cancellation_reason" rows="4" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"></textarea>
                </div>

                <div class="mt-6 flex justify-end space-x-3">
                    <button type="button" onclick="document.getElementById('cancelModal').classList.add('hidden')"
                        class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500">
                        Volver
                    </button>
                    <button type="submit"
                        class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500">
                        Cancelar Entrevista
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal para Reprogramar Entrevista -->
<div id="rescheduleModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white dark:bg-gray-800">
        <div class="mt-3">
            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Reprogramar Entrevista</h3>
            <form action="{{ route('interviews.reschedule', $interview) }}" method="POST">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label for="scheduled_at" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nueva Fecha y Hora</label>
                        <input type="datetime-local" name="scheduled_at" id="scheduled_at" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    </div>

                    <div>
                        <label for="reschedule_reason" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Razón de la Reprogramación</label>
                        <textarea name="reschedule_reason" id="reschedule_reason" rows="4" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"></textarea>
                    </div>
                </div>

                <div class="mt-6 flex justify-end space-x-3">
                    <button type="button" onclick="document.getElementById('rescheduleModal').classList.add('hidden')"
                        class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500">
                        Volver
                    </button>
                    <button type="submit"
                        class="px-4 py-2 bg-yellow-600 text-white rounded-md hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-yellow-500">
                        Reprogramar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection 