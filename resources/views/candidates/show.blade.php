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
            </div>
        </div>

        <!-- Panel de Proceso de Selección -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 mb-8">
            <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-6">Proceso de Selección</h2>
            
            @php
                $steps = [
                    ['key' => 'pending', 'label' => 'Pendiente', 'icon' => 'clock'],
                    ['key' => 'reviewing', 'label' => 'En Revisión', 'icon' => 'search'],
                    ['key' => 'shortlisted', 'label' => 'Preseleccionado', 'icon' => 'star'],
                    ['key' => 'interview_scheduled', 'label' => 'Entrevista Programada', 'icon' => 'calendar'],
                    ['key' => 'interviewed', 'label' => 'Entrevistado', 'icon' => 'comments'],
                    ['key' => 'technical_test', 'label' => 'Prueba Técnica', 'icon' => 'code'],
                    ['key' => 'reference_check', 'label' => 'Referencias', 'icon' => 'check-circle'],
                    ['key' => 'preoccupational', 'label' => 'Examen Médico', 'icon' => 'heartbeat'],
                    ['key' => 'offered', 'label' => 'Oferta', 'icon' => 'handshake'],
                    ['key' => 'accepted', 'label' => 'Aceptada', 'icon' => 'check'],
                    ['key' => 'hired', 'label' => 'Contratado', 'icon' => 'user-check'],
                    ['key' => 'rejected', 'label' => 'Rechazado', 'icon' => 'times-circle'],
                    ['key' => 'withdrawn', 'label' => 'Retirado', 'icon' => 'sign-out-alt'],
                ];
                $currentStep = array_search($candidate->status, array_column($steps, 'key'));
            @endphp
            <div class="flex items-center justify-between overflow-x-auto pb-4">
                @foreach($steps as $i => $step)
                    <div class="flex items-center">
                        <div class="flex flex-col items-center">
                            <div class="w-10 h-10 rounded-full flex items-center justify-center
                                @if($i < $currentStep)
                                    bg-green-500 text-white
                                @elseif($i == $currentStep)
                                    bg-blue-600 text-white border-4 border-blue-300
                                @else
                                    bg-gray-200 text-gray-400
                                @endif">
                                <i class="fas fa-{{ $step['icon'] }}"></i>
                            </div>
                            <span class="text-xs mt-1 text-center w-16">{{ $step['label'] }}</span>
                        </div>
                        @if(!$loop->last)
                            <div class="w-8 h-1 mx-1
                                @if($i < $currentStep)
                                    bg-green-500
                                @else
                                    bg-gray-200
                                @endif"></div>
                        @endif
                    </div>
                @endforeach
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
                        <div class="flex flex-col space-y-2">
                            <span class="text-sm text-gray-600 dark:text-gray-400">
                                <i class="fas fa-info-circle mr-2"></i>
                                Se ha enviado un correo al candidato con el enlace de Calendly para agendar la entrevista.
                            </span>
                            @if($candidate->calendly_link)
                                <a href="{{ $candidate->calendly_link }}" target="_blank" class="w-full px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white font-medium rounded-lg transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 text-center">
                                    <i class="fas fa-calendar-alt mr-2"></i> Ver Enlace de Calendly
                                </a>
                            @endif
                        </div>
                    @endif

                    @if($candidate->status === 'interview_scheduled')
                        <div class="flex flex-col space-y-2">
                            <span class="text-sm text-gray-600 dark:text-gray-400">
                                <i class="fas fa-info-circle mr-2"></i>
                                El candidato ha agendado la entrevista.
                            </span>
                            @if($candidate->latestInterview)
                                <div class="space-y-4">
                                    <a href="{{ route('interviews.show', $candidate->latestInterview) }}" class="w-full px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 text-center">
                                        <i class="fas fa-eye mr-2"></i> Ver Detalles de la Entrevista
                                    </a>
                                    
                                    @if($candidate->meet_link)
                                        <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                                            <h4 class="text-sm font-medium text-gray-900 dark:text-white mb-2">Enlace de la Entrevista</h4>
                                            <div class="flex items-center space-x-2">
                                                <input type="text" value="{{ $candidate->meet_link }}" readonly
                                                    class="flex-1 px-3 py-2 bg-white dark:bg-gray-600 border border-gray-300 dark:border-gray-500 rounded-lg text-gray-900 dark:text-white text-sm">
                                                <button onclick="copyToClipboard('{{ $candidate->meet_link }}')" 
                                                    class="px-3 py-2 bg-gray-200 dark:bg-gray-600 hover:bg-gray-300 dark:hover:bg-gray-500 text-gray-700 dark:text-white rounded-lg transition-colors duration-200">
                                                    <i class="fas fa-copy"></i>
                                                </button>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            @endif
                        </div>
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
                                <p class="mt-1 text-lg text-gray-900 dark:text-white">{{ $candidate->name }}</p>
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
                                        @if($candidate->status === 'pending') bg-yellow-100 text-yellow-800 dark:bg-yellow-900/60 dark:text-yellow-200
                                        @elseif($candidate->status === 'reviewing') bg-blue-100 text-blue-800 dark:bg-blue-900/60 dark:text-blue-200
                                        @elseif($candidate->status === 'shortlisted') bg-indigo-100 text-indigo-800 dark:bg-indigo-900/60 dark:text-indigo-200
                                        @elseif($candidate->status === 'interview_scheduled') bg-purple-100 text-purple-800 dark:bg-purple-900/60 dark:text-purple-200
                                        @elseif($candidate->status === 'interviewed') bg-pink-100 text-pink-800 dark:bg-pink-900/60 dark:text-pink-200
                                        @elseif($candidate->status === 'technical_test') bg-orange-100 text-orange-800 dark:bg-orange-900/60 dark:text-orange-200
                                        @elseif($candidate->status === 'reference_check') bg-teal-100 text-teal-800 dark:bg-teal-900/60 dark:text-teal-200
                                        @elseif($candidate->status === 'offered') bg-green-100 text-green-800 dark:bg-green-900/60 dark:text-green-200
                                        @elseif($candidate->status === 'accepted') bg-emerald-100 text-emerald-800 dark:bg-emerald-900/60 dark:text-emerald-200
                                        @elseif($candidate->status === 'hired') bg-green-100 text-green-800 dark:bg-green-900/60 dark:text-green-200
                                        @elseif($candidate->status === 'rejected') bg-red-100 text-red-800 dark:bg-red-900/60 dark:text-red-200
                                        @else bg-gray-100 text-gray-800 dark:bg-gray-900/60 dark:text-gray-200
                                        @endif">
                                        {{ ucfirst($candidate->status) }}
                                    </span>
                                </p>
                            </div>

                            @if($candidate->calendly_link)
                                <div>
                                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Enlace de Calendly</h3>
                                    <a href="{{ $candidate->calendly_link }}" target="_blank" class="mt-1 text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300">
                                        <i class="fas fa-calendar-alt mr-2"></i>
                                        Ver enlace de agendamiento
                                    </a>
                                </div>
                            @endif

                            @if($candidate->latestInterview)
                                <div>
                                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Última Entrevista</h3>
                                    <a href="{{ route('interviews.show', $candidate->latestInterview) }}" class="mt-1 text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300">
                                        <i class="fas fa-eye mr-2"></i>
                                        Ver detalles de la entrevista
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-8">
                <!-- Documentos -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden">
                    <div class="p-6">
                        <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-6">Documentos</h2>
                        
                        <div class="space-y-4">
                            @if($candidate->resume_path)
                                <a href="{{ Storage::url($candidate->resume_path) }}" target="_blank" class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-700 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors duration-200">
                                    <div class="flex items-center">
                                        <i class="fas fa-file-pdf text-red-500 text-xl mr-3"></i>
                                        <span class="text-gray-900 dark:text-white">Currículum</span>
                                    </div>
                                    <i class="fas fa-download text-gray-400"></i>
                                </a>
                            @endif

                            @if($candidate->cover_letter_path)
                                <a href="{{ Storage::url($candidate->cover_letter_path) }}" target="_blank" class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-700 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors duration-200">
                                    <div class="flex items-center">
                                        <i class="fas fa-file-alt text-blue-500 text-xl mr-3"></i>
                                        <span class="text-gray-900 dark:text-white">Carta de Presentación</span>
                                    </div>
                                    <i class="fas fa-download text-gray-400"></i>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Notas -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden">
                    <div class="p-6">
                        <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-6">Notas</h2>
                        
                        <form action="{{ route('candidates.update-notes', $candidate) }}" method="POST" class="space-y-4">
                            @csrf
                            @method('PUT')
                            <div>
                                <textarea name="notes" rows="4" class="w-full px-4 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">{{ $candidate->notes }}</textarea>
                            </div>
                            <button type="submit" class="w-full px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                <i class="fas fa-save mr-2"></i> Guardar Notas
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Rechazo -->
<div id="rejectionModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white dark:bg-gray-800">
        <div class="mt-3">
            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Rechazar Candidato</h3>
            <form action="{{ route('candidates.update-status', $candidate) }}" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" name="status" value="rejected">
                <div>
                    <label for="rejection_reason" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Razón del Rechazo</label>
                    <textarea name="rejection_reason" id="rejection_reason" rows="4" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"></textarea>
                </div>

                <div class="mt-6 flex justify-end space-x-3">
                    <button type="button" onclick="hideRejectionModal()" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500">
                        Cancelar
                    </button>
                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500">
                        Rechazar
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

function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(() => {
        Swal.fire({
            icon: 'success',
            title: '¡Copiado!',
            text: 'El enlace ha sido copiado al portapapeles',
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 2000
        });
    });
}
</script>
@endsection 