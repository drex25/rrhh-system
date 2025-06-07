@extends('layouts.admin')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Editar Vacante</h1>
                <p class="mt-2 text-gray-600 dark:text-gray-400">Modifique los detalles de la oferta de trabajo</p>
            </div>
            <a href="{{ route('job-postings.index') }}" class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 text-gray-700 dark:text-white rounded-lg transition-colors duration-200 border border-gray-200 dark:border-gray-700">
                <i class="fas fa-arrow-left mr-2"></i> Volver
            </a>
        </div>

        <!-- Formulario -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden border border-gray-200 dark:border-gray-700">
            <form action="{{ route('job-postings.update', $jobPosting) }}" method="POST" class="space-y-8 p-8" id="jobPostingForm">
                @csrf
                @method('PUT')

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
                            <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Título del Puesto *</label>
                            <div class="relative">
                                <span class="absolute left-3 top-3 text-gray-400"><i class="fas fa-heading"></i></span>
                                <input type="text" name="title" id="title" value="{{ old('title', $jobPosting->title) }}" required
                                    class="w-full pl-10 pr-4 py-3 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            </div>
                            @error('title')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="space-y-2">
                            <label for="location" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Ubicación *</label>
                            <div class="relative">
                                <span class="absolute left-3 top-3 text-gray-400"><i class="fas fa-map-marker-alt"></i></span>
                                <input type="text" name="location" id="location" value="{{ old('location', $jobPosting->location) }}" required
                                    class="w-full pl-10 pr-4 py-3 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            </div>
                            @error('location')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label for="department_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Departamento *</label>
                            <div class="relative">
                                <span class="absolute left-3 top-3 text-gray-400"><i class="fas fa-building"></i></span>
                                <select name="department_id" id="department_id" required
                                    class="w-full pl-10 pr-4 py-3 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                    <option value="">Seleccionar departamento</option>
                                    @foreach($departments as $department)
                                        <option value="{{ $department->id }}" {{ old('department_id', $jobPosting->department_id) == $department->id ? 'selected' : '' }}>
                                            {{ $department->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            @error('department_id')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="space-y-2">
                            <label for="position_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Cargo *</label>
                            <div class="relative">
                                <span class="absolute left-3 top-3 text-gray-400"><i class="fas fa-user-tie"></i></span>
                                <select name="position_id" id="position_id" required
                                    class="w-full pl-10 pr-4 py-3 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                    <option value="">Seleccionar cargo</option>
                                    @foreach($positions as $position)
                                        <option value="{{ $position->id }}" {{ old('position_id', $jobPosting->position_id) == $position->id ? 'selected' : '' }}>
                                            {{ $position->title }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            @error('position_id')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="space-y-2">
                            <label for="employment_type" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tipo de Contrato *</label>
                            <div class="relative">
                                <span class="absolute left-3 top-3 text-gray-400"><i class="fas fa-file-contract"></i></span>
                                <select name="employment_type" id="employment_type" required
                                    class="w-full pl-10 pr-4 py-3 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                    <option value="">Seleccionar tipo</option>
                                    <option value="Permanente" {{ old('employment_type', $jobPosting->employment_type) == 'Permanente' ? 'selected' : '' }}>Permanente</option>
                                    <option value="Temporario" {{ old('employment_type', $jobPosting->employment_type) == 'Temporario' ? 'selected' : '' }}>Temporario</option>
                                    <option value="Pasante" {{ old('employment_type', $jobPosting->employment_type) == 'Pasante' ? 'selected' : '' }}>Pasante</option>
                                </select>
                            </div>
                            @error('employment_type')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="space-y-2">
                            <label for="modality" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Modalidad *</label>
                            <div class="relative">
                                <span class="absolute left-3 top-3 text-gray-400"><i class="fas fa-laptop-house"></i></span>
                                <select name="modality" id="modality" required
                                    class="w-full pl-10 pr-4 py-3 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                    <option value="">Seleccionar modalidad</option>
                                    <option value="remoto" {{ old('modality', $jobPosting->modality) == 'remoto' ? 'selected' : '' }}>Remoto</option>
                                    <option value="hibrido" {{ old('modality', $jobPosting->modality) == 'hibrido' ? 'selected' : '' }}>Híbrido</option>
                                    <option value="presencial" {{ old('modality', $jobPosting->modality) == 'presencial' ? 'selected' : '' }}>Presencial</option>
                                </select>
                            </div>
                            @error('modality')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="space-y-2">
                            <label for="work_schedule" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Horario *</label>
                            <div class="relative">
                                <span class="absolute left-3 top-3 text-gray-400"><i class="fas fa-clock"></i></span>
                                <select name="work_schedule" id="work_schedule" required
                                    class="w-full pl-10 pr-4 py-3 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                    <option value="">Seleccionar horario</option>
                                    <option value="Full-time" {{ old('work_schedule', $jobPosting->work_schedule) == 'Full-time' ? 'selected' : '' }}>Full-time</option>
                                    <option value="Part-time" {{ old('work_schedule', $jobPosting->work_schedule) == 'Part-time' ? 'selected' : '' }}>Part-time</option>
                                    <option value="Por turnos" {{ old('work_schedule', $jobPosting->work_schedule) == 'Por turnos' ? 'selected' : '' }}>Por turnos</option>
                                </select>
                            </div>
                            @error('work_schedule')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Descripción y Requisitos -->
                <div class="space-y-6">
                    <div class="flex items-center space-x-3 pb-4 border-b border-gray-200 dark:border-gray-700">
                        <div class="p-2 bg-purple-500 rounded-lg">
                            <i class="fas fa-file-alt text-white"></i>
                        </div>
                        <h2 class="text-xl font-bold text-gray-900 dark:text-white">Descripción y Requisitos</h2>
                    </div>

                    <div class="space-y-6">
                        <div class="space-y-2">
                            <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Descripción del Puesto *</label>
                            <textarea name="description" id="description" class="tinymce-editor w-full">{!! old('description', $jobPosting->description) !!}</textarea>
                            @error('description')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="space-y-2">
                            <label for="requirements" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Requisitos *</label>
                            <textarea name="requirements" id="requirements" class="tinymce-editor w-full">{!! old('requirements', $jobPosting->requirements) !!}</textarea>
                            @error('requirements')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="space-y-2">
                            <label for="responsibilities" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Responsabilidades *</label>
                            <textarea name="responsibilities" id="responsibilities" class="tinymce-editor w-full">{!! old('responsibilities', $jobPosting->responsibilities) !!}</textarea>
                            @error('responsibilities')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="space-y-2">
                            <label for="benefits" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Beneficios</label>
                            <textarea name="benefits" id="benefits" class="tinymce-editor w-full">{!! old('benefits', $jobPosting->benefits) !!}</textarea>
                            @error('benefits')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Configuración -->
                <div class="space-y-6">
                    <div class="flex items-center space-x-3 pb-4 border-b border-gray-200 dark:border-gray-700">
                        <div class="p-2 bg-green-500 rounded-lg">
                            <i class="fas fa-cogs text-white"></i>
                        </div>
                        <h2 class="text-xl font-bold text-gray-900 dark:text-white">Configuración</h2>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Estado *</label>
                            <select name="status" id="status" required
                                class="w-full px-4 py-3 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option value="draft" {{ old('status', $jobPosting->status) == 'draft' ? 'selected' : '' }}>Borrador</option>
                                <option value="published" {{ old('status', $jobPosting->status) == 'published' ? 'selected' : '' }}>Publicada</option>
                                <option value="closed" {{ old('status', $jobPosting->status) == 'closed' ? 'selected' : '' }}>Cerrada</option>
                            </select>
                            @error('status')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="space-y-2">
                            <label for="closing_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Fecha límite de postulación</label>
                            <input type="date" name="closing_date" id="closing_date" value="{{ old('closing_date', $jobPosting->closing_date ? $jobPosting->closing_date->format('Y-m-d') : '') }}"
                                class="w-full px-4 py-3 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            @error('closing_date')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label for="vacancies" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Número de Vacantes *</label>
                            <input type="number" name="vacancies" id="vacancies" value="{{ old('vacancies', $jobPosting->vacancies) }}" min="1" required
                                class="w-full px-4 py-3 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            @error('vacancies')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="space-y-2">
                            <label for="salary_min" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Salario Mínimo</label>
                            <input type="number" name="salary_min" id="salary_min" value="{{ old('salary_min', $jobPosting->min_salary) }}" step="0.01"
                                class="w-full px-4 py-3 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            @error('salary_min')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="space-y-2">
                            <label for="salary_max" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Salario Máximo</label>
                            <input type="number" name="salary_max" id="salary_max" value="{{ old('salary_max', $jobPosting->max_salary) }}" step="0.01"
                                class="w-full px-4 py-3 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            @error('salary_max')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="flex items-center space-x-3">
                            <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $jobPosting->is_active) ? 'checked' : '' }}
                                class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700">
                            <label for="is_active" class="text-sm font-medium text-gray-700 dark:text-gray-300">Activa</label>
                        </div>

                        <div class="flex items-center space-x-3">
                            <input type="checkbox" name="is_featured" id="is_featured" value="1" {{ old('is_featured', $jobPosting->is_featured) ? 'checked' : '' }}
                                class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700">
                            <label for="is_featured" class="text-sm font-medium text-gray-700 dark:text-gray-300">Destacada</label>
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label for="interviewers" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Entrevistadores</label>
                        <select name="interviewers[]" id="interviewers" multiple
                            class="w-full px-4 py-3 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ (collect(old('interviewers', $jobPosting->interviewers->pluck('id')))->contains($user->id)) ? 'selected' : '' }}>
                                    {{ $user->name }} - {{ $user->email }}
                                </option>
                            @endforeach
                        </select>
                        @error('interviewers')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Botones de Acción -->
                <div class="flex justify-end space-x-4 pt-6">
                    <button type="submit" class="inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <i class="fas fa-save mr-2"></i> Guardar Cambios
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Configuración de Quill
    const quillConfig = {
        theme: 'snow',
        modules: {
            toolbar: [
                [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
                ['bold', 'italic', 'underline', 'strike'],
                [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                [{ 'color': [] }, { 'background': [] }],
                ['link'],
                ['clean']
            ]
        }
    };

    // Inicializar editores
    const editors = {
        description: new Quill('#description-editor', quillConfig),
        requirements: new Quill('#requirements-editor', quillConfig),
        responsibilities: new Quill('#responsibilities-editor', quillConfig),
        benefits: new Quill('#benefits-editor', quillConfig)
    };

    // Manejar el envío del formulario
    document.getElementById('jobPostingForm').addEventListener('submit', function(e) {
        // Actualizar los campos ocultos con el contenido HTML de Quill
        document.getElementById('description').value = editors.description.root.innerHTML;
        document.getElementById('requirements').value = editors.requirements.root.innerHTML;
        document.getElementById('responsibilities').value = editors.responsibilities.root.innerHTML;
        document.getElementById('benefits').value = editors.benefits.root.innerHTML;
    });
});
</script>

<style>
/* Estilos personalizados para Quill */
.ql-editor {
    min-height: 200px;
    font-size: 1rem;
    line-height: 1.5;
    color: #374151;
}

.dark .ql-editor {
    color: #e5e7eb;
}

.ql-toolbar {
    border-top-left-radius: 0.5rem;
    border-top-right-radius: 0.5rem;
    background-color: #f8fafc;
    border-color: #e2e8f0;
}

.dark .ql-toolbar {
    background-color: #374151;
    border-color: #4b5563;
}

.ql-container {
    border-bottom-left-radius: 0.5rem;
    border-bottom-right-radius: 0.5rem;
    border-color: #e2e8f0;
    background-color: #ffffff;
}

.dark .ql-container {
    border-color: #4b5563;
    background-color: #374151;
}

.ql-stroke {
    stroke: #374151;
}

.dark .ql-stroke {
    stroke: #e5e7eb;
}

.ql-fill {
    fill: #374151;
}

.dark .ql-fill {
    fill: #e5e7eb;
}

.ql-picker {
    color: #374151;
}

.dark .ql-picker {
    color: #e5e7eb;
}

.ql-picker-options {
    background-color: #ffffff;
    border-color: #e2e8f0;
}

.dark .ql-picker-options {
    background-color: #374151;
    border-color: #4b5563;
}

.ql-picker-item {
    color: #374151;
}

.dark .ql-picker-item {
    color: #e5e7eb;
}

.ql-picker-item.ql-selected {
    color: #3b82f6;
}

.ql-picker-item:hover {
    color: #3b82f6;
}

.ql-active {
    color: #3b82f6;
}

.ql-toolbar button:hover .ql-stroke,
.ql-toolbar button.ql-active .ql-stroke {
    stroke: #3b82f6;
}

.ql-toolbar button:hover .ql-fill,
.ql-toolbar button.ql-active .ql-fill {
    fill: #3b82f6;
}
</style>
@endsection 