@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Crear Nueva Vacante</h1>
            <a href="{{ route('job-postings.index') }}" class="text-gray-600 hover:text-gray-800 dark:text-gray-400 dark:hover:text-gray-300">
                <i class="fas fa-arrow-left"></i> Volver
            </a>
        </div>

        <!-- Formulario -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-10 border border-gray-100 dark:border-gray-700">
            <form action="{{ route('job-postings.store') }}" method="POST" class="space-y-10">
                @csrf

                <!-- Información Básica -->
                <div class="space-y-6">
                    <h2 class="text-xl font-bold text-[#0A0E20] dark:text-blue-200 mb-4 flex items-center">
                        <i class="fas fa-info-circle mr-2"></i> Información Básica
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="title" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Título del Puesto *</label>
                            <div class="relative">
                                <span class="absolute left-3 top-3 text-gray-400"><i class="fas fa-heading"></i></span>
                                <input type="text" name="title" id="title" value="{{ old('title') }}" required
                                    class="w-full pl-10 pr-4 py-3 rounded-lg border-2 border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-[#0A0E20] focus:ring-[#0A0E20] transition duration-150">
                            </div>
                            @error('title')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="location" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Ubicación *</label>
                            <div class="relative">
                                <span class="absolute left-3 top-3 text-gray-400"><i class="fas fa-map-marker-alt"></i></span>
                                <input type="text" name="location" id="location" value="{{ old('location') }}" required
                                    class="w-full pl-10 pr-4 py-3 rounded-lg border-2 border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-[#0A0E20] focus:ring-[#0A0E20] transition duration-150">
                            </div>
                            @error('location')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="department_id" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Departamento *</label>
                            <div class="relative">
                                <span class="absolute left-3 top-3 text-gray-400"><i class="fas fa-building"></i></span>
                                <select name="department_id" id="department_id" required
                                    class="w-full pl-10 pr-4 py-3 rounded-lg border-2 border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-[#0A0E20] focus:ring-[#0A0E20] transition duration-150">
                                    <option value="">Seleccionar departamento</option>
                                    @foreach($departments as $department)
                                        <option value="{{ $department->id }}" {{ old('department_id') == $department->id ? 'selected' : '' }}>
                                            {{ $department->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            @error('department_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="position_id" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Cargo *</label>
                            <div class="relative">
                                <span class="absolute left-3 top-3 text-gray-400"><i class="fas fa-user-tie"></i></span>
                                <select name="position_id" id="position_id" required
                                    class="w-full pl-10 pr-4 py-3 rounded-lg border-2 border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-[#0A0E20] focus:ring-[#0A0E20] transition duration-150">
                                    <option value="">Seleccionar cargo</option>
                                    @foreach($positions as $position)
                                        <option value="{{ $position->id }}" {{ old('position_id') == $position->id ? 'selected' : '' }}>
                                            {{ $position->title }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            @error('position_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label for="employment_type" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Tipo de Contrato *</label>
                            <div class="relative">
                                <span class="absolute left-3 top-3 text-gray-400"><i class="fas fa-file-contract"></i></span>
                                <select name="employment_type" id="employment_type" required
                                    class="w-full pl-10 pr-4 py-3 rounded-lg border-2 border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-[#0A0E20] focus:ring-[#0A0E20] transition duration-150">
                                    <option value="">Seleccionar tipo</option>
                                    <option value="Permanente" {{ old('employment_type') == 'Permanente' ? 'selected' : '' }}>Permanente</option>
                                    <option value="Temporario" {{ old('employment_type') == 'Temporario' ? 'selected' : '' }}>Temporario</option>
                                    <option value="Pasante" {{ old('employment_type') == 'Pasante' ? 'selected' : '' }}>Pasante</option>
                                </select>
                            </div>
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
                                    <option value="remoto" {{ old('modality') == 'remoto' ? 'selected' : '' }}>Remoto</option>
                                    <option value="hibrido" {{ old('modality') == 'hibrido' ? 'selected' : '' }}>Híbrido</option>
                                    <option value="presencial" {{ old('modality', 'presencial') == 'presencial' ? 'selected' : '' }}>Presencial</option>
                                </select>
                            </div>
                            @error('modality')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="work_schedule" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Horario *</label>
                            <div class="relative">
                                <span class="absolute left-3 top-3 text-gray-400"><i class="fas fa-clock"></i></span>
                                <select name="work_schedule" id="work_schedule" required
                                    class="w-full pl-10 pr-4 py-3 rounded-lg border-2 border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-[#0A0E20] focus:ring-[#0A0E20] transition duration-150">
                                    <option value="">Seleccionar horario</option>
                                    <option value="Full-time" {{ old('work_schedule') == 'Full-time' ? 'selected' : '' }}>Full-time</option>
                                    <option value="Part-time" {{ old('work_schedule') == 'Part-time' ? 'selected' : '' }}>Part-time</option>
                                    <option value="Por turnos" {{ old('work_schedule') == 'Por turnos' ? 'selected' : '' }}>Por turnos</option>
                                </select>
                            </div>
                            @error('work_schedule')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="vacancies" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Vacantes *</label>
                            <div class="relative">
                                <span class="absolute left-3 top-3 text-gray-400"><i class="fas fa-users"></i></span>
                                <input type="number" name="vacancies" id="vacancies" value="{{ old('vacancies', 1) }}" min="1" required
                                    class="w-full pl-10 pr-4 py-3 rounded-lg border-2 border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-[#0A0E20] focus:ring-[#0A0E20] transition duration-150">
                            </div>
                            @error('vacancies')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="min_salary" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Salario Mínimo</label>
                            <div class="relative">
                                <span class="absolute left-3 top-3 text-gray-400"><i class="fas fa-dollar-sign"></i></span>
                                <input type="number" name="min_salary" id="min_salary" value="{{ old('min_salary') }}" step="0.01"
                                    class="w-full pl-10 pr-4 py-3 rounded-lg border-2 border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-[#0A0E20] focus:ring-[#0A0E20] transition duration-150">
                            </div>
                            @error('min_salary')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="max_salary" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Salario Máximo</label>
                            <div class="relative">
                                <span class="absolute left-3 top-3 text-gray-400"><i class="fas fa-dollar-sign"></i></span>
                                <input type="number" name="max_salary" id="max_salary" value="{{ old('max_salary') }}" step="0.01"
                                    class="w-full pl-10 pr-4 py-3 rounded-lg border-2 border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-[#0A0E20] focus:ring-[#0A0E20] transition duration-150">
                            </div>
                            @error('max_salary')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Descripción y Requisitos -->
                <div class="space-y-6">
                    <h2 class="text-xl font-bold text-[#0A0E20] dark:text-blue-200 mb-4 flex items-center">
                        <i class="fas fa-file-alt mr-2"></i> Descripción y Requisitos
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="description" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Descripción del Puesto *</label>
                            <textarea name="description" id="description" rows="4" required
                                class="w-full rounded-lg border-2 border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-[#0A0E20] focus:ring-[#0A0E20] transition duration-150">{{ old('description') }}</textarea>
                            @error('description')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="requirements" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Requisitos *</label>
                            <textarea name="requirements" id="requirements" rows="4" required
                                class="w-full rounded-lg border-2 border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-[#0A0E20] focus:ring-[#0A0E20] transition duration-150">{{ old('requirements') }}</textarea>
                            @error('requirements')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="responsibilities" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Responsabilidades *</label>
                            <textarea name="responsibilities" id="responsibilities" rows="4" required
                                class="w-full rounded-lg border-2 border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-[#0A0E20] focus:ring-[#0A0E20] transition duration-150">{{ old('responsibilities') }}</textarea>
                            @error('responsibilities')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="benefits" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Beneficios</label>
                            <textarea name="benefits" id="benefits" rows="4"
                                class="w-full rounded-lg border-2 border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-[#0A0E20] focus:ring-[#0A0E20] transition duration-150">{{ old('benefits') }}</textarea>
                            @error('benefits')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Configuración -->
                <div class="space-y-6">
                    <h2 class="text-xl font-bold text-[#0A0E20] dark:text-blue-200 mb-4 flex items-center">
                        <i class="fas fa-cogs mr-2"></i> Configuración
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="status" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Estado *</label>
                            <div class="relative">
                                <span class="absolute left-3 top-3 text-gray-400"><i class="fas fa-flag"></i></span>
                                <select name="status" id="status" required
                                    class="w-full pl-10 pr-4 py-3 rounded-lg border-2 border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-[#0A0E20] focus:ring-[#0A0E20] transition duration-150">
                                    <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Borrador</option>
                                    <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>Publicada</option>
                                    <option value="closed" {{ old('status') == 'closed' ? 'selected' : '' }}>Cerrada</option>
                                </select>
                            </div>
                            @error('status')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="application_deadline" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Fecha Límite de Aplicación</label>
                            <div class="relative">
                                <span class="absolute left-3 top-3 text-gray-400"><i class="fas fa-calendar-alt"></i></span>
                                <input type="date" name="application_deadline" id="application_deadline" value="{{ old('application_deadline') }}"
                                    class="w-full pl-10 pr-4 py-3 rounded-lg border-2 border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-[#0A0E20] focus:ring-[#0A0E20] transition duration-150">
                            </div>
                            @error('application_deadline')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="pt-6 flex justify-end">
                    <button type="submit" class="inline-flex items-center px-8 py-3 bg-[#0A0E20] hover:bg-[#1E3A8A] text-white text-lg font-bold rounded-lg shadow-lg transition duration-150 ease-in-out focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#1E3A8A]">
                        <i class="fas fa-save mr-2"></i> Guardar Vacante
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection 