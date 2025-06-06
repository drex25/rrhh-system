@extends('layouts.admin')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Nueva Entrevista</h1>
                <p class="mt-2 text-gray-600 dark:text-gray-400">Programa una nueva entrevista para un candidato</p>
            </div>
            <a href="{{ route('interviews.index') }}" class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 text-gray-700 dark:text-white rounded-lg transition-colors duration-200 border border-gray-200 dark:border-gray-700">
                <i class="fas fa-arrow-left mr-2"></i> Volver
            </a>
        </div>

        <!-- Formulario -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden">
            <form action="{{ route('interviews.store') }}" method="POST" class="space-y-8 p-8">
                @csrf

                <!-- Información Básica -->
                <div class="space-y-6">
                    <div class="flex items-center space-x-3 pb-4 border-b border-gray-200 dark:border-gray-700">
                        <div class="p-2 bg-blue-500 rounded-lg">
                            <i class="fas fa-info-circle text-white"></i>
                        </div>
                        <h2 class="text-xl font-bold text-gray-900 dark:text-white">Información Básica</h2>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label for="candidate_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Candidato *</label>
                            <select name="candidate_id" id="candidate_id" required
                                class="w-full px-4 py-3 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option value="">Seleccionar candidato</option>
                                @foreach($candidates as $candidate)
                                    <option value="{{ $candidate->id }}" {{ old('candidate_id') == $candidate->id ? 'selected' : '' }}>
                                        {{ $candidate->full_name }} - {{ $candidate->email }}
                                    </option>
                                @endforeach
                            </select>
                            @error('candidate_id')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="space-y-2">
                            <label for="job_posting_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Vacante *</label>
                            <select name="job_posting_id" id="job_posting_id" required
                                class="w-full px-4 py-3 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option value="">Seleccionar vacante</option>
                                @foreach($jobPostings as $jobPosting)
                                    <option value="{{ $jobPosting->id }}" {{ old('job_posting_id') == $jobPosting->id ? 'selected' : '' }}>
                                        {{ $jobPosting->title }}
                                    </option>
                                @endforeach
                            </select>
                            @error('job_posting_id')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label for="interviewer_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Entrevistador *</label>
                            <select name="interviewer_id" id="interviewer_id" required
                                class="w-full px-4 py-3 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option value="">Seleccionar entrevistador</option>
                                @foreach($interviewers as $interviewer)
                                    <option value="{{ $interviewer->id }}" {{ old('interviewer_id') == $interviewer->id ? 'selected' : '' }}>
                                        {{ $interviewer->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('interviewer_id')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="space-y-2">
                            <label for="type" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tipo de Entrevista *</label>
                            <select name="type" id="type" required
                                class="w-full px-4 py-3 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option value="">Seleccionar tipo</option>
                                <option value="phone" {{ old('type') == 'phone' ? 'selected' : '' }}>Teléfono</option>
                                <option value="video" {{ old('type') == 'video' ? 'selected' : '' }}>Video</option>
                                <option value="in_person" {{ old('type') == 'in_person' ? 'selected' : '' }}>Presencial</option>
                            </select>
                            @error('type')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label for="scheduled_at" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Fecha y Hora *</label>
                            <input type="datetime-local" name="scheduled_at" id="scheduled_at" value="{{ old('scheduled_at') }}" required
                                class="w-full px-4 py-3 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            @error('scheduled_at')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="space-y-2" id="location_field" style="display: none;">
                            <label for="location" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Ubicación *</label>
                            <input type="text" name="location" id="location" value="{{ old('location') }}"
                                class="w-full px-4 py-3 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            @error('location')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="space-y-2" id="meeting_link_field" style="display: none;">
                            <label for="meeting_link" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Enlace de la Reunión *</label>
                            <input type="url" name="meeting_link" id="meeting_link" value="{{ old('meeting_link') }}"
                                class="w-full px-4 py-3 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            @error('meeting_link')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label for="notes" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Notas</label>
                        <textarea name="notes" id="notes" rows="4"
                            class="w-full px-4 py-3 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">{{ old('notes') }}</textarea>
                        @error('notes')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Botones de Acción -->
                <div class="flex justify-end space-x-4 pt-6">
                    <button type="submit" class="inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <i class="fas fa-save mr-2"></i> Programar Entrevista
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const typeSelect = document.getElementById('type');
    const locationField = document.getElementById('location_field');
    const meetingLinkField = document.getElementById('meeting_link_field');
    const locationInput = document.getElementById('location');
    const meetingLinkInput = document.getElementById('meeting_link');

    function updateFields() {
        const type = typeSelect.value;
        
        // Ocultar todos los campos primero
        locationField.style.display = 'none';
        meetingLinkField.style.display = 'none';
        locationInput.required = false;
        meetingLinkInput.required = false;

        // Mostrar y configurar los campos según el tipo
        if (type === 'in_person') {
            locationField.style.display = 'block';
            locationInput.required = true;
        } else if (type === 'video') {
            meetingLinkField.style.display = 'block';
            meetingLinkInput.required = true;
        }
    }

    typeSelect.addEventListener('change', updateFields);
    updateFields(); // Ejecutar al cargar la página
});
</script>
@endpush

@endsection 