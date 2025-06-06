@extends('layouts.admin')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-8">
    <div class="w-full mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Detalles del Candidato</h1>
                <p class="mt-2 text-gray-600 dark:text-gray-400">Información completa y gestión del proceso de selección</p>
            </div>
            <div class="flex items-center gap-4">
                <a href="{{ route('candidates.edit', $candidate) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-lg transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <i class="fas fa-edit mr-2"></i> Editar
                </a>
                <a href="{{ route('candidates.index') }}" class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 text-gray-700 dark:text-white rounded-lg transition-colors duration-200 border border-gray-200 dark:border-gray-700">
                    <i class="fas fa-arrow-left mr-2"></i> Volver
                </a>
                @if($candidate->status === 'shortlisted')
                    <a href="{{ route('interviews.create-from-candidate', $candidate) }}" class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg transition-colors duration-200">
                        <i class="fas fa-calendar-plus mr-2"></i> Programar Entrevista
                    </a>
                @endif
                @if($candidate->status === 'interview_scheduled')
                    <span class="inline-flex items-center px-4 py-2 bg-yellow-600 text-white rounded-lg">
                        <i class="fas fa-calendar-check mr-2"></i> Entrevista Programada
                    </span>
                @endif
                @if($candidate->status === 'interviewed')
                    <span class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg">
                        <i class="fas fa-user-check mr-2"></i> Entrevistado
                    </span>
                @endif
            </div>
        </div>

        <!-- Panel de Proceso de Selección -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 mb-8">
            <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-6">Proceso de Selección</h2>
            
            <div class="flex items-center justify-between mb-6">
                <div class="flex-1">
                    <div class="flex items-center">
                        @php
                            $steps = [
                                'pending' => ['icon' => 'clock', 'color' => 'yellow', 'label' => 'Pendiente'],
                                'reviewing' => ['icon' => 'search', 'color' => 'blue', 'label' => 'En Revisión'],
                                'shortlisted' => ['icon' => 'star', 'color' => 'indigo', 'label' => 'Preseleccionado'],
                                'interview_scheduled' => ['icon' => 'calendar', 'color' => 'purple', 'label' => 'Entrevista Programada'],
                                'interviewed' => ['icon' => 'comments', 'color' => 'pink', 'label' => 'Entrevistado'],
                                'technical_test' => ['icon' => 'code', 'color' => 'orange', 'label' => 'Prueba Técnica'],
                                'reference_check' => ['icon' => 'check-circle', 'color' => 'teal', 'label' => 'Verificación de Referencias'],
                                'offered' => ['icon' => 'handshake', 'color' => 'green', 'label' => 'Oferta Extendida'],
                                'accepted' => ['icon' => 'check', 'color' => 'emerald', 'label' => 'Oferta Aceptada'],
                                'hired' => ['icon' => 'user-check', 'color' => 'green', 'label' => 'Contratado'],
                                'rejected' => ['icon' => 'times-circle', 'color' => 'red', 'label' => 'Rechazado'],
                                'withdrawn' => ['icon' => 'sign-out-alt', 'color' => 'gray', 'label' => 'Retirado']
                            ];
                            $currentStep = array_search($candidate->status, array_keys($steps));
                        @endphp

                        @foreach($steps as $status => $step)
                            <div class="flex items-center">
                                <div class="flex flex-col items-center">
                                    <div class="w-10 h-10 rounded-full flex items-center justify-center
                                        @if($currentStep >= array_search($status, array_keys($steps)))
                                            bg-{{ $step['color'] }}-100 text-{{ $step['color'] }}-800 dark:bg-{{ $step['color'] }}-900/60 dark:text-{{ $step['color'] }}-200
                                        @else
                                            bg-gray-100 text-gray-400 dark:bg-gray-700 dark:text-gray-500
                                        @endif">
                                        <i class="fas fa-{{ $step['icon'] }}"></i>
                                    </div>
                                    <span class="text-xs mt-1 text-gray-600 dark:text-gray-400">{{ $step['label'] }}</span>
                                </div>
                                @if(!$loop->last)
                                    <div class="w-16 h-1 mx-2
                                        @if($currentStep > array_search($status, array_keys($steps)))
                                            bg-{{ $step['color'] }}-200 dark:bg-{{ $step['color'] }}-700
                                        @else
                                            bg-gray-200 dark:bg-gray-700
                                        @endif">
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Acciones Disponibles -->
            <div class="mt-8">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Acciones Disponibles</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @if($candidate->status === 'pending')
                        <form action="{{ route('candidates.update-status', $candidate) }}" method="POST" class="flex">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="status" value="reviewing">
                            <button type="submit" class="w-full px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                <i class="fas fa-search mr-2"></i> Iniciar Revisión
                            </button>
                        </form>
                    @endif

                    @if($candidate->status === 'reviewing')
                        <form action="{{ route('candidates.update-status', $candidate) }}" method="POST" class="flex">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="status" value="shortlisted">
                            <button type="submit" class="w-full px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-lg transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                <i class="fas fa-star mr-2"></i> Preseleccionar
                            </button>
                        </form>
                    @endif

                    @if($candidate->status === 'shortlisted')
                        <a href="{{ route('interviews.create', ['candidate_id' => $candidate->id]) }}" class="w-full px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white font-medium rounded-lg transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 text-center">
                            <i class="fas fa-calendar-plus mr-2"></i> Programar Entrevista
                        </a>
                    @endif

                    @if($candidate->status === 'interviewed')
                        <form action="{{ route('candidates.update-status', $candidate) }}" method="POST" class="flex">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="status" value="technical_test">
                            <button type="submit" class="w-full px-4 py-2 bg-orange-600 hover:bg-orange-700 text-white font-medium rounded-lg transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500">
                                <i class="fas fa-code mr-2"></i> Asignar Prueba Técnica
                            </button>
                        </form>
                    @endif

                    @if($candidate->status === 'technical_test')
                        <form action="{{ route('candidates.update-status', $candidate) }}" method="POST" class="flex">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="status" value="reference_check">
                            <button type="submit" class="w-full px-4 py-2 bg-teal-600 hover:bg-teal-700 text-white font-medium rounded-lg transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500">
                                <i class="fas fa-check-circle mr-2"></i> Iniciar Verificación de Referencias
                            </button>
                        </form>
                    @endif

                    @if($candidate->status === 'reference_check')
                        <form action="{{ route('candidates.update-status', $candidate) }}" method="POST" class="flex">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="status" value="offered">
                            <button type="submit" class="w-full px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                <i class="fas fa-handshake mr-2"></i> Extender Oferta
                            </button>
                        </form>
                    @endif

                    @if($candidate->status === 'offered')
                        <form action="{{ route('candidates.update-status', $candidate) }}" method="POST" class="flex">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="status" value="accepted">
                            <button type="submit" class="w-full px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-medium rounded-lg transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500">
                                <i class="fas fa-check mr-2"></i> Marcar Oferta como Aceptada
                            </button>
                        </form>
                    @endif

                    @if($candidate->status === 'accepted')
                        <form action="{{ route('candidates.update-status', $candidate) }}" method="POST" class="flex">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="status" value="hired">
                            <button type="submit" class="w-full px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                <i class="fas fa-user-check mr-2"></i> Marcar como Contratado
                            </button>
                        </form>
                    @endif

                    @if(in_array($candidate->status, ['pending', 'reviewing', 'shortlisted', 'interview_scheduled', 'interviewed', 'technical_test', 'reference_check', 'offered']))
                        <form action="{{ route('candidates.update-status', $candidate) }}" method="POST" class="flex">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="status" value="rejected">
                            <div class="w-full">
                                <button type="button" onclick="showRejectionModal()" class="w-full px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-medium rounded-lg transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                    <i class="fas fa-times-circle mr-2"></i> Rechazar Candidato
                                </button>
                            </div>
                        </form>
                    @endif

                    @if(in_array($candidate->status, ['pending', 'reviewing', 'shortlisted', 'interview_scheduled', 'interviewed', 'technical_test', 'reference_check', 'offered']))
                        <form action="{{ route('candidates.update-status', $candidate) }}" method="POST" class="flex">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="status" value="withdrawn">
                            <button type="submit" class="w-full px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-lg transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                                <i class="fas fa-sign-out-alt mr-2"></i> Marcar como Retirado
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>

        <!-- Información del Candidato -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Información Personal -->
            <div class="lg:col-span-2">
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden">
                    <div class="p-6">
                        <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-6">Información Personal</h2>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Nombre Completo</h3>
                                <p class="mt-1 text-lg text-gray-900 dark:text-white">{{ $candidate->full_name }}</p>
                            </div>
                            
                            <div>
                                <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Email</h3>
                                <p class="mt-1 text-lg text-gray-900 dark:text-white">{{ $candidate->email }}</p>
                            </div>
                            
                            <div>
                                <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Teléfono</h3>
                                <p class="mt-1 text-lg text-gray-900 dark:text-white">{{ $candidate->phone }}</p>
                            </div>
                            
                            <div>
                                <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Ubicación</h3>
                                <p class="mt-1 text-lg text-gray-900 dark:text-white">{{ $candidate->location }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Información de la Aplicación -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden mt-8">
                    <div class="p-6">
                        <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-6">Información de la Aplicación</h2>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Vacante</h3>
                                <p class="mt-1 text-lg text-gray-900 dark:text-white">{{ $candidate->jobPosting->title }}</p>
                            </div>
                            
                            <div>
                                <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Estado</h3>
                                <p class="mt-1">
                                    <span class="px-3 py-1 rounded-full text-xs font-bold shadow-sm
                                        @if($candidate->status == 'pending') bg-yellow-100 text-yellow-800 dark:bg-yellow-900/60 dark:text-yellow-200
                                        @elseif($candidate->status == 'reviewing') bg-blue-100 text-blue-800 dark:bg-blue-900/60 dark:text-blue-200
                                        @elseif($candidate->status == 'shortlisted') bg-indigo-100 text-indigo-800 dark:bg-indigo-900/60 dark:text-indigo-200
                                        @elseif($candidate->status == 'interview_scheduled') bg-purple-100 text-purple-800 dark:bg-purple-900/60 dark:text-purple-200
                                        @elseif($candidate->status == 'interviewed') bg-pink-100 text-pink-800 dark:bg-pink-900/60 dark:text-pink-200
                                        @elseif($candidate->status == 'technical_test') bg-orange-100 text-orange-800 dark:bg-orange-900/60 dark:text-orange-200
                                        @elseif($candidate->status == 'reference_check') bg-teal-100 text-teal-800 dark:bg-teal-900/60 dark:text-teal-200
                                        @elseif($candidate->status == 'offered') bg-green-100 text-green-800 dark:bg-green-900/60 dark:text-green-200
                                        @elseif($candidate->status == 'accepted') bg-emerald-100 text-emerald-800 dark:bg-emerald-900/60 dark:text-emerald-200
                                        @elseif($candidate->status == 'hired') bg-green-100 text-green-800 dark:bg-green-900/60 dark:text-green-200
                                        @elseif($candidate->status == 'rejected') bg-red-100 text-red-800 dark:bg-red-900/60 dark:text-red-200
                                        @elseif($candidate->status == 'withdrawn') bg-gray-100 text-gray-800 dark:bg-gray-900/60 dark:text-gray-200
                                        @else bg-gray-200 text-gray-800 dark:bg-gray-700 dark:text-gray-200 @endif">
                                        <i class="fas fa-circle mr-1 text-xs"></i>
                                        {{ match($candidate->status) {
                                            'pending' => 'Pendiente',
                                            'reviewing' => 'En Revisión',
                                            'shortlisted' => 'Preseleccionado',
                                            'interview_scheduled' => 'Entrevista Programada',
                                            'interviewed' => 'Entrevistado',
                                            'technical_test' => 'Prueba Técnica',
                                            'reference_check' => 'Verificación de Referencias',
                                            'offered' => 'Oferta Extendida',
                                            'accepted' => 'Oferta Aceptada',
                                            'hired' => 'Contratado',
                                            'rejected' => 'Rechazado',
                                            'withdrawn' => 'Retirado',
                                            default => ucfirst($candidate->status)
                                        } }}
                                    </span>
                                </p>
                            </div>
                            
                            <div>
                                <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Fecha de Aplicación</h3>
                                <p class="mt-1 text-lg text-gray-900 dark:text-white">{{ $candidate->created_at->format('d/m/Y') }}</p>
                            </div>
                            
                            <div>
                                <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Salario Esperado</h3>
                                <p class="mt-1 text-lg text-gray-900 dark:text-white">{{ $candidate->expected_salary ? '$' . number_format($candidate->expected_salary, 2) : 'No especificado' }}</p>
                            </div>
                        </div>

                        @if($candidate->status === 'rejected' && $candidate->rejection_reason)
                            <div class="mt-6 p-4 bg-red-50 dark:bg-red-900/20 rounded-lg">
                                <h3 class="text-sm font-medium text-red-800 dark:text-red-200">Razón del Rechazo</h3>
                                <p class="mt-1 text-red-700 dark:text-red-300">{{ $candidate->rejection_reason }}</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Historial de Entrevistas -->
                @if($candidate->interviews->count() > 0)
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden mt-8">
                        <div class="p-6">
                            <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-6">Historial de Entrevistas</h2>
                            
                            <div class="space-y-4">
                                @foreach($candidate->interviews as $interview)
                                    <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4">
                                        <div class="flex justify-between items-start">
                                            <div>
                                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                                    {{ $interview->type === 'technical' ? 'Entrevista Técnica' : 'Entrevista General' }}
                                                </h3>
                                                <p class="text-sm text-gray-500 dark:text-gray-400">
                                                    {{ $interview->scheduled_at->format('d/m/Y H:i') }}
                                                </p>
                                            </div>
                                            <span class="px-3 py-1 rounded-full text-xs font-bold shadow-sm
                                                @if($interview->status === 'scheduled') bg-blue-100 text-blue-800 dark:bg-blue-900/60 dark:text-blue-200
                                                @elseif($interview->status === 'completed') bg-green-100 text-green-800 dark:bg-green-900/60 dark:text-green-200
                                                @elseif($interview->status === 'cancelled') bg-red-100 text-red-800 dark:bg-red-900/60 dark:text-red-200
                                                @else bg-gray-200 text-gray-800 dark:bg-gray-700 dark:text-gray-200 @endif">
                                                {{ match($interview->status) {
                                                    'scheduled' => 'Programada',
                                                    'completed' => 'Completada',
                                                    'cancelled' => 'Cancelada',
                                                    default => ucfirst($interview->status)
                                                } }}
                                            </span>
                                        </div>
                                        
                                        @if($interview->feedback)
                                            <div class="mt-4 p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                                                <h4 class="text-sm font-medium text-gray-700 dark:text-gray-300">Feedback</h4>
                                                <p class="mt-1 text-gray-600 dark:text-gray-400">{{ $interview->feedback }}</p>
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Panel Lateral -->
            <div class="space-y-8">
                <!-- Documentos -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden">
                    <div class="p-6">
                        <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-6">Documentos</h2>
                        
                        <div class="space-y-4">
                            @if($candidate->resume_path)
                                <a href="{{ route('candidates.download-resume', $candidate) }}" class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200">
                                    <div class="flex items-center">
                                        <i class="fas fa-file-pdf text-red-500 text-xl mr-3"></i>
                                        <div>
                                            <h3 class="text-sm font-medium text-gray-900 dark:text-white">Currículum Vitae</h3>
                                            <p class="text-xs text-gray-500 dark:text-gray-400">PDF</p>
                                        </div>
                                    </div>
                                    <i class="fas fa-download text-gray-400"></i>
                                </a>
                            @else
                                <p class="text-gray-500 dark:text-gray-400 text-sm">No hay documentos adjuntos</p>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Notas -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden">
                    <div class="p-6">
                        <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-6">Notas</h2>
                        
                        <div class="space-y-4">
                            @if($candidate->notes)
                                <div class="prose dark:prose-invert max-w-none">
                                    {!! $candidate->notes !!}
                                </div>
                            @else
                                <p class="text-gray-500 dark:text-gray-400 text-sm">No hay notas</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Rechazo -->
<div id="rejectionModal" class="fixed inset-0 bg-gray-500 bg-opacity-75 hidden" style="z-index: 50;">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg max-w-lg w-full">
            <form action="{{ route('candidates.update-status', $candidate) }}" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" name="status" value="rejected">
                
                <div class="p-6">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Rechazar Candidato</h3>
                    
                    <div class="mb-4">
                        <label for="rejection_reason" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Razón del Rechazo
                        </label>
                        <textarea name="rejection_reason" id="rejection_reason" rows="4" required
                            class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-blue-500 focus:border-blue-500"></textarea>
                    </div>
                </div>
                
                <div class="px-6 py-4 bg-gray-50 dark:bg-gray-700/50 rounded-b-xl flex justify-end space-x-4">
                    <button type="button" onclick="hideRejectionModal()" class="px-4 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-600 rounded-lg transition-colors duration-200">
                        Cancelar
                    </button>
                    <button type="submit" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-medium rounded-lg transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                        Confirmar Rechazo
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function showRejectionModal() {
    document.getElementById('rejectionModal').classList.remove('hidden');
}

function hideRejectionModal() {
    document.getElementById('rejectionModal').classList.add('hidden');
}
</script>
@endsection 