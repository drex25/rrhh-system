@extends('layouts.admin')

@section('content')
    <div class="py-12">
        <div class="w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-900 shadow-2xl rounded-3xl overflow-hidden border border-gray-100 dark:border-gray-800">
                <div class="p-8">
                    <div class="flex flex-col md:flex-row md:justify-between md:items-center mb-8 gap-4">
                        <h2 class="font-extrabold text-2xl text-gray-900 dark:text-white tracking-tight flex items-center gap-3">
                            <i class="fas fa-users"></i>
                            Candidatos
                        </h2>
                        <a href="{{ route('candidates.create') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl shadow-lg transition-all text-base focus:outline-none focus:ring-2 focus:ring-blue-400">
                            <i class="fas fa-plus"></i> Nuevo Candidato
                        </a>
                    </div>

                    <!-- Filtros -->
                    <form action="{{ route('candidates.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-10">
                        <div>
                            <label for="search" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Buscar</label>
                            <div class="relative">
                                <span class="absolute left-3 top-3 text-gray-400"><i class="fas fa-search"></i></span>
                                <input type="text" name="search" id="search" value="{{ request('search') }}"
                                    placeholder="Nombre, email, teléfono..."
                                    class="w-full pl-10 pr-4 py-3 rounded-xl border-2 border-gray-200 dark:border-gray-700 dark:bg-gray-800 dark:text-white focus:border-blue-500 focus:ring-blue-500 transition duration-150 text-base shadow-sm">
                            </div>
                        </div>
                        <div>
                            <label for="status" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Estado</label>
                            <div class="relative">
                                <span class="absolute left-3 top-3 text-gray-400"><i class="fas fa-flag"></i></span>
                                <select name="status" id="status"
                                    class="w-full pl-10 pr-4 py-3 rounded-xl border-2 border-gray-200 dark:border-gray-700 dark:bg-gray-800 dark:text-white focus:border-blue-500 focus:ring-blue-500 transition duration-150 text-base shadow-sm">
                                    <option value="">Todos</option>
                                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pendiente</option>
                                    <option value="reviewing" {{ request('status') == 'reviewing' ? 'selected' : '' }}>En Revisión</option>
                                    <option value="interviewed" {{ request('status') == 'interviewed' ? 'selected' : '' }}>Entrevistado</option>
                                    <option value="offered" {{ request('status') == 'offered' ? 'selected' : '' }}>Oferta</option>
                                    <option value="hired" {{ request('status') == 'hired' ? 'selected' : '' }}>Contratado</option>
                                    <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rechazado</option>
                                </select>
                            </div>
                        </div>
                        <div>
                            <label for="job_posting_id" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Vacante</label>
                            <div class="relative">
                                <span class="absolute left-3 top-3 text-gray-400"><i class="fas fa-briefcase"></i></span>
                                <select name="job_posting_id" id="job_posting_id"
                                    class="w-full pl-10 pr-4 py-3 rounded-xl border-2 border-gray-200 dark:border-gray-700 dark:bg-gray-800 dark:text-white focus:border-blue-500 focus:ring-blue-500 transition duration-150 text-base shadow-sm">
                                    <option value="">Todas</option>
                                    @foreach($jobPostings as $jobPosting)
                                        <option value="{{ $jobPosting->id }}" {{ request('job_posting_id') == $jobPosting->id ? 'selected' : '' }}>
                                            {{ $jobPosting->title }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="flex items-end">
                            <button type="submit" class="w-full px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl shadow-lg flex items-center justify-center gap-2 text-base transition-all focus:outline-none focus:ring-2 focus:ring-blue-400">
                                <i class="fas fa-filter"></i> Filtrar
                            </button>
                        </div>
                    </form>

                    <!-- Tabla de Candidatos -->
                    <div class="overflow-x-auto rounded-2xl shadow-lg">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-100 dark:bg-gray-800">
                                <tr>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Candidato</th>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Vacante</th>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Estado</th>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Fecha de Postulación</th>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Acciones</th>
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
                                                @elseif($candidate->status == 'interviewed') bg-purple-100 text-purple-800 dark:bg-purple-900/60 dark:text-purple-200
                                                @elseif($candidate->status == 'offered') bg-green-100 text-green-800 dark:bg-green-900/60 dark:text-green-200
                                                @elseif($candidate->status == 'hired') bg-emerald-100 text-emerald-800 dark:bg-emerald-900/60 dark:text-emerald-200
                                                @elseif($candidate->status == 'rejected') bg-red-100 text-red-800 dark:bg-red-900/60 dark:text-red-200
                                                @else bg-gray-200 text-gray-800 dark:bg-gray-700 dark:text-gray-200 @endif">
                                                <i class="fas fa-circle mr-1 text-xs"></i>
                                                {{ ucfirst($candidate->status) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-5 whitespace-nowrap text-base text-gray-500 dark:text-gray-400">
                                            {{ $candidate->created_at->format('d/m/Y') }}
                                        </td>
                                        <td class="px-6 py-5 whitespace-nowrap text-base font-medium">
                                            <div class="flex space-x-3">
                                                <a href="{{ route('candidates.show', $candidate) }}" class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300" title="Ver Detalles">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('candidates.edit', $candidate) }}" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300" title="Editar">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('candidates.destroy', $candidate) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300" title="Eliminar" onclick="return confirm('¿Está seguro de eliminar este candidato?')">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-5 whitespace-nowrap text-base text-gray-500 dark:text-gray-400 text-center">
                                            No se encontraron candidatos...
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Paginación -->
                    <div class="mt-8 flex justify-center">
                        {{ $candidates->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection 