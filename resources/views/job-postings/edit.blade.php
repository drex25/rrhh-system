@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Editar Vacante</h1>
            <a href="{{ route('job-postings.show', $jobPosting) }}" class="text-gray-600 hover:text-gray-800 dark:text-gray-400 dark:hover:text-gray-300">
                <i class="fas fa-arrow-left"></i> Volver
            </a>
        </div>

        <!-- Formulario -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
            <form action="{{ route('job-postings.update', $jobPosting) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Información Básica -->
                <div class="space-y-4">
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Información Básica</h2>
                    
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Título del Puesto *</label>
                        <input type="text" name="title" id="title" value="{{ old('title', $jobPosting->title) }}" required
                            class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-blue-500 focus:border-blue-500">
                        @error('title')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="department_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Departamento *</label>
                            <select name="department_id" id="department_id" required
                                class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Seleccionar departamento</option>
                                @foreach($departments as $department)
                                    <option value="{{ $department->id }}" {{ old('department_id', $jobPosting->department_id) == $department->id ? 'selected' : '' }}>
                                        {{ $department->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('department_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="position_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Cargo *</label>
                            <select name="position_id" id="position_id" required
                                class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Seleccionar cargo</option>
                                @foreach($positions as $position)
                                    <option value="{{ $position->id }}" {{ old('position_id', $jobPosting->position_id) == $position->id ? 'selected' : '' }}>
                                        {{ $position->title }}
                                    </option>
                                @endforeach
                            </select>
                            @error('position_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label for="employment_type" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tipo de Contrato *</label>
                            <select name="employment_type" id="employment_type" required
                                class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Seleccionar tipo</option>
                                <option value="Permanente" {{ old('employment_type', $jobPosting->employment_type) == 'Permanente' ? 'selected' : '' }}>Permanente</option>
                                <option value="Temporario" {{ old('employment_type', $jobPosting->employment_type) == 'Temporario' ? 'selected' : '' }}>Temporario</option>
                                <option value="Pasante" {{ old('employment_type', $jobPosting->employment_type) == 'Pasante' ? 'selected' : '' }}>Pasante</option>
                            </select>
                            @error('employment_type')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="modality" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Modalidad *</label>
                            <div class="relative">
                                <span class="absolute left-3 top-3 text-gray-400"><i class="fas fa-laptop-house"></i></span>
                                <select name="modality" id="modality" required
                                    class="w-full pl-10 pr-4 py-3 rounded-lg border-2 border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-[#0A0E20] focus:ring-[#0A0E20] transition duration-150">
                                    <option value="">Seleccionar modalidad</option>
                                    <option value="remoto" {{ old('modality', $jobPosting->modality) == 'remoto' ? 'selected' : '' }}>Remoto</option>
                                    <option value="hibrido" {{ old('modality', $jobPosting->modality) == 'hibrido' ? 'selected' : '' }}>Híbrido</option>
                                    <option value="presencial" {{ old('modality', $jobPosting->modality ?? 'presencial') == 'presencial' ? 'selected' : '' }}>Presencial</option>
                                </select>
                            </div>
                            @error('modality')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="work_schedule" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Horario *</label>
                            <select name="work_schedule" id="work_schedule" required
                                class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Seleccionar horario</option>
                                <option value="Full-time" {{ old('work_schedule', $jobPosting->work_schedule) == 'Full-time' ? 'selected' : '' }}>Full-time</option>
                                <option value="Part-time" {{ old('work_schedule', $jobPosting->work_schedule) == 'Part-time' ? 'selected' : '' }}>Part-time</option>
                                <option value="Por turnos" {{ old('work_schedule', $jobPosting->work_schedule) == 'Por turnos' ? 'selected' : '' }}>Por turnos</option>
                            </select>
                            @error('work_schedule')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="location" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Ubicación *</label>
                            <input type="text" name="location" id="location" value="{{ old('location', $jobPosting->location) }}" required
                                class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-blue-500 focus:border-blue-500">
                            @error('location')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="min_salary" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Salario Mínimo</label>
                            <input type="number" name="min_salary" id="min_salary" value="{{ old('min_salary', $jobPosting->min_salary) }}" step="0.01"
                                class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-blue-500 focus:border-blue-500">
                            @error('min_salary')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="max_salary" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Salario Máximo</label>
                            <input type="number" name="max_salary" id="max_salary" value="{{ old('max_salary', $jobPosting->max_salary) }}" step="0.01"
                                class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-blue-500 focus:border-blue-500">
                            @error('max_salary')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Descripción y Requisitos -->
                <div class="space-y-4">
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Descripción y Requisitos</h2>
                    
                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Descripción del Puesto *</label>
                        <textarea name="description" id="description" rows="4" required
                            class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-blue-500 focus:border-blue-500">{{ old('description', $jobPosting->description) }}</textarea>
                        @error('description')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="requirements" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Requisitos *</label>
                        <textarea name="requirements" id="requirements" rows="4" required
                            class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-blue-500 focus:border-blue-500">{{ old('requirements', $jobPosting->requirements) }}</textarea>
                        @error('requirements')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="responsibilities" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Responsabilidades *</label>
                        <textarea name="responsibilities" id="responsibilities" rows="4" required
                            class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-blue-500 focus:border-blue-500">{{ old('responsibilities', $jobPosting->responsibilities) }}</textarea>
                        @error('responsibilities')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="benefits" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Beneficios</label>
                        <textarea name="benefits" id="benefits" rows="4"
                            class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-blue-500 focus:border-blue-500">{{ old('benefits', $jobPosting->benefits) }}</textarea>
                        @error('benefits')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Configuración -->
                <div class="space-y-4">
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Configuración</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Estado *</label>
                            <select name="status" id="status" required
                                class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-blue-500 focus:border-blue-500">
                                <option value="draft" {{ old('status', $jobPosting->status) == 'draft' ? 'selected' : '' }}>Borrador</option>
                                <option value="published" {{ old('status', $jobPosting->status) == 'published' ? 'selected' : '' }}>Publicada</option>
                                <option value="closed" {{ old('status', $jobPosting->status) == 'closed' ? 'selected' : '' }}>Cerrada</option>
                            </select>
                            @error('status')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="application_deadline" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Fecha Límite de Aplicación</label>
                            <input type="date" name="application_deadline" id="application_deadline" 
                                value="{{ old('application_deadline', $jobPosting->application_deadline ? $jobPosting->application_deadline->format('Y-m-d') : '') }}"
                                class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-blue-500 focus:border-blue-500">
                            @error('application_deadline')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="vacancies" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Número de Vacantes *</label>
                            <input type="number" name="vacancies" id="vacancies" value="{{ old('vacancies', $jobPosting->vacancies) }}" min="1" required
                                class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-blue-500 focus:border-blue-500">
                            @error('vacancies')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center space-x-4">
                            <div class="flex items-center">
                                <input type="checkbox" name="is_featured" id="is_featured" value="1" 
                                    {{ old('is_featured', $jobPosting->is_featured) ? 'checked' : '' }}
                                    class="rounded border-gray-300 dark:border-gray-600 text-blue-600 focus:ring-blue-500">
                                <label for="is_featured" class="ml-2 text-sm text-gray-700 dark:text-gray-300">Destacada</label>
                            </div>

                            <div class="flex items-center">
                                <input type="checkbox" name="is_active" id="is_active" value="1" 
                                    {{ old('is_active', $jobPosting->is_active) ? 'checked' : '' }}
                                    class="rounded border-gray-300 dark:border-gray-600 text-blue-600 focus:ring-blue-500">
                                <label for="is_active" class="ml-2 text-sm text-gray-700 dark:text-gray-300">Activa</label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Botones -->
                <div class="flex justify-end space-x-4">
                    <a href="{{ route('job-postings.show', $jobPosting) }}" 
                        class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700">
                        Cancelar
                    </a>
                    <button type="submit" 
                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        Actualizar Vacante
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection 