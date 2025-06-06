@extends('layouts.admin')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Candidatos</h1>
                <p class="mt-2 text-gray-600 dark:text-gray-400">Gestione los candidatos y sus procesos de selección</p>
            </div>
            <a href="{{ route('candidates.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                <i class="fas fa-plus mr-2"></i> Nuevo Candidato
            </a>
        </div>

        <!-- Filtros -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 mb-8">
            <form action="{{ route('candidates.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label for="search" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Buscar</label>
                    <input type="text" name="search" id="search" value="{{ request('search') }}"
                        class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Nombre, email, teléfono...">
                </div>

                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Estado</label>
                    <select name="status" id="status"
                        class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Todos los estados</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pendiente</option>
                        <option value="reviewing" {{ request('status') == 'reviewing' ? 'selected' : '' }}>En Revisión</option>
                        <option value="shortlisted" {{ request('status') == 'shortlisted' ? 'selected' : '' }}>Preseleccionado</option>
                        <option value="interview_scheduled" {{ request('status') == 'interview_scheduled' ? 'selected' : '' }}>Entrevista Programada</option>
                        <option value="interviewed" {{ request('status') == 'interviewed' ? 'selected' : '' }}>Entrevistado</option>
                        <option value="technical_test" {{ request('status') == 'technical_test' ? 'selected' : '' }}>Prueba Técnica</option>
                        <option value="reference_check" {{ request('status') == 'reference_check' ? 'selected' : '' }}>Verificación de Referencias</option>
                        <option value="offered" {{ request('status') == 'offered' ? 'selected' : '' }}>Oferta Extendida</option>
                        <option value="accepted" {{ request('status') == 'accepted' ? 'selected' : '' }}>Oferta Aceptada</option>
                        <option value="hired" {{ request('status') == 'hired' ? 'selected' : '' }}>Contratado</option>
                        <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rechazado</option>
                        <option value="withdrawn" {{ request('status') == 'withdrawn' ? 'selected' : '' }}>Retirado</option>
                    </select>
                </div>

                <div>
                    <label for="job_posting_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Vacante</label>
                    <select name="job_posting_id" id="job_posting_id"
                        class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Todas las vacantes</option>
                        @foreach($jobPostings as $jobPosting)
                            <option value="{{ $jobPosting->id }}" {{ request('job_posting_id') == $jobPosting->id ? 'selected' : '' }}>
                                {{ $jobPosting->title }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="flex items-end">
                    <button type="submit" class="w-full px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <i class="fas fa-search mr-2"></i> Filtrar
                    </button>
                </div>
            </form>
        </div>

        <!-- Tabla de Candidatos -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Candidato</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Vacante</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Estado</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Fecha de Aplicación</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-900 divide-y divide-gray-100 dark:divide-gray-800">
                        @forelse($candidates as $candidate)
                            <tr class="hover:bg-blue-50 dark:hover:bg-gray-800/60 transition">
                                <td class="px-6 py-5 whitespace-nowrap">
                                    <div class="flex items-center gap-3">
                                        <div class="bg-blue-100 dark:bg-blue-900 rounded-full w-10 h-10 flex items-center justify-center text-blue-700 dark:text-blue-200 font-bold text-lg uppercase">
                                            {{ strtoupper(substr($candidate->first_name,0,1)) }}{{ strtoupper(substr($candidate->last_name,0,1)) }}
                                        </div>
                                        <div>
                                            <div class="text-base font-semibold text-gray-900 dark:text-white">
                                                {{ $candidate->full_name }}
                                            </div>
                                            <div class="text-sm text-gray-500 dark:text-gray-400">
                                                {{ $candidate->email }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-5 whitespace-nowrap">
                                    <div class="text-base text-gray-900 dark:text-white">{{ $candidate->jobPosting->title }}</div>
                                </td>
                                <td class="px-6 py-5 whitespace-nowrap">
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
                                </td>
                                <td class="px-6 py-5 whitespace-nowrap text-base text-gray-500 dark:text-gray-400">
                                    {{ $candidate->created_at->format('d/m/Y') }}
                                </td>
                                <td class="px-6 py-5 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex items-center gap-2">
                                        <a href="{{ route('candidates.show', $candidate) }}" class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('candidates.edit', $candidate) }}" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        @if($candidate->canBeInterviewed())
                                            <a href="{{ route('interviews.create', ['candidate_id' => $candidate->id]) }}" class="text-green-600 hover:text-green-900 dark:text-green-400 dark:hover:text-green-300" title="Programar Entrevista">
                                                <i class="fas fa-calendar-plus"></i>
                                            </a>
                                        @endif
                                        <form action="{{ route('candidates.destroy', $candidate) }}" method="POST" class="inline" onsubmit="return confirm('¿Está seguro de eliminar este candidato?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                                    No se encontraron candidatos
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Paginación -->
            <div class="px-6 py-4 bg-gray-50 dark:bg-gray-700 border-t border-gray-200 dark:border-gray-600">
                {{ $candidates->links() }}
            </div>
        </div>
    </div>
</div>
@endsection 