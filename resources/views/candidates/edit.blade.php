@extends('layouts.admin')

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                            {{ __('Editar Candidato') }}
                        </h2>
                        <div class="flex space-x-2">
                            <a href="{{ route('candidates.show', $candidate) }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                <i class="fas fa-arrow-left mr-2"></i>Volver
                            </a>
                        </div>
                    </div>

                    <form action="{{ route('candidates.update', $candidate) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Información Personal -->
                            <div class="space-y-6">
                                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Información Personal</h3>
                                
                                <div>
                                    <label for="first_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nombre</label>
                                    <input type="text" name="first_name" id="first_name" value="{{ old('first_name', $candidate->first_name) }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                    @error('first_name')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="last_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Apellido</label>
                                    <input type="text" name="last_name" id="last_name" value="{{ old('last_name', $candidate->last_name) }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                    @error('last_name')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email</label>
                                    <input type="email" name="email" id="email" value="{{ old('email', $candidate->email) }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                    @error('email')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Teléfono</label>
                                    <input type="tel" name="phone" id="phone" value="{{ old('phone', $candidate->phone) }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                    @error('phone')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Información Profesional -->
                            <div class="space-y-6">
                                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Información Profesional</h3>

                                <div>
                                    <label for="job_posting_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Vacante</label>
                                    <select name="job_posting_id" id="job_posting_id"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                        <option value="">Seleccione una vacante</option>
                                        @foreach($jobPostings as $jobPosting)
                                            <option value="{{ $jobPosting->id }}" {{ old('job_posting_id', $candidate->job_posting_id) == $jobPosting->id ? 'selected' : '' }}>
                                                {{ $jobPosting->title }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('job_posting_id')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Estado</label>
                                    <select name="status" id="status"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                        <option value="pending" {{ old('status', $candidate->status) == 'pending' ? 'selected' : '' }}>Pendiente</option>
                                        <option value="reviewing" {{ old('status', $candidate->status) == 'reviewing' ? 'selected' : '' }}>En Revisión</option>
                                        <option value="shortlisted" {{ old('status', $candidate->status) == 'shortlisted' ? 'selected' : '' }}>Preseleccionado</option>
                                        <option value="interview_scheduled" {{ old('status', $candidate->status) == 'interview_scheduled' ? 'selected' : '' }}>Entrevista Programada</option>
                                        <option value="interviewed" {{ old('status', $candidate->status) == 'interviewed' ? 'selected' : '' }}>Entrevistado</option>
                                        <option value="technical_test" {{ old('status', $candidate->status) == 'technical_test' ? 'selected' : '' }}>Prueba Técnica</option>
                                        <option value="reference_check" {{ old('status', $candidate->status) == 'reference_check' ? 'selected' : '' }}>Verificación de Referencias</option>
                                        <option value="offered" {{ old('status', $candidate->status) == 'offered' ? 'selected' : '' }}>Oferta Extendida</option>
                                        <option value="accepted" {{ old('status', $candidate->status) == 'accepted' ? 'selected' : '' }}>Oferta Aceptada</option>
                                        <option value="hired" {{ old('status', $candidate->status) == 'hired' ? 'selected' : '' }}>Contratado</option>
                                        <option value="rejected" {{ old('status', $candidate->status) == 'rejected' ? 'selected' : '' }}>Rechazado</option>
                                        <option value="withdrawn" {{ old('status', $candidate->status) == 'withdrawn' ? 'selected' : '' }}>Retirado</option>
                                    </select>
                                    @error('status')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div id="rejection_reason_container" class="hidden">
                                    <label for="rejection_reason" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Razón del Rechazo</label>
                                    <textarea name="rejection_reason" id="rejection_reason" rows="3"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">{{ old('rejection_reason', $candidate->rejection_reason) }}</textarea>
                                    @error('rejection_reason')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="current_position" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Cargo Actual</label>
                                    <input type="text" name="current_position" id="current_position" value="{{ old('current_position', $candidate->current_position) }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                    @error('current_position')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="current_company" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Empresa Actual</label>
                                    <input type="text" name="current_company" id="current_company" value="{{ old('current_company', $candidate->current_company) }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                    @error('current_company')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="years_of_experience" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Años de Experiencia</label>
                                    <input type="number" name="years_of_experience" id="years_of_experience" value="{{ old('years_of_experience', $candidate->years_of_experience) }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                    @error('years_of_experience')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="education_level" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nivel de Educación</label>
                                    <select name="education_level" id="education_level"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                        <option value="">Seleccione un nivel</option>
                                        <option value="Secundario" {{ old('education_level', $candidate->education_level) == 'Secundario' ? 'selected' : '' }}>Secundario</option>
                                        <option value="Terciario" {{ old('education_level', $candidate->education_level) == 'Terciario' ? 'selected' : '' }}>Terciario</option>
                                        <option value="Universitario" {{ old('education_level', $candidate->education_level) == 'Universitario' ? 'selected' : '' }}>Universitario</option>
                                        <option value="Posgrado" {{ old('education_level', $candidate->education_level) == 'Posgrado' ? 'selected' : '' }}>Posgrado</option>
                                    </select>
                                    @error('education_level')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="expected_salary" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Salario Esperado</label>
                                    <input type="number" step="0.01" name="expected_salary" id="expected_salary" value="{{ old('expected_salary', $candidate->expected_salary) }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                    @error('expected_salary')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Documentos y Notas -->
                        <div class="space-y-6">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Documentos y Notas</h3>

                            <div>
                                <label for="resume" class="block text-sm font-medium text-gray-700 dark:text-gray-300">CV (PDF, DOC, DOCX)</label>
                                @if($candidate->resume_path)
                                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                        CV actual: {{ basename($candidate->resume_path) }}
                                    </p>
                                @endif
                                <input type="file" name="resume" id="resume"
                                    class="mt-1 block w-full text-sm text-gray-500 dark:text-gray-400
                                        file:mr-4 file:py-2 file:px-4
                                        file:rounded-md file:border-0
                                        file:text-sm file:font-semibold
                                        file:bg-blue-50 file:text-blue-700
                                        hover:file:bg-blue-100
                                        dark:file:bg-blue-900 dark:file:text-blue-300">
                                @error('resume')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="cover_letter" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Carta de Presentación</label>
                                <textarea name="cover_letter" id="cover_letter" rows="4"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">{{ old('cover_letter', $candidate->cover_letter) }}</textarea>
                                @error('cover_letter')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="notes" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Notas</label>
                                <textarea name="notes" id="notes" rows="4"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">{{ old('notes', $candidate->notes) }}</textarea>
                                @error('notes')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="source" class="block text-sm font-medium text-gray-700 dark:text-gray-300">¿Cómo nos encontró?</label>
                                <select name="source" id="source"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                    <option value="">Seleccione una opción</option>
                                    <option value="LinkedIn" {{ old('source', $candidate->source) == 'LinkedIn' ? 'selected' : '' }}>LinkedIn</option>
                                    <option value="Indeed" {{ old('source', $candidate->source) == 'Indeed' ? 'selected' : '' }}>Indeed</option>
                                    <option value="Referido" {{ old('source', $candidate->source) == 'Referido' ? 'selected' : '' }}>Referido</option>
                                    <option value="Sitio Web" {{ old('source', $candidate->source) == 'Sitio Web' ? 'selected' : '' }}>Sitio Web</option>
                                    <option value="Otro" {{ old('source', $candidate->source) == 'Otro' ? 'selected' : '' }}>Otro</option>
                                </select>
                                @error('source')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="flex justify-end">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                <i class="fas fa-save mr-2"></i>Guardar Cambios
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const statusSelect = document.getElementById('status');
        const rejectionReasonContainer = document.getElementById('rejection_reason_container');

        function toggleRejectionReason() {
            if (statusSelect.value === 'rejected') {
                rejectionReasonContainer.classList.remove('hidden');
            } else {
                rejectionReasonContainer.classList.add('hidden');
            }
        }

        statusSelect.addEventListener('change', toggleRejectionReason);
        toggleRejectionReason(); // Ejecutar al cargar la página
    });
    </script>
@endsection 