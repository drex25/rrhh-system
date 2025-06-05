@extends('layouts.admin')

@section('content')
    <div class="py-12">
        <div class="w-full mx-auto">
            <div class="bg-white dark:bg-gray-900 shadow-2xl rounded-3xl overflow-hidden border border-gray-100 dark:border-gray-800">
                <div class="p-10">
                    <div class="flex flex-col md:flex-row md:justify-between md:items-center mb-8 gap-4">
                        <h2 class="font-extrabold text-2xl text-gray-900 dark:text-white tracking-tight flex items-center gap-3">
                            <i class="fas fa-user-plus"></i>
                            Nuevo Candidato
                        </h2>
                        <a href="{{ route('candidates.index') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-gray-500 hover:bg-gray-700 text-white font-bold rounded-xl shadow-lg transition-all text-base focus:outline-none focus:ring-2 focus:ring-gray-400">
                            <i class="fas fa-arrow-left"></i> Volver
                        </a>
                    </div>

                    <form action="{{ route('candidates.store') }}" method="POST" enctype="multipart/form-data" class="space-y-10">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                            <!-- Información Personal -->
                            <div class="space-y-8">
                                <h3 class="text-lg font-bold text-gray-900 dark:text-white flex items-center gap-2 mb-4">
                                    <i class="fas fa-id-card"></i> Información Personal
                                </h3>
                                <div>
                                    <label for="first_name" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Nombre</label>
                                    <input type="text" name="first_name" id="first_name" value="{{ old('first_name') }}"
                                        class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 dark:border-gray-700 dark:bg-gray-800 dark:text-white focus:border-blue-500 focus:ring-blue-500 transition duration-150 text-base shadow-sm">
                                    @error('first_name')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="last_name" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Apellido</label>
                                    <input type="text" name="last_name" id="last_name" value="{{ old('last_name') }}"
                                        class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 dark:border-gray-700 dark:bg-gray-800 dark:text-white focus:border-blue-500 focus:ring-blue-500 transition duration-150 text-base shadow-sm">
                                    @error('last_name')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="email" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Email</label>
                                    <input type="email" name="email" id="email" value="{{ old('email') }}"
                                        class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 dark:border-gray-700 dark:bg-gray-800 dark:text-white focus:border-blue-500 focus:ring-blue-500 transition duration-150 text-base shadow-sm">
                                    @error('email')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="phone" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Teléfono</label>
                                    <input type="tel" name="phone" id="phone" value="{{ old('phone') }}"
                                        class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 dark:border-gray-700 dark:bg-gray-800 dark:text-white focus:border-blue-500 focus:ring-blue-500 transition duration-150 text-base shadow-sm">
                                    @error('phone')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Información Profesional -->
                            <div class="space-y-8">
                                <h3 class="text-lg font-bold text-gray-900 dark:text-white flex items-center gap-2 mb-4">
                                    <i class="fas fa-briefcase"></i> Información Profesional
                                </h3>
                                <div>
                                    <label for="job_posting_id" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Vacante</label>
                                    <select name="job_posting_id" id="job_posting_id"
                                        class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 dark:border-gray-700 dark:bg-gray-800 dark:text-white focus:border-blue-500 focus:ring-blue-500 transition duration-150 text-base shadow-sm">
                                        <option value="">Seleccione una vacante</option>
                                        @foreach($jobPostings as $jobPosting)
                                            <option value="{{ $jobPosting->id }}" {{ old('job_posting_id') == $jobPosting->id ? 'selected' : '' }}>
                                                {{ $jobPosting->title }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('job_posting_id')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="current_position" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Cargo Actual</label>
                                    <input type="text" name="current_position" id="current_position" value="{{ old('current_position') }}"
                                        class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 dark:border-gray-700 dark:bg-gray-800 dark:text-white focus:border-blue-500 focus:ring-blue-500 transition duration-150 text-base shadow-sm">
                                    @error('current_position')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="current_company" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Empresa Actual</label>
                                    <input type="text" name="current_company" id="current_company" value="{{ old('current_company') }}"
                                        class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 dark:border-gray-700 dark:bg-gray-800 dark:text-white focus:border-blue-500 focus:ring-blue-500 transition duration-150 text-base shadow-sm">
                                    @error('current_company')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="years_of_experience" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Años de Experiencia</label>
                                    <input type="number" name="years_of_experience" id="years_of_experience" value="{{ old('years_of_experience') }}"
                                        class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 dark:border-gray-700 dark:bg-gray-800 dark:text-white focus:border-blue-500 focus:ring-blue-500 transition duration-150 text-base shadow-sm">
                                    @error('years_of_experience')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="education_level" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Nivel de Educación</label>
                                    <select name="education_level" id="education_level"
                                        class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 dark:border-gray-700 dark:bg-gray-800 dark:text-white focus:border-blue-500 focus:ring-blue-500 transition duration-150 text-base shadow-sm">
                                        <option value="">Seleccione un nivel</option>
                                        <option value="Secundario" {{ old('education_level') == 'Secundario' ? 'selected' : '' }}>Secundario</option>
                                        <option value="Terciario" {{ old('education_level') == 'Terciario' ? 'selected' : '' }}>Terciario</option>
                                        <option value="Universitario" {{ old('education_level') == 'Universitario' ? 'selected' : '' }}>Universitario</option>
                                        <option value="Posgrado" {{ old('education_level') == 'Posgrado' ? 'selected' : '' }}>Posgrado</option>
                                    </select>
                                    @error('education_level')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="expected_salary" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Salario Esperado</label>
                                    <input type="number" step="0.01" name="expected_salary" id="expected_salary" value="{{ old('expected_salary') }}"
                                        class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 dark:border-gray-700 dark:bg-gray-800 dark:text-white focus:border-blue-500 focus:ring-blue-500 transition duration-150 text-base shadow-sm">
                                    @error('expected_salary')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Documentos y Notas -->
                        <div class="space-y-8">
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white flex items-center gap-2 mb-4">
                                <i class="fas fa-file-alt"></i> Documentos y Notas
                            </h3>
                            <div>
                                <label for="resume" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">CV (PDF, DOC, DOCX)</label>
                                <input type="file" name="resume" id="resume"
                                    class="w-full text-sm text-gray-500 dark:text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 dark:file:bg-blue-900 dark:file:text-blue-300">
                                @error('resume')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="cover_letter" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Carta de Presentación</label>
                                <textarea name="cover_letter" id="cover_letter" rows="4"
                                    class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 dark:border-gray-700 dark:bg-gray-800 dark:text-white focus:border-blue-500 focus:ring-blue-500 transition duration-150 text-base shadow-sm">{{ old('cover_letter') }}</textarea>
                                @error('cover_letter')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="notes" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Notas</label>
                                <textarea name="notes" id="notes" rows="4"
                                    class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 dark:border-gray-700 dark:bg-gray-800 dark:text-white focus:border-blue-500 focus:ring-blue-500 transition duration-150 text-base shadow-sm">{{ old('notes') }}</textarea>
                                @error('notes')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="source" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">¿Cómo nos encontró?</label>
                                <select name="source" id="source"
                                    class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 dark:border-gray-700 dark:bg-gray-800 dark:text-white focus:border-blue-500 focus:ring-blue-500 transition duration-150 text-base shadow-sm">
                                    <option value="">Seleccione una opción</option>
                                    <option value="LinkedIn" {{ old('source') == 'LinkedIn' ? 'selected' : '' }}>LinkedIn</option>
                                    <option value="Indeed" {{ old('source') == 'Indeed' ? 'selected' : '' }}>Indeed</option>
                                    <option value="Referido" {{ old('source') == 'Referido' ? 'selected' : '' }}>Referido</option>
                                    <option value="Sitio Web" {{ old('source') == 'Sitio Web' ? 'selected' : '' }}>Sitio Web</option>
                                    <option value="Otro" {{ old('source') == 'Otro' ? 'selected' : '' }}>Otro</option>
                                </select>
                                @error('source')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="flex justify-end">
                            <button type="submit" class="px-8 py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl shadow-lg flex items-center gap-2 text-lg transition-all focus:outline-none focus:ring-2 focus:ring-blue-400">
                                <i class="fas fa-save"></i> Guardar Candidato
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection 