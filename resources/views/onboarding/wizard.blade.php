@extends('layouts.public')

@section('title', 'Configuración Inicial - Configura tu Empresa')

@section('content')
<div class="min-h-screen relative overflow-hidden bg-gradient-to-br from-slate-50 via-white to-slate-100 dark:from-slate-950 dark:via-slate-900 dark:to-slate-950">
    <!-- Decorative background -->
    <div aria-hidden="true" class="pointer-events-none select-none">
        <div class="absolute -top-40 -left-32 w-[32rem] h-[32rem] bg-blue-400/15 dark:bg-blue-500/15 rounded-full blur-3xl"></div>
        <div class="absolute top-1/3 -right-40 w-[30rem] h-[30rem] bg-purple-400/15 dark:bg-purple-600/15 rounded-full blur-3xl"></div>
    </div>

    <div class="relative z-10 max-w-7xl mx-auto px-5 lg:px-12 py-14 lg:py-20" x-data="onboardingWizard" x-cloak>
        <div class="flex flex-col lg:flex-row gap-10">
            <!-- Sidebar / Progress -->
            <aside class="w-full lg:w-80 xl:w-96 space-y-8 select-none">
                <div class="glass rounded-2xl border border-white/40 dark:border-white/10 p-7 shadow-xl sticky top-6">
                    <div class="flex items-center gap-3 mb-6">
                        <span class="relative inline-flex h-12 w-12 items-center justify-center rounded-xl bg-gradient-to-br from-blue-600 to-purple-600 text-white shadow-lg">
                            <i class="fa-solid fa-rocket"></i>
                        </span>
                        <div>
                            <h1 class="text-lg font-semibold tracking-tight text-slate-800 dark:text-white">Configuración Inicial</h1>
                            <p class="text-xs text-slate-500 dark:text-slate-400">Completa los pasos para optimizar tu cuenta</p>
                        </div>
                    </div>

                    <template x-for="(step, i) in steps" :key="i">
                        <div class="group relative flex items-start gap-4 pb-6 last:pb-0 cursor-pointer" :class="i < steps.length -1 ? 'after:absolute after:left-4 after:top-8 after:h-full after:w-px after:bg-gradient-to-b after:from-blue-500/40 after:to-purple-500/30' : ''" @click="jumpTo(i)" @keyup.enter.prevent="jumpTo(i)" tabindex="0" :aria-current="currentStep===i">
                            <div class="relative z-10 flex h-8 w-8 items-center justify-center rounded-full border-2 text-xs font-semibold transition-all duration-300"
                                 :class="currentStep === i ? 'bg-blue-600 border-blue-600 text-white ring-4 ring-blue-500/30' : currentStep > i ? 'bg-emerald-500 border-emerald-500 text-white' : 'border-slate-300 dark:border-slate-600 text-slate-500 dark:text-slate-400 group-hover:border-blue-400 group-hover:text-slate-700 dark:group-hover:text-slate-200'">
                                <i x-show="currentStep > i" class="fa-solid fa-check text-[10px]"></i>
                                <span x-show="currentStep <= i" x-text="i+1"></span>
                            </div>
                            <div class="flex-1">
                                <div class="flex items-center justify-between">
                                    <h3 class="text-sm font-semibold tracking-wide uppercase" :class="currentStep >= i ? 'text-blue-600 dark:text-blue-400' : 'text-slate-500 dark:text-slate-400'" x-text="step.title"></h3>
                                    <span x-show="currentStep > i" class="text-[10px] px-2 py-0.5 rounded-full bg-emerald-100 dark:bg-emerald-500/20 text-emerald-600 dark:text-emerald-300 font-medium">Listo</span>
                                </div>
                                <p class="mt-1 text-[11px] leading-snug text-slate-500 dark:text-slate-400" x-text="step.desc"></p>
                            </div>
                        </div>
                    </template>

                    <!-- Live Summary -->
                    <div class="mt-8 pt-6 border-t border-slate-200 dark:border-slate-700">
                        <h4 class="text-xs font-semibold tracking-wider text-slate-600 dark:text-slate-400 mb-3 uppercase">Resumen en Vivo</h4>
                        <ul class="space-y-2 text-[13px] text-slate-600 dark:text-slate-300">
                            <li class="flex items-center gap-2"><i class="fa-regular fa-building text-blue-500"></i><span x-text="form.company_name || 'Sin nombre aún' "></span></li>
                            <li class="flex items-center gap-2"><i class="fa-solid fa-layer-group text-purple-500"></i><span x-text="form.departments.length + ' departamento(s)' "></span></li>
                            <li class="flex items-center gap-2"><i class="fa-solid fa-user-plus text-emerald-500"></i><span x-text="form.employee_name ? 'Empleado inicial: '+form.employee_name : 'Sin empleado inicial'"></span></li>
                            <li class="flex items-center gap-2"><i class="fa-solid fa-globe text-cyan-500"></i><span x-text="form.timezone || 'TZ no seleccionada'"></span></li>
                            <li class="flex items-center gap-2"><i class="fa-solid fa-coins text-amber-500"></i><span x-text="form.currency || 'Moneda ?'"></span></li>
                        </ul>
                        <p class="mt-4 text-[10px] text-slate-400">Los datos se guardan automáticamente en tu navegador.</p>
                    </div>
                </div>
            </aside>

            <!-- Main Wizard -->
            <div class="flex-1 space-y-8">
                <div class="glass rounded-2xl border border-white/40 dark:border-white/10 shadow-xl overflow-hidden">
                    <!-- Top bar with progress -->
                    <div class="px-8 pt-6 pb-4 bg-gradient-to-r from-blue-50/60 to-purple-50/60 dark:from-slate-800/60 dark:to-slate-800/30 backdrop-blur">
                        <div class="flex items-center justify-between gap-4 flex-wrap">
                            <div>
                                <h2 class="text-xl font-bold text-slate-800 dark:text-white" x-text="steps[currentStep].headline"></h2>
                                <p class="text-sm text-slate-600 dark:text-slate-400 mt-1" x-text="steps[currentStep].sub"></p>
                            </div>
                            <div class="w-full sm:w-64">
                                <div class="h-2 rounded-full bg-slate-200 dark:bg-slate-700 overflow-hidden">
                                    <div class="h-full bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 transition-all duration-500" :style="`width: ${Math.round(((currentStep+1)/steps.length)*100)}%`"></div>
                                </div>
                                <p class="mt-1 text-[11px] text-slate-500 dark:text-slate-400 text-right" x-text="Math.round(((currentStep+1)/steps.length)*100)+'% completado'"></p>
                            </div>
                        </div>
                    </div>

                    <!-- Form -->
                    <form @submit.prevent="submitForm" class="p-8 space-y-10">
                        <!-- Step Panels -->
                        <template x-for="(step, index) in steps" :key="index">
                            <section x-show="currentStep === index" x-transition.opacity.duration.300 x-transition.scale.origin.top.left class="space-y-8">
                                <!-- Step 0: Empresa -->
                                <div x-show="index === 0" class="space-y-6">
                                    @if($company)
                                        <div class="flex items-start gap-4 p-4 rounded-xl bg-blue-500/5 dark:bg-blue-500/10 border border-blue-400/30">
                                            <span class="h-10 w-10 rounded-lg flex items-center justify-center bg-blue-600 text-white shadow"><i class="fa-solid fa-building"></i></span>
                                            <div class="text-sm">
                                                <p class="font-semibold text-slate-800 dark:text-slate-100">Datos iniciales importados</p>
                                                <p class="text-slate-500 dark:text-slate-400 mt-0.5">Puedes ajustarlos antes de continuar.</p>
                                            </div>
                                        </div>
                                    @endif
                                    <div class="grid md:grid-cols-2 gap-6">
                                        <div class="md:col-span-2">
                                            <label class="flex items-center gap-2 text-xs font-semibold uppercase tracking-wide text-slate-600 dark:text-slate-400 mb-2">
                                                <i class="fa-solid fa-building text-blue-500"></i>Nombre de la Empresa *
                                            </label>
                                            <input x-model="form.company_name" type="text" required placeholder="Ej: Mi Empresa S.A." class="w-full rounded-xl border border-slate-300/70 dark:border-slate-600/60 bg-white/70 dark:bg-slate-800/60 px-4 py-3 text-sm focus:outline-none focus:ring-4 focus:ring-blue-500/30 focus:border-blue-500" />
                                            <p class="mt-1 text-[11px] text-slate-500 dark:text-slate-400">Mínimo 3 caracteres.</p>
                                        </div>
                                            <div x-data="timezonePicker" class="relative" @click.outside="open=false" @keydown.escape="open=false">
                                                <label class="block text-xs font-semibold uppercase tracking-wide text-slate-600 dark:text-slate-400 mb-2">Zona Horaria</label>
                                                <div class="relative">
                                                    <input type="text" x-model="search" @focus="if(!open){open=true}; filter()" @input="filter()" :placeholder="form.timezone || 'Buscar... (UTC, Europe, America...)'" class="w-full rounded-xl border border-slate-300/70 dark:border-slate-600/60 bg-white/70 dark:bg-slate-800/60 pr-10 px-4 py-2.5 text-sm focus:ring-4 focus:ring-blue-500/30 focus:border-blue-500" />
                                                    <button type="button" @click="toggle()" class="absolute inset-y-0 right-0 flex items-center pr-3 text-slate-500 hover:text-slate-700 dark:hover:text-slate-200">
                                                        <i class="fa-solid fa-chevron-down text-xs" :class="open ? 'rotate-180 transition' : 'transition'"></i>
                                                    </button>
                                                </div>
                                                <div x-show="open" x-transition class="absolute z-30 mt-1 w-full max-h-72 overflow-auto rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-800 shadow-lg text-sm divide-y divide-slate-200/60 dark:divide-slate-700/60">
                                                    <template x-if="loading">
                                                        <div class="p-3 text-xs text-slate-500 dark:text-slate-400">Cargando zonas...</div>
                                                    </template>
                                                    <template x-if="!loading && filtered.length===0">
                                                        <div class="p-3 text-xs text-slate-500 dark:text-slate-400">Sin resultados</div>
                                                    </template>
                                                    <ul class="max-h-64 overflow-y-auto">
                                                        <template x-for="tz in filtered" :key="tz.id">
                                                            <li @click="select(tz)" class="px-3 py-2 cursor-pointer hover:bg-blue-50 dark:hover:bg-slate-700 flex justify-between items-center"
                                                                :class="{'bg-blue-100 dark:bg-slate-700/60': tz.id===form.timezone}">
                                                                <span class="truncate" x-text="tz.label"></span>
                                                                <i x-show="tz.id===form.timezone" class="fa-solid fa-check text-blue-600 text-xs"></i>
                                                            </li>
                                                        </template>
                                                    </ul>
                                                </div>
                                                <input type="hidden" :value="form.timezone" name="timezone" />
                                            </div>
                                            <div x-data="currencyPicker" class="relative" @click.outside="open=false" @keydown.escape="open=false">
                                                <label class="block text-xs font-semibold uppercase tracking-wide text-slate-600 dark:text-slate-400 mb-2">Moneda</label>
                                                <div class="relative">
                                                    <input type="text" x-model="search" @focus="if(!open){open=true}; filter()" @input="filter()" :placeholder="form.currency || 'Buscar... (USD, EUR, Peso...)'" class="w-full rounded-xl border border-slate-300/70 dark:border-slate-600/60 bg-white/70 dark:bg-slate-800/60 pr-10 px-4 py-2.5 text-sm focus:ring-4 focus:ring-blue-500/30 focus:border-blue-500" />
                                                    <button type="button" @click="toggle()" class="absolute inset-y-0 right-0 flex items-center pr-3 text-slate-500 hover:text-slate-700 dark:hover:text-slate-200">
                                                        <i class="fa-solid fa-chevron-down text-xs" :class="open ? 'rotate-180 transition' : 'transition'"></i>
                                                    </button>
                                                </div>
                                                <div x-show="open" x-transition class="absolute z-30 mt-1 w-full max-h-72 overflow-auto rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-800 shadow-lg text-sm divide-y divide-slate-200/60 dark:divide-slate-700/60">
                                                    <template x-if="loading">
                                                        <div class="p-3 text-xs text-slate-500 dark:text-slate-400">Cargando monedas...</div>
                                                    </template>
                                                    <template x-if="!loading && filtered.length===0">
                                                        <div class="p-3 text-xs text-slate-500 dark:text-slate-400">Sin resultados</div>
                                                    </template>
                                                    <ul class="max-h-64 overflow-y-auto">
                                                        <template x-for="c in filtered" :key="c.code">
                                                            <li @click="select(c)" class="px-3 py-2 cursor-pointer hover:bg-blue-50 dark:hover:bg-slate-700 flex justify-between items-center"
                                                                :class="{'bg-blue-100 dark:bg-slate-700/60': c.code===form.currency}">
                                                                <span class="truncate" x-text="c.label"></span>
                                                                <i x-show="c.code===form.currency" class="fa-solid fa-check text-blue-600 text-xs"></i>
                                                            </li>
                                                        </template>
                                                    </ul>
                                                </div>
                                                <input type="hidden" :value="form.currency" name="currency" />
                                            </div>
                                        <div>
                                            <label class="block text-xs font-semibold uppercase tracking-wide text-slate-600 dark:text-slate-400 mb-2">Industria</label>
                                            <select x-model="form.industry" class="w-full rounded-xl border border-slate-300/70 dark:border-slate-600/60 bg-white/70 dark:bg-slate-800/60 px-4 py-3 text-sm focus:ring-4 focus:ring-blue-500/30 focus:border-blue-500">
                                                <option value="">Seleccionar...</option>
                                                <option value="Tecnología">Tecnología</option>
                                                <option value="Retail">Retail</option>
                                                <option value="Manufactura">Manufactura</option>
                                                <option value="Servicios">Servicios</option>
                                                <option value="Educación">Educación</option>
                                                <option value="Salud">Salud</option>
                                                <option value="Otro">Otro</option>
                                            </select>
                                        </div>
                                        <div>
                                            <label class="block text-xs font-semibold uppercase tracking-wide text-slate-600 dark:text-slate-400 mb-2">Tamaño</label>
                                            <select x-model="form.size" class="w-full rounded-xl border border-slate-300/70 dark:border-slate-600/60 bg-white/70 dark:bg-slate-800/60 px-4 py-3 text-sm focus:ring-4 focus:ring-blue-500/30 focus:border-blue-500">
                                                <option value="">Seleccionar...</option>
                                                <option value="1-10">1-10</option>
                                                <option value="11-50">11-50</option>
                                                <option value="51-200">51-200</option>
                                                <option value="201-500">201-500</option>
                                                <option value="500+">500+</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <!-- Step 1: Departamentos -->
                                <div x-show="index === 1" class="space-y-6">
                                    <div class="grid md:grid-cols-3 gap-4">
                                        <template x-for="dept in availableDepartments" :key="dept">
                                            <label class="group relative flex items-center gap-3 rounded-xl border p-4 cursor-pointer transition-all text-sm font-medium shadow-sm hover:shadow-md"
                                                   :class="form.departments.includes(dept) ? 'border-blue-500 bg-blue-500/10 dark:bg-blue-500/20 ring-2 ring-blue-500/30' : 'border-slate-300/70 dark:border-slate-600/60 bg-white/60 dark:bg-slate-800/60'">
                                                <input type="checkbox" class="sr-only" :value="dept" x-model="form.departments" />
                                                <span class="flex h-5 w-5 items-center justify-center rounded border-2" :class="form.departments.includes(dept) ? 'bg-blue-600 border-blue-600 text-white' : 'border-slate-400 dark:border-slate-500'">
                                                    <i x-show="form.departments.includes(dept)" class="fa-solid fa-check text-[10px]"></i>
                                                </span>
                                                <span x-text="dept" class="truncate"></span>
                                            </label>
                                        </template>
                                    </div>
                                    <div class="pt-2">
                                        <label class="text-xs font-semibold uppercase tracking-wide text-slate-600 dark:text-slate-400 mb-2 flex items-center gap-2"><i class="fa-solid fa-plus text-purple-500"></i>Agregar otro</label>
                                        <div class="flex gap-2">
                                            <input x-model="newDepartment" @keyup.enter="addDepartment" type="text" placeholder="Finanzas, Legal..." class="flex-1 rounded-xl border border-slate-300/70 dark:border-slate-600/60 bg-white/70 dark:bg-slate-800/60 px-4 py-2.5 text-sm focus:ring-4 focus:ring-blue-500/30 focus:border-blue-500" />
                                            <button type="button" @click="addDepartment" :disabled="!newDepartment.trim()" class="px-4 py-2.5 rounded-xl font-semibold text-white bg-gradient-to-r from-blue-600 to-indigo-600 disabled:opacity-50 disabled:cursor-not-allowed hover:from-blue-700 hover:to-indigo-700 transition">
                                                <i class="fa-solid fa-plus"></i>
                                            </button>
                                        </div>
                                        <div x-show="form.departments.length" class="mt-4 flex flex-wrap gap-2">
                                            <template x-for="dept in form.departments" :key="dept">
                                                <span class="inline-flex items-center gap-2 rounded-full bg-blue-600/10 dark:bg-blue-600/20 text-blue-700 dark:text-blue-300 px-3 py-1 text-xs">
                                                    <span x-text="dept"></span>
                                                    <button type="button" @click="removeDepartment(dept)" class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-200"><i class="fa-solid fa-xmark text-[10px]"></i></button>
                                                </span>
                                            </template>
                                        </div>
                                    </div>
                                    <p class="text-[11px] text-slate-500 dark:text-slate-400">Selecciona al menos 1 departamento para continuar.</p>
                                </div>

                                <!-- Step 2: Primer Empleado -->
                                <div x-show="index === 2" class="space-y-6">
                                    <div class="grid md:grid-cols-2 gap-6">
                                        <div>
                                            <label class="block text-xs font-semibold uppercase tracking-wide text-slate-600 dark:text-slate-400 mb-2">Nombre Completo</label>
                                            <input x-model="form.employee_name" type="text" placeholder="Ej: Juan Pérez" class="w-full rounded-xl border border-slate-300/70 dark:border-slate-600/60 bg-white/70 dark:bg-slate-800/60 px-4 py-3 text-sm focus:ring-4 focus:ring-blue-500/30 focus:border-blue-500" />
                                        </div>
                                        <div>
                                            <label class="block text-xs font-semibold uppercase tracking-wide text-slate-600 dark:text-slate-400 mb-2">Email</label>
                                            <input x-model="form.employee_email" type="email" placeholder="juan.perez@empresa.com" class="w-full rounded-xl border border-slate-300/70 dark:border-slate-600/60 bg-white/70 dark:bg-slate-800/60 px-4 py-3 text-sm focus:ring-4 focus:ring-blue-500/30 focus:border-blue-500" />
                                        </div>
                                        <div class="md:col-span-2">
                                            <label class="block text-xs font-semibold uppercase tracking-wide text-slate-600 dark:text-slate-400 mb-2">Posición</label>
                                            <input x-model="form.employee_position" type="text" placeholder="Ej: Gerente General" class="w-full rounded-xl border border-slate-300/70 dark:border-slate-600/60 bg-white/70 dark:bg-slate-800/60 px-4 py-3 text-sm focus:ring-4 focus:ring-blue-500/30 focus:border-blue-500" />
                                        </div>
                                    </div>
                                    <p class="text-[11px] text-slate-500 dark:text-slate-400">Este paso es opcional. Puedes cargar empleados luego.</p>
                                </div>

                                <!-- Step 3: Resumen -->
                                <div x-show="index === 3" class="space-y-8">
                                    <div class="grid md:grid-cols-2 gap-6 text-sm">
                                        <div class="p-5 rounded-xl border border-slate-200/70 dark:border-slate-700/70 bg-white/60 dark:bg-slate-800/60">
                                            <h4 class="font-semibold text-slate-700 dark:text-slate-200 mb-3 flex items-center gap-2"><i class="fa-solid fa-building text-blue-500"></i>Empresa</h4>
                                            <ul class="space-y-1 text-slate-600 dark:text-slate-300 text-xs">
                                                <li><strong>Nombre:</strong> <span x-text="form.company_name || '—'"></span></li>
                                                <li><strong>Industria:</strong> <span x-text="form.industry || '—'"></span></li>
                                                <li><strong>Tamaño:</strong> <span x-text="form.size || '—'"></span></li>
                                                <li><strong>Zona Horaria:</strong> <span x-text="form.timezone || '—'"></span></li>
                                                <li><strong>Moneda:</strong> <span x-text="form.currency || '—'"></span></li>
                                            </ul>
                                        </div>
                                        <div class="p-5 rounded-xl border border-slate-200/70 dark:border-slate-700/70 bg-white/60 dark:bg-slate-800/60">
                                            <h4 class="font-semibold text-slate-700 dark:text-slate-200 mb-3 flex items-center gap-2"><i class="fa-solid fa-layer-group text-purple-500"></i>Departamentos</h4>
                                            <div class="flex flex-wrap gap-2">
                                                <template x-for="dept in form.departments" :key="dept">
                                                    <span class="px-2.5 py-1 rounded-full bg-blue-600/10 dark:bg-blue-600/20 text-blue-700 dark:text-blue-300 text-[11px]" x-text="dept"></span>
                                                </template>
                                            </div>
                                        </div>
                                        <div class="p-5 rounded-xl border border-slate-200/70 dark:border-slate-700/70 bg-white/60 dark:bg-slate-800/60 md:col-span-2">
                                            <h4 class="font-semibold text-slate-700 dark:text-slate-200 mb-3 flex items-center gap-2"><i class="fa-solid fa-user-plus text-emerald-500"></i>Empleado Inicial</h4>
                                            <ul class="space-y-1 text-slate-600 dark:text-slate-300 text-xs">
                                                <li><strong>Nombre:</strong> <span x-text="form.employee_name || '—'"></span></li>
                                                <li><strong>Email:</strong> <span x-text="form.employee_email || '—'"></span></li>
                                                <li><strong>Posición:</strong> <span x-text="form.employee_position || '—'"></span></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <p class="text-[11px] text-slate-500 dark:text-slate-400">Si todo está correcto, finaliza la configuración. Puedes editar cualquier paso usando el botón "Anterior".</p>
                                </div>
                            </section>
                        </template>

                        <!-- Navigation -->
                        <div class="flex flex-col sm:flex-row gap-4 justify-between pt-6 border-t border-slate-200 dark:border-slate-700">
                            <div class="flex gap-3 order-2 sm:order-1">
                                <button type="button" @click="prevStep" x-show="currentStep > 0" class="px-5 py-3 rounded-xl border border-slate-300/70 dark:border-slate-600/60 text-slate-700 dark:text-slate-300 text-sm font-medium hover:bg-slate-100 dark:hover:bg-slate-700 transition">
                                    <i class="fa-solid fa-arrow-left mr-2"></i>Anterior
                                </button>
                                <button type="button" @click="nextStep" x-show="currentStep < steps.length - 1" :disabled="!canProceed()" class="px-6 py-3 rounded-xl bg-gradient-to-r from-blue-600 to-indigo-600 text-white text-sm font-semibold shadow disabled:opacity-50 disabled:cursor-not-allowed hover:from-blue-700 hover:to-indigo-700 transition">
                                    Siguiente<i class="fa-solid fa-arrow-right ml-2"></i>
                                </button>
                            </div>
                            <div class="flex-1 order-1 sm:order-2 flex items-center justify-end">
                                <button type="submit" x-show="currentStep === steps.length - 1" :disabled="submitting || !form.company_name || form.departments.length === 0" class="group relative overflow-hidden rounded-xl px-8 py-3 bg-gradient-to-r from-emerald-600 via-teal-600 to-cyan-600 text-white text-sm font-semibold shadow-lg shadow-emerald-600/30 hover:shadow-cyan-600/40 disabled:opacity-50 disabled:cursor-not-allowed focus:outline-none focus:ring-4 focus:ring-emerald-500/40 transition">
                                    <span class="absolute inset-0 -translate-x-full group-hover:translate-x-full bg-gradient-to-r from-transparent via-white/25 to-transparent transition-transform duration-700"></span>
                                    <span class="inline-flex items-center gap-2" x-show="!submitting"><i class="fa-solid fa-check"></i>Finalizar</span>
                                    <span class="inline-flex items-center gap-2" x-show="submitting"><i class="fa-solid fa-spinner fa-spin"></i>Guardando...</span>
                                </button>
                            </div>
                        </div>
                        <p class="text-[10px] text-center text-slate-400">Atajos: Enter siguiente · Shift+Tab anterior · Ctrl+S guardar</p>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<style>
    .glass{background:rgba(255,255,255,0.65);backdrop-filter:blur(18px) saturate(160%);-webkit-backdrop-filter:blur(18px) saturate(160%);} .dark .glass{background:rgba(15,23,42,0.7);}
    [x-cloak]{display:none !important;}
        @keyframes fadeToast{0%{opacity:0;transform:translateY(4px);}10%{opacity:1;transform:translateY(0);}90%{opacity:1;}100%{opacity:0;transform:translateY(-2px);} }
        .animate-fade{animation:fadeToast 3s ease forwards;}
</style>
<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('onboardingWizard', () => ({
        currentStep: 0,
        submitting: false,
        newDepartment: '',
        steps: [
            { title: 'Empresa', desc: 'Datos básicos', headline: 'Información de tu Empresa', sub: 'Cuéntanos sobre tu organización' },
            { title: 'Departamentos', desc: 'Estructura inicial', headline: 'Departamentos Iniciales', sub: 'Selecciona o crea tus áreas claves' },
            { title: 'Empleado', desc: 'Primer recurso (opcional)', headline: 'Primer Empleado (Opcional)', sub: 'Añade un empleado ejemplo' },
            { title: 'Resumen', desc: 'Revisión final', headline: 'Resumen General', sub: 'Verifica antes de finalizar' }
        ],
        form: {
            company_name: @if($company) '{{ addslashes($company->name) }}' @else '' @endif,
            industry: @if($company && $company->industry) '{{ $company->industry }}' @else '' @endif,
            size: @if($company && $company->size) '{{ $company->size }}' @else '' @endif,
            timezone: @if($company && $company->timezone) '{{ $company->timezone }}' @else '' @endif,
            currency: @if($company && $company->currency) '{{ $company->currency }}' @else '' @endif,
            departments: ['Administración'],
            employee_name: '',
            employee_email: '',
            employee_position: ''
        },
        timezones: [],
        currencies: [],
        availableDepartments: [
            'Administración','Recursos Humanos','Desarrollo','Ventas','Marketing','Contabilidad','Operaciones','Soporte Técnico'
        ],
        init(){
            // Exponer referencia global para componentes anidados que no logran resolver el parent por DOM virtualizado
            window.__onboardingRef = this;
            // Cargar meta (timezones / currencies)
            const tzUrl = "{{ url('/api/timezones') }}";
            const curUrl = "{{ url('/api/currencies') }}";
            Promise.all([
                fetch(tzUrl,{headers:{'Accept':'application/json'}}).then(r=> r.ok ? r.json() : [] ).catch(()=>[]),
                fetch(curUrl,{headers:{'Accept':'application/json'}}).then(r=> r.ok ? r.json() : [] ).catch(()=>[])
            ]).then(([tz, cur])=>{
                console.debug('[Onboarding] Fetch meta responses',{timezones:tz?.length, currencies:cur?.length, sampleTz:tz?.[0], sampleCur:cur?.[0]});
                const fallbackTimezones = (()=>{
                    try { if(Intl.supportedValuesOf){ return Intl.supportedValuesOf('timeZone').slice(0,150).map(z=>({id:z,label:z})); } } catch(e){}
                    return [ 'UTC','Europe/Madrid','America/Mexico_City','America/Argentina/Buenos_Aires','America/Bogota','America/Santiago' ].map(z=>({id:z,label:z}));
                })();
                const fallbackCurrencies = [
                    {code:'USD',label:'$ USD · Dólar'},
                    {code:'EUR',label:'€ EUR · Euro'},
                    {code:'ARS',label:'$ ARS · Peso Argentino'},
                    {code:'MXN',label:'$ MXN · Peso Mexicano'},
                    {code:'CLP',label:'$ CLP · Peso Chileno'},
                    {code:'COP',label:'$ COP · Peso Colombiano'}
                ];
                this.timezones = Array.isArray(tz) && tz.length ? tz : fallbackTimezones;
                this.currencies = Array.isArray(cur) && cur.length ? cur : fallbackCurrencies;
                document.dispatchEvent(new CustomEvent('metaReady'));
            }).catch(()=>{
                // fallback completo si ambas peticiones fallan
                this.timezones = [ 'UTC','Europe/Madrid','America/Argentina/Buenos_Aires','America/Mexico_City' ].map(z=>({id:z,label:z}));
                this.currencies = [ {code:'USD',label:'$ USD · Dólar'},{code:'EUR',label:'€ EUR · Euro'} ];
                console.warn('[Onboarding] Fetch meta failed, using hardcoded fallback', {timezones:this.timezones.length, currencies:this.currencies.length});
                document.dispatchEvent(new CustomEvent('metaReady'));
            });

            // Restore draft
            const draft = localStorage.getItem('onboarding_draft');
            if(draft){
                try{ Object.assign(this.form, JSON.parse(draft)); }catch(e){ console.warn('Draft parse error', e); }
            }
            // Keyboard navigation
            window.addEventListener('keydown', (e)=>{
                if(e.key==='Enter' && e.target.tagName!=='TEXTAREA'){
                    if(this.currentStep < this.steps.length-1 && this.canProceed()){
                        e.preventDefault();
                        this.nextStep();
                    }
                }
                if(e.key==='s' && (e.metaKey || e.ctrlKey)){
                    e.preventDefault();
                    this.persistDraft(true);
                }
                if(e.key==='Tab' && e.shiftKey){
                    this.prevStep();
                }
                if(/^[1-9]$/.test(e.key)){
                    const idx=parseInt(e.key,10)-1;
                    if(idx < this.steps.length){ this.jumpTo(idx); }
                }
            });
            this.$watch('form', ()=>{ this.persistDraft(); }, {deep:true});
        },
        persistDraft(showToast=false){
            localStorage.setItem('onboarding_draft', JSON.stringify(this.form));
            if(showToast){ this.flash('Borrador guardado'); }
        },
        flash(msg){
            const el = document.createElement('div');
            el.className='fixed bottom-5 right-5 px-4 py-2 rounded-lg text-sm font-medium bg-slate-900 text-white shadow-lg animate-fade';
            el.textContent=msg; document.body.appendChild(el); setTimeout(()=>{el.classList.add('opacity-0','translate-y-1');},2500); setTimeout(()=>el.remove(),3200);
        },
        canProceed(){
            if(this.currentStep===0){ return (this.form.company_name||'').trim().length>=3; }
            if(this.currentStep===1){ return this.form.departments.length>0; }
            if(this.currentStep===2){
                // validate email if provided
                if(this.form.employee_email && !/^[^@\s]+@[^@\s]+\.[^@\s]+$/.test(this.form.employee_email)) return false;
                return true;
            }
            return true;
        },
        nextStep(){ if(this.canProceed() && this.currentStep < this.steps.length-1){ this.currentStep++; } },
        prevStep(){ if(this.currentStep>0){ this.currentStep--; } },
        jumpTo(i){ if(i < this.currentStep){ this.currentStep=i; return; } if(i>this.currentStep){ while(this.currentStep < i && this.canProceed()){ this.currentStep++; } } },
        addDepartment(){ const v=this.newDepartment.trim(); if(v && !this.form.departments.includes(v)){ this.form.departments.push(v); this.newDepartment=''; } },
        removeDepartment(d){ this.form.departments = this.form.departments.filter(x=>x!==d); },
        async submitForm(){ if(this.submitting) return; if(!this.canProceed()) return; this.submitting=true; try {
                const response = await fetch('{{ route('onboarding.store') }}', { method:'POST', headers:{'Content-Type':'application/json','X-CSRF-TOKEN':document.querySelector('meta[name="csrf-token"]').content}, body: JSON.stringify(this.form) });
                if(response.ok){ localStorage.removeItem('onboarding_draft'); window.location.href='{{ route('dashboard') }}'; } else { const data = await response.json().catch(()=>({})); this.flash(data.message||'Error al guardar'); }
            } catch(e){ console.error(e); this.flash('Error de conexión'); } finally { this.submitting=false; }
        }
    }))

    // Componentes de búsqueda (combobox lightweight)
    Alpine.data('timezonePicker', () => ({
        open:false, search:'', loading:true, filtered:[],
        init(){
            this.bootstrap();
            document.addEventListener('metaReady', () => { this.bootstrap(true); });
            // Interval de seguridad por si el evento se dispara antes de que el componente se monte
            this._tries = 0;
            this._safety = setInterval(()=>{
                if(this._tries++ > 20){ clearInterval(this._safety); return; }
                const parent = this.getParent();
                if(parent && (parent.timezones||[]).length){
                    this.bootstrap(true);
                    clearInterval(this._safety);
                }
            },250);
            // Segundo intento post-mount inmediato
            setTimeout(()=>{ if(this.filtered.length===0) this.bootstrap(true); },0);
        },
        getParent(){
            // Buscar ascendent x-data con 'form'
            let el = this.$root.parentElement;
            while(el){
                if(el.__x && el.__x.$data && Object.prototype.hasOwnProperty.call(el.__x.$data,'form')){
                    return el.__x.$data;
                }
                el = el.parentElement;
            }
            if(window.__onboardingRef){ return window.__onboardingRef; }
            return null;
        },
        bootstrap(refresh=false){
            const parent = this.getParent();
            if(!parent){ this.loading=false; return; }
            this.loading = (parent.timezones||[]).length===0;
            this.filtered = parent.timezones || [];
            console.debug('[TimezonePicker] bootstrap', {loading:this.loading, total: this.filtered.length});
            if(!parent.form.timezone && !this.loading){
                try{
                    const guess = Intl.DateTimeFormat().resolvedOptions().timeZone;
                    if(guess && parent.timezones.find(z=>z.id===guess)) parent.form.timezone = guess;
                }catch(e){}
            }
            if(refresh && this.open){ this.filter(); }
        },
        filter(){
            const parent = this.getParent(); if(!parent){ this.filtered=[]; return; }
            const list = parent.timezones || [];
            const q = this.search.toLowerCase();
            this.filtered = list.filter(t => !q || t.id.toLowerCase().includes(q) || t.label.toLowerCase().includes(q));
            // Salvavidas: si la búsqueda está vacía y no tenemos resultados pero el parent sí tiene data, repoblar
            if(!q && !this.filtered.length && list.length){
                console.warn('[TimezonePicker] filtered vacío pero parent tiene data. Repoblando.');
                this.filtered = list;
            }
        },
        select(tz){ const parent=this.getParent(); if(!parent) return; parent.form.timezone = tz.id; this.search = tz.label; this.open=false; },
        toggle(){
            this.open=!this.open;
            if(this.open){
                // Si parent ya tiene data pero filtered está vacío, rebootstrap
                const parent=this.getParent();
                if(parent && (parent.timezones||[]).length && this.filtered.length===0){ this.bootstrap(true); }
                this.filter();
            }
        }
    }));

    Alpine.data('currencyPicker', () => ({
        open:false, search:'', loading:true, filtered:[],
        init(){
            this.bootstrap();
            document.addEventListener('metaReady', () => { this.bootstrap(true); });
            this._tries = 0;
            this._safety = setInterval(()=>{
                if(this._tries++ > 20){ clearInterval(this._safety); return; }
                const parent = this.getParent();
                if(parent && (parent.currencies||[]).length){
                    this.bootstrap(true);
                    clearInterval(this._safety);
                }
            },250);
            setTimeout(()=>{ if(this.filtered.length===0) this.bootstrap(true); },0);
        },
        getParent(){
            let el = this.$root.parentElement;
            while(el){
                if(el.__x && el.__x.$data && Object.prototype.hasOwnProperty.call(el.__x.$data,'form')){
                    return el.__x.$data;
                }
                el = el.parentElement;
            }
            if(window.__onboardingRef){ return window.__onboardingRef; }
            return null;
        },
        bootstrap(refresh=false){
            const parent = this.getParent(); if(!parent){ this.loading=false; return; }
            this.loading = (parent.currencies||[]).length===0;
            this.filtered = parent.currencies || [];
            console.debug('[CurrencyPicker] bootstrap', {loading:this.loading, total: this.filtered.length});
            if(refresh && this.open){ this.filter(); }
        },
        filter(){
            const parent = this.getParent(); if(!parent){ this.filtered=[]; return; }
            const list = parent.currencies || [];
            const q = this.search.toLowerCase();
            this.filtered = list.filter(c => !q || c.code.toLowerCase().includes(q) || c.label.toLowerCase().includes(q));
            if(!q && !this.filtered.length && list.length){
                console.warn('[CurrencyPicker] filtered vacío pero parent tiene data. Repoblando.');
                this.filtered = list;
            }
        },
        select(c){ const parent=this.getParent(); if(!parent) return; parent.form.currency = c.code; this.search = c.label; this.open=false; },
        toggle(){
            this.open=!this.open;
            if(this.open){
                const parent=this.getParent();
                if(parent && (parent.currencies||[]).length && this.filtered.length===0){ this.bootstrap(true); }
                this.filter();
            }
        }
    }));
})
</script>
@endpush