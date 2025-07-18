@extends('layouts.admin')

@section('content')
<div :class="darkMode ? 'bg-[#181F2A] border-[#232B3E]' : 'bg-white border-gray-200'" class="rounded-2xl shadow-lg p-8 space-y-10 border transition-colors duration-300">
    <h2 class="text-4xl font-extrabold mb-10 text-gray-800 dark:text-white border-b pb-4 tracking-tight">Nuevo Colaborador</h2>
    <form id="employeeForm" action="{{ route('employees.store') }}" method="POST" enctype="multipart/form-data" class="space-y-10">
        @csrf
        @php
            $steps = [
                ['title' => 'Personales', 'desc' => 'Datos personales del colaborador', 'icon' => 'user'],
                ['title' => 'Laborales', 'desc' => 'Información laboral', 'icon' => 'briefcase'],
                ['title' => 'Bancarios', 'desc' => 'Datos bancarios', 'icon' => 'bank'],
                ['title' => 'Familiares', 'desc' => 'Información familiar', 'icon' => 'users'],
                ['title' => 'Datos adicionales', 'desc' => 'Otros datos relevantes', 'icon' => 'plus-circle'],
            ];
        @endphp

        <style>
            .wizard-stepper {
                display: flex;
                align-items: flex-start;
                justify-content: center;
                position: relative;
                margin-bottom: 2.5rem;
                gap: 0;
            }
            .wizard-step {
                display: flex;
                flex-direction: column;
                align-items: center;
                position: relative;
                z-index: 2;
                min-width: 90px;
                flex: 1 1 0;
                cursor: pointer;
                transition: all 0.3s ease;
            }
            .wizard-step:hover {
                transform: translateY(-2px) scale(1.04);
                box-shadow: 0 4px 16px 0 rgba(99,102,241,0.10);
            }
            .wizard-circle {
                background: #fff;
                z-index: 2;
                position: relative;
                width: 48px;
                height: 48px;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 1.7rem;
                font-weight: 700;
                color: #a1a1aa;
                border: 3px solid #e5e7eb;
                transition: all 0.3s cubic-bezier(.4,0,.2,1);
                box-shadow: 0 2px 8px 0 rgba(99,102,241,0.04);
            }
            .dark .wizard-circle {
                background: #1f2937;
                border-color: #374151;
                color: #9ca3af;
            }
            .wizard-step.completed .wizard-circle {
                background: linear-gradient(135deg, #22d3ee 0%, #6366f1 100%);
                color: #fff;
                border-color: #6366f1;
            }
            .wizard-step.active .wizard-circle {
                background: #fff;
                color: #6366f1;
                border-color: #6366f1;
                box-shadow: 0 0 0 6px #6366f133, 0 4px 16px 0 rgba(99,102,241,0.10);
                font-size: 2.1rem;
            }
            .dark .wizard-step.active .wizard-circle {
                background: #1f2937;
            }
            .wizard-step.completed .wizard-circle i {
                color: #fff;
            }
            .wizard-step .wizard-title {
                margin-top: 0.7rem;
                font-size: 1.05rem;
                font-weight: 600;
                color: #6366f1;
                text-align: center;
                letter-spacing: -0.5px;
                transition: all 0.3s ease;
            }
            .dark .wizard-step .wizard-title {
                color: #60a5fa;
            }
            .wizard-step .wizard-desc {
                font-size: 0.92rem;
                color: #64748b;
                opacity: 0.8;
                text-align: center;
                margin-top: 0.1rem;
                transition: all 0.3s ease;
            }
            .dark .wizard-step .wizard-desc {
                color: #9ca3af;
            }
            .wizard-step.completed .wizard-title,
            .wizard-step.completed .wizard-desc {
                color: #22d3ee;
            }
            .wizard-step.active .wizard-title {
                color: #6366f1;
            }
            .dark .wizard-step.active .wizard-title {
                color: #60a5fa;
            }
            .wizard-step:not(:last-child) {
                margin-right: 0;
            }
            .wizard-connector {
                position: absolute;
                top: 24px;
                left: 0;
                width: 100%;
                height: 6px;
                z-index: 1;
                display: flex;
                align-items: center;
                pointer-events: none;
            }
            .wizard-connector-bar {
                height: 6px;
                background: #e5e7eb;
                border-radius: 3px;
                position: absolute;
                left: 120px;
                right: 120px;
                top: 0;
                overflow: hidden;
            }
            .dark .wizard-connector-bar {
                background: #374151;
            }
            .wizard-connector-bar-progress {
                position: absolute;
                left: 0;
                top: 0;
                height: 100%;
                background: linear-gradient(90deg, #6366f1 0%, #22d3ee 100%);
                border-radius: 3px;
                transition: width 0.5s cubic-bezier(.4,0,.2,1);
                z-index: 2;
                right: auto;
                max-width: 100%;
            }
            @media (max-width: 900px) {
                .wizard-stepper { flex-direction: column; gap: 1.5rem; }
                .wizard-connector { display: none; }
                .wizard-step { min-width: 0; }
            }
            .form-input-pro {
                @apply w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 focus:border-transparent transition-all duration-200;
            }
            .form-input-pro:focus {
                @apply shadow-lg transform scale-[1.02];
            }
            .error-message {
                @apply text-red-500 text-sm mt-1 block;
            }
            .btn-pro {
                @apply bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-semibold text-sm rounded-xl px-6 py-2.5 shadow-sm hover:from-indigo-600 hover:to-blue-600 transition-all duration-200 hover:scale-105 hover:shadow-md;
            }
            .btn-pro-secondary {
                @apply bg-white dark:bg-gray-800 text-blue-600 dark:text-blue-400 border-2 border-blue-600 dark:border-blue-400 font-semibold text-sm rounded-xl px-6 py-2.5 transition-all duration-200 hover:bg-blue-50 dark:hover:bg-gray-700 hover:scale-105;
            }
            .step {
                animation: fade-in 0.5s;
            }
            @keyframes fade-in {
                from { opacity: 0; transform: translateY(10px); }
                to { opacity: 1; transform: translateY(0); }
            }
        </style>

        <div class="relative w-full mb-12">
            <div class="wizard-stepper">
                @foreach ($steps as $i => $step)
                    <div id="step-card-{{ $i+1 }}" class="wizard-step" onclick="goToStep({{ $i+1 }})">
                        <div class="wizard-circle">
                            <span class="wizard-icon">
                                <i class="fas fa-{{ $step['icon'] }}"></i>
                            </span>
                        </div>
                        <div class="wizard-title">{{ $step['title'] }}</div>
                        <div class="wizard-desc">{{ $step['desc'] }}</div>
                    </div>
                @endforeach
                <div class="wizard-connector">
                    <div class="wizard-connector-bar">
                        <div id="wizard-connector-bar-progress" class="wizard-connector-bar-progress" style="width:0%"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Paso 1: Datos personales -->
        <div class="step" id="step-1">
            <div class="space-y-8 ">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="space-y-2">
                        <label class="font-semibold text-gray-700">Nro. de Legajo *</label>
                        <input type="text" name="file_number" value="{{ old('file_number') }}" class="form-input-pro w-full" required placeholder="Ej: 12345">
                        @error('file_number')<span class="error-message">{{ $message }}</span>@enderror
                    </div>
                    <div class="space-y-2">
                        <label class="font-semibold text-gray-700">DNI *</label>
                        <input type="text" name="dni" value="{{ old('dni') }}" class="form-input-pro w-full" required placeholder="Ej: 30123456">
                        @error('dni')<span class="error-message">{{ $message }}</span>@enderror
                    </div>
                    <div class="space-y-2">
                        <label class="font-semibold text-gray-700">CUIT *</label>
                        <input type="text" id="cuit" name="cuit" value="{{ old('cuit') }}" class="form-input-pro w-full" required placeholder="Ej: 20-30123456-7">
                        @error('cuit')<span class="error-message">{{ $message }}</span>@enderror
                    </div>
                    <div class="space-y-2">
                        <label class="font-semibold text-gray-700">Nombre *</label>
                        <input type="text" name="first_name" value="{{ old('first_name') }}" class="form-input-pro w-full" required placeholder="Ej: Juan">
                        @error('first_name')<span class="error-message">{{ $message }}</span>@enderror
                    </div>
                    <div class="space-y-2">
                        <label class="font-semibold text-gray-700">Apellido *</label>
                        <input type="text" name="last_name" value="{{ old('last_name') }}" class="form-input-pro w-full" required placeholder="Ej: Pérez">
                        @error('last_name')<span class="error-message">{{ $message }}</span>@enderror
                    </div>
                    <div class="space-y-2">
                        <label class="font-semibold text-gray-700">Fecha de nacimiento *</label>
                        <input type="date" name="birth_date" value="{{ old('birth_date') }}" class="form-input-pro w-full" required placeholder="dd/mm/aaaa">
                        @error('birth_date')<span class="error-message">{{ $message }}</span>@enderror
                    </div>
                    <div class="space-y-2">
                        <label class="font-semibold text-gray-700">País de nacimiento *</label>
                        <select name="birth_country" id="birth_country" class="form-input-pro w-full" required>
                            <option value="">Seleccione un país...</option>
                        </select>
                        @error('birth_country')<span class="error-message">{{ $message }}</span>@enderror
                    </div>
                    <div class="space-y-2" id="argentina_fields" style="display: none;">
                        <label class="font-semibold text-gray-700">Provincia de nacimiento *</label>
                        <select name="birth_province" id="birth_province" class="form-input-pro w-full">
                            <option value="">Seleccione una provincia...</option>
                        </select>
                        @error('birth_province')<span class="error-message">{{ $message }}</span>@enderror
                    </div>
                    <div class="space-y-2" id="city_field" style="display: none;">
                        <label class="font-semibold text-gray-700">Ciudad de nacimiento *</label>
                        <select name="birth_city" id="birth_city" class="form-input-pro w-full">
                            <option value="">Seleccione una ciudad...</option>
                        </select>
                        @error('birth_city')<span class="error-message">{{ $message }}</span>@enderror
                    </div>
                    <div class="space-y-2">
                        <label class="font-semibold text-gray-700">Nacionalidad *</label>
                        <select name="nationality" id="nationality" class="form-input-pro w-full" required>
                            <option value="">Seleccione una nacionalidad...</option>
                        </select>
                        @error('nationality')<span class="error-message">{{ $message }}</span>@enderror
                    </div>
                    <div class="space-y-2">
                        <label class="font-semibold text-gray-700">Sexo *</label>
                        <select name="gender" class="form-input-pro w-full" required>
                            <option value="">Seleccione...</option>
                            <option value="Masculino" @selected(old('gender') == 'Masculino')>Masculino</option>
                            <option value="Femenino" @selected(old('gender') == 'Femenino')>Femenino</option>
                            <option value="Sin género" @selected(old('gender') == 'Sin género')>Sin género</option>
                        </select>
                        @error('gender')<span class="error-message">{{ $message }}</span>@enderror
                    </div>
                    <div class="space-y-2">
                        <label class="font-semibold text-gray-700">Dirección *</label>
                        <input type="text" name="address" value="{{ old('address') }}" class="form-input-pro w-full" required placeholder="Ej: Av. Siempre Viva 742">
                        @error('address')<span class="error-message">{{ $message }}</span>@enderror
                    </div>
                    <div class="space-y-2">
                        <label class="font-semibold text-gray-700">Teléfono *</label>
                        <input type="text" name="phone" value="{{ old('phone') }}" class="form-input-pro w-full" required placeholder="Ej: 11 2345-6789">
                        @error('phone')<span class="error-message">{{ $message }}</span>@enderror
                    </div>
                    <div class="space-y-2">
                        <label class="font-semibold text-gray-700">Email *</label>
                        <input type="email" name="email" value="{{ old('email') }}" class="form-input-pro w-full" required placeholder="Ej: juan@email.com">
                        @error('email')<span class="error-message">{{ $message }}</span>@enderror
                    </div>
                    <div class="space-y-2">
                        <label class="font-semibold text-gray-700">Foto de perfil</label>
                        <div class="profile-photo-drop mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-dashed border-indigo-300 rounded-xl bg-white/60 hover:border-indigo-500 transition-colors duration-200">
                            <div class="space-y-1 text-center">
                                <svg class="mx-auto h-12 w-12 text-indigo-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <div class="flex text-sm text-indigo-600 justify-center">
                                    <label for="profile_photo" class="relative cursor-pointer bg-white rounded-md font-bold text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                        <span>Subir una foto</span>
                                        <input id="profile_photo" name="profile_photo" type="file" class="sr-only" accept="image/*" placeholder="Subir foto">
                                    </label>
                                    <p class="pl-1">o arrastrar y soltar</p>
                                </div>
                                <p class="text-xs text-gray-500">PNG, JPG, GIF hasta 10MB</p>
                            </div>
                        </div>
                        @error('profile_photo')<span class="error-message">{{ $message }}</span>@enderror
                    </div>
                </div>
            </div>
            <div class="flex justify-end mt-8">
                <button type="button" class="btn-pro btn-next">Siguiente</button>
            </div>
        </div>

        <!-- Paso 2: Datos laborales -->
        <div class="step hidden" id="step-2">
            <div class="space-y-8 ">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="space-y-2">
                        <label class="form-label">Departamento *</label>
                        @if($departments->count())
                            <select name="department_id" class="form-input-pro w-full" required>
                                <option value="">Seleccione...</option>
                                @foreach($departments as $department)
                                    <option value="{{ $department->id }}" @selected(old('department_id') == $department->id)>{{ $department->name }}</option>
                                @endforeach
                            </select>
                        @else
                            <div class="flex items-center gap-2 bg-yellow-50 text-yellow-800 p-3 rounded-xl">
                                <i class="fas fa-exclamation-triangle"></i>
                                <span>No hay departamentos. <a href="{{ route('departments.create') }}" class="underline text-blue-600">Crear uno</a></span>
                            </div>
                        @endif
                        @error('department_id')<span class="error-message">{{ $message }}</span>@enderror
                    </div>
                    <div class="space-y-2">
                        <label class="form-label">Posición *</label>
                        @if($positions->count())
                            <select name="position_id" class="form-input-pro w-full" required>
                                <option value="">Seleccione...</option>
                                @foreach($positions as $position)
                                    <option value="{{ $position->id }}" @selected(old('position_id') == $position->id)>{{ $position->title }}</option>
                                @endforeach
                            </select>
                        @else
                            <div class="flex items-center gap-2 bg-yellow-50 text-yellow-800 p-3 rounded-xl">
                                <i class="fas fa-exclamation-triangle"></i>
                                <span>No hay posiciones. <a href="{{ route('positions.create') }}" class="underline text-blue-600">Crear una</a></span>
                            </div>
                        @endif
                        @error('position_id')<span class="error-message">{{ $message }}</span>@enderror
                    </div>
                    <div class="space-y-2">
                        <label class="form-label">Fecha de ingreso *</label>
                        <input type="date" name="hire_date" value="{{ old('hire_date') }}" class="form-input-pro w-full" required placeholder="dd/mm/aaaa">
                        @error('hire_date')<span class="error-message">{{ $message }}</span>@enderror
                    </div>
                    <div class="space-y-2">
                        <label class="form-label">Tipo de contratación *</label>
                        <select name="employment_type" class="form-input-pro w-full" required>
                            <option value="">Seleccione...</option>
                            <option value="Permanente" @selected(old('employment_type') == 'Permanente')>Permanente</option>
                            <option value="Temporaria" @selected(old('employment_type') == 'Temporaria')>Temporaria</option>
                            <option value="Pasante" @selected(old('employment_type') == 'Pasante')>Pasante</option>
                        </select>
                        @error('employment_type')<span class="error-message">{{ $message }}</span>@enderror
                    </div>
                    <div class="space-y-2">
                        <label class="form-label">Horario de trabajo (desde) *</label>
                        <select name="work_schedule_from" class="form-input-pro w-full" required>
                            <option value="">Seleccione una hora</option>
                            @for($i = 8; $i <= 18; $i++)
                                <option value="{{ sprintf('%02d:00', $i) }}" @selected(old('work_schedule_from') == sprintf('%02d:00', $i))>{{ sprintf('%02d:00', $i) }}</option>
                            @endfor
                        </select>
                        @error('work_schedule_from')<span class="error-message">{{ $message }}</span>@enderror
                    </div>
                    <div class="space-y-2">
                        <label class="form-label">Horario de trabajo (hasta) *</label>
                        <select name="work_schedule_to" class="form-input-pro w-full" required>
                            <option value="">Seleccione una hora</option>
                            @for($i = 8; $i <= 18; $i++)
                                <option value="{{ sprintf('%02d:00', $i) }}" @selected(old('work_schedule_to') == sprintf('%02d:00', $i))>{{ sprintf('%02d:00', $i) }}</option>
                            @endfor
                        </select>
                        @error('work_schedule_to')<span class="error-message">{{ $message }}</span>@enderror
                    </div>
                    <div class="space-y-2">
                        <label class="form-label">Obra social</label>
                        <input type="text" name="health_insurance" value="{{ old('health_insurance') }}" class="form-input-pro w-full" placeholder="Ej: OSDE">
                        @error('health_insurance')<span class="error-message">{{ $message }}</span>@enderror
                    </div>
                    <div class="space-y-2">
                        <label class="form-label">Sindicato</label>
                        <input type="text" name="union" value="{{ old('union') }}" class="form-input-pro w-full" placeholder="Ej: UOM">
                        @error('union')<span class="error-message">{{ $message }}</span>@enderror
                    </div>
                    <div class="space-y-2">
                        <label class="form-label">Sueldo básico *</label>
                        <input type="number" step="0.01" name="base_salary" value="{{ old('base_salary') }}" class="form-input-pro w-full" required placeholder="Ej: 150000">
                        @error('base_salary')<span class="error-message">{{ $message }}</span>@enderror
                    </div>
                </div>
            </div>
            <div class="flex justify-between mt-8">
                <button type="button" class="btn-pro-secondary btn-prev">Anterior</button>
                <button type="button" class="btn-pro btn-next">Siguiente</button>
            </div>
        </div>

        <!-- Paso 3: Datos bancarios -->
        <div class="step hidden" id="step-3">
            <div class="space-y-8 ">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="space-y-2">
                        <label class="form-label">Cuenta bancaria</label>
                        <input type="text" name="bank_account" value="{{ old('bank_account') }}" class="form-input-pro w-full" placeholder="Ej: 1234567890">
                        @error('bank_account')<span class="error-message">{{ $message }}</span>@enderror
                    </div>
                    <div class="space-y-2">
                        <label class="form-label">Banco</label>
                        <input type="text" name="bank_name" value="{{ old('bank_name') }}" class="form-input-pro w-full" placeholder="Ej: Banco Nación">
                        @error('bank_name')<span class="error-message">{{ $message }}</span>@enderror
                    </div>
                </div>
                <div class="space-y-2 mt-6">
                    <label class="form-label">Comprobante de CBU (adjuntar archivo)</label>
                    <input type="file" name="cbu_attachment" class="form-input-pro w-full" accept=".pdf,.jpg,.jpeg,.png,.webp,.heic,.heif,.doc,.docx,.jpeg">
                    @error('cbu_attachment')<span class="error-message">{{ $message }}</span>@enderror
                </div>
            </div>
            <div class="flex justify-between mt-8">
                <button type="button" class="btn-pro-secondary btn-prev">Anterior</button>
                <button type="button" class="btn-pro btn-next">Siguiente</button>
            </div>
        </div>

        <!-- Paso 4: Datos familiares -->
        <div class="step hidden" id="step-4">
            <div class="space-y-8 ">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="space-y-2">
                        <label class="form-label">Nombre de la Madre</label>
                        <input type="text" name="mother_name" class="form-input-pro w-full" placeholder="Ej: Ana Gómez">
                    </div>
                    <div class="space-y-2">
                        <label class="form-label">Nombre del Padre</label>
                        <input type="text" name="father_name" class="form-input-pro w-full" placeholder="Ej: Carlos Pérez">
                    </div>
                    <div class="space-y-2">
                        <label class="form-label">Nombre del Cónyuge</label>
                        <input type="text" name="spouse_name" class="form-input-pro w-full" placeholder="Ej: Laura Díaz">
                    </div>
                    <div class="space-y-2">
                        <label class="form-label">Hijos</label>
                        <input type="text" name="children" class="form-input-pro w-full" placeholder="Ej: Juan, María">
                    </div>
                </div>
            </div>
            <div class="flex justify-between mt-8">
                <button type="button" class="btn-pro-secondary btn-prev">Anterior</button>
                <button type="button" class="btn-pro btn-next">Siguiente</button>
            </div>
        </div>

        <!-- Paso 5: Datos adicionales -->
        <div class="step hidden" id="step-5">
            <div class="space-y-8 ">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="space-y-2">
                        <label class="form-label">Contacto de emergencia (nombre)</label>
                        <input type="text" name="emergency_contact_name" value="{{ old('emergency_contact_name') }}" class="form-input-pro w-full" placeholder="Ej: María López">
                        @error('emergency_contact_name')<span class="error-message">{{ $message }}</span>@enderror
                    </div>
                    <div class="space-y-2">
                        <label class="form-label">Contacto de emergencia (teléfono)</label>
                        <input type="text" name="emergency_contact_phone" value="{{ old('emergency_contact_phone') }}" class="form-input-pro w-full" placeholder="Ej: 11 9876-5432">
                        @error('emergency_contact_phone')<span class="error-message">{{ $message }}</span>@enderror
                    </div>
                    <div class="flex items-center gap-4">
                        <label class="inline-flex items-center">
                            <input type="checkbox" name="is_active" value="1" class="form-input-pro w-full rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" {{ old('is_active', true) ? 'checked' : '' }}>
                            <span class="ml-2 text-gray-700">Activo</span>
                        </label>
                    </div>
                </div>
            </div>
            <div class="flex justify-between mt-8">
                <button type="button" class="btn-pro-secondary btn-prev">Anterior</button>
                <button type="submit" class="btn-pro bg-green-600 hover:bg-green-700 focus:ring-green-500">Guardar</button>
            </div>
        </div>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    let currentStep = 1;
    const totalSteps = {{ count($steps) }};
    document.addEventListener('DOMContentLoaded', function() {
        const steps = document.querySelectorAll('.step');
        const stepCards = document.querySelectorAll('.wizard-step');
        const btnNext = document.querySelectorAll('.btn-next');
        const btnPrev = document.querySelectorAll('.btn-prev');
        const progressBar = document.getElementById('wizard-connector-bar-progress');

        function updateStepper() {
            steps.forEach((step, index) => {
                if (index + 1 === currentStep) {
                    step.classList.remove('hidden');
                } else {
                    step.classList.add('hidden');
                }
            });
            stepCards.forEach((card, index) => {
                card.classList.remove('active', 'completed');
                const icon = card.querySelector('.wizard-icon i');
                if (index + 1 < currentStep) {
                    card.classList.add('completed');
                    icon.className = 'fas fa-check';
                } else if (index + 1 === currentStep) {
                    card.classList.add('active');
                    icon.className = 'fas fa-' + @json($steps)[index]['icon'];
                } else {
                    icon.className = 'fas fa-' + @json($steps)[index]['icon'];
                }
            });
            // Progress bar
            if(progressBar) {
                progressBar.style.width = ((currentStep-1)/(totalSteps-1))*100 + '%';
            }
        }
        function validateStep(stepNumber) {
            const currentStepElement = document.getElementById(`step-${stepNumber}`);
            const requiredFields = currentStepElement.querySelectorAll('[required]');
            let isValid = true;
            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    isValid = false;
                    field.classList.add('border-red-500');
                    if (!field.nextElementSibling?.classList.contains('error-message')) {
                        const errorMessage = document.createElement('span');
                        errorMessage.className = 'error-message';
                        errorMessage.textContent = 'Este campo es obligatorio';
                        field.parentNode.appendChild(errorMessage);
                    }
                } else {
                    field.classList.remove('border-red-500');
                    const errorMessage = field.nextElementSibling;
                    if (errorMessage?.classList.contains('error-message')) {
                        errorMessage.remove();
                    }
                }
            });
            return isValid;
        }
        btnNext.forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                if (validateStep(currentStep)) {
                    if (currentStep < steps.length) {
                        currentStep++;
                        updateStepper();
                    }
                }
            });
        });
        btnPrev.forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                if (currentStep > 1) {
                    currentStep--;
                    updateStepper();
                }
            });
        });
        stepCards.forEach((card, idx) => {
            card.addEventListener('click', function() {
                if(idx+1 <= currentStep) {
                    currentStep = idx+1;
                    updateStepper();
                }
            });
        });
        updateStepper();

        const cuitInput = document.getElementById('cuit');
        if (cuitInput) {
            cuitInput.addEventListener('input', function(e) {
                let value = e.target.value.replace(/\D/g, '');
                // Limit to 11 digits
                if (value.length > 11) {
                    value = value.slice(0, 11);
                }
                // Format as XX-XXXXXXXX-X
                if (value.length > 2 && value.length <= 10) {
                    value = value.replace(/^(\d{2})(\d+)/, '$1-$2');
                } else if (value.length > 10) {
                    value = value.replace(/^(\d{2})(\d{8})(\d{1})/, '$1-$2-$3');
                }
                e.target.value = value;
            });
        }

        // Drag & Drop para foto de perfil
        const dropArea = document.querySelector('.profile-photo-drop');
        const fileInput = document.getElementById('profile_photo');
        if (dropArea && fileInput) {
            ['dragenter', 'dragover'].forEach(eventName => {
                dropArea.addEventListener(eventName, (e) => {
                    e.preventDefault();
                    e.stopPropagation();
                    dropArea.classList.add('ring-2', 'ring-indigo-400', 'bg-indigo-50');
                }, false);
            });
            ['dragleave', 'drop'].forEach(eventName => {
                dropArea.addEventListener(eventName, (e) => {
                    e.preventDefault();
                    e.stopPropagation();
                    dropArea.classList.remove('ring-2', 'ring-indigo-400', 'bg-indigo-50');
                }, false);
            });
            dropArea.addEventListener('drop', (e) => {
                if (e.dataTransfer.files && e.dataTransfer.files.length) {
                    fileInput.files = e.dataTransfer.files;
                    // Previsualización
                    const file = e.dataTransfer.files[0];
                    if (file && file.type.startsWith('image/')) {
                        const reader = new FileReader();
                        reader.onload = function(ev) {
                            let preview = dropArea.querySelector('.profile-photo-preview');
                            if (!preview) {
                                preview = document.createElement('img');
                                preview.className = 'profile-photo-preview mx-auto mt-2 rounded-full object-cover';
                                preview.style.maxWidth = '96px';
                                preview.style.maxHeight = '96px';
                                dropArea.appendChild(preview);
                            }
                            preview.src = ev.target.result;
                        };
                        reader.readAsDataURL(file);
                    }
                }
            });
            fileInput.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file && file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = function(ev) {
                        let preview = dropArea.querySelector('.profile-photo-preview');
                        if (!preview) {
                            preview = document.createElement('img');
                            preview.className = 'profile-photo-preview mx-auto mt-2 rounded-full object-cover';
                            preview.style.maxWidth = '96px';
                            preview.style.maxHeight = '96px';
                            dropArea.appendChild(preview);
                        }
                        preview.src = ev.target.result;
                    };
                    reader.readAsDataURL(file);
                }
            });
        }

        // Cargar países
        fetch('/api/countries')
            .then(response => response.json())
            .then(countries => {
                const countrySelect = document.getElementById('birth_country');
                const nationalitySelect = document.getElementById('nationality');
                countries.forEach(country => {
                    const option = new Option(country.name, country.name);
                    countrySelect.add(option);
                    nationalitySelect.add(new Option(country.name, country.name));
                });
                // Restaurar valores antiguos si existen
                @if(old('birth_country'))
                    countrySelect.value = "{{ old('birth_country') }}";
                    checkCountry();
                @endif
                @if(old('nationality'))
                    nationalitySelect.value = "{{ old('nationality') }}";
                @endif
                // Inicializar Tom Select después de cargar opciones
                if (window.TomSelect) {
                    if (!countrySelect.tomselect) new TomSelect(countrySelect, { create: false, sortField: 'text', placeholder: 'Buscar país...' });
                    if (!nationalitySelect.tomselect) new TomSelect(nationalitySelect, { create: false, sortField: 'text', placeholder: 'Buscar nacionalidad...' });
                }
            });

        // Cargar provincias
        fetch('/api/provinces')
            .then(response => response.json())
            .then(provinces => {
                const provinceSelect = document.getElementById('birth_province');
                provinces.forEach(province => {
                    provinceSelect.add(new Option(province.name, province.id));
                });
                // Restaurar valor antiguo si existe
                @if(old('birth_province'))
                    provinceSelect.value = "{{ old('birth_province') }}";
                    loadCities("{{ old('birth_province') }}");
                @endif
                // Inicializar Tom Select después de cargar opciones
                if (window.TomSelect && !provinceSelect.tomselect) new TomSelect(provinceSelect, { create: false, sortField: 'text', placeholder: 'Buscar provincia...' });
            });

        // Manejar cambio de país
        document.getElementById('birth_country').addEventListener('change', checkCountry);

        // Manejar cambio de provincia
        document.getElementById('birth_province').addEventListener('change', function() {
            loadCities(this.value);
        });

        function checkCountry() {
            const country = document.getElementById('birth_country').value;
            const argentinaFields = document.getElementById('argentina_fields');
            const cityField = document.getElementById('city_field');
            if (country === 'Argentina') {
                argentinaFields.style.display = 'block';
                cityField.style.display = 'block';
                document.getElementById('birth_province').required = true;
                document.getElementById('birth_city').required = true;
            } else {
                argentinaFields.style.display = 'none';
                cityField.style.display = 'none';
                document.getElementById('birth_province').required = false;
                document.getElementById('birth_city').required = false;
            }
        }

        function loadCities(province) {
            const citySelect = document.getElementById('birth_city');
            citySelect.innerHTML = '<option value="">Seleccione una ciudad...</option>';

            if (province) {
                fetch(`/api/cities?province=${province}`)
                    .then(response => response.json())
                    .then(cities => {
                        cities.forEach(city => {
                            citySelect.add(new Option(city.name, city.name));
                        });
                        // Restaurar valor antiguo si existe
                        @if(old('birth_city'))
                            citySelect.value = "{{ old('birth_city') }}";
                        @endif
                        // Inicializar Tom Select después de cargar opciones
                        if (window.TomSelect) {
                            if (citySelect.tomselect) citySelect.tomselect.destroy();
                            new TomSelect(citySelect, { create: false, sortField: 'text', placeholder: 'Buscar ciudad...' });
                        }
                    });
            } else {
                // Inicializar Tom Select vacío
                if (window.TomSelect) {
                    if (citySelect.tomselect) citySelect.tomselect.destroy();
                    new TomSelect(citySelect, { create: false, sortField: 'text', placeholder: 'Buscar ciudad...' });
                }
            }
        }
    });
    function goToStep(step) {
        if(step <= currentStep || document.querySelectorAll('.step')[currentStep-1].querySelectorAll('[required]').length === 0 || validateStep(currentStep)) {
            currentStep = step;
            document.dispatchEvent(new Event('DOMContentLoaded'));
        }
    }

    document.getElementById('employeeForm').addEventListener('submit', function(e) {
        if (!validateStep(currentStep)) {
            e.preventDefault();
            // Opcional: scroll al primer error
            const firstError = document.querySelector('.border-red-500');
            if (firstError) firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
            return false;
        }
        const cbuInput = document.querySelector('input[name="cbu_attachment"]');
        if (cbuInput && cbuInput.files.length > 0) {
            console.log('CBU file:', cbuInput.files[0]);
        } else {
            console.warn('NO se seleccionó archivo CBU al enviar el formulario');
        }
    });

    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: '¡Éxito!',
            text: '{{ session('success') }}',
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 2500
        });
    @endif
    @if(session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: '{{ session('error') }}',
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 2500
        });
    @endif
</script>
@endsection 