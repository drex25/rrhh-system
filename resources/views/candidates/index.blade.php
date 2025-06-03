@extends('layouts.admin')

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                            {{ __('Candidatos') }}
                        </h2>
                        <div class="flex space-x-2">
                            <a href="{{ route('candidates.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                <i class="fas fa-plus mr-2"></i>Nuevo Candidato
                            </a>
                        </div>
                    </div>

                    <!-- Filtros -->
                    <div class="mb-6">
                        <form action="{{ route('candidates.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                            <div>
                                <label for="search" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Buscar</label>
                                <input type="text" name="search" id="search" value="{{ request('search') }}"
                                    placeholder="Nombre, email, teléfono..."
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            </div>

                            <div>
                                <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Estado</label>
                                <select name="status" id="status"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                    <option value="">Todos</option>
                                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pendiente</option>
                                    <option value="reviewing" {{ request('status') == 'reviewing' ? 'selected' : '' }}>En Revisión</option>
                                    <option value="interviewed" {{ request('status') == 'interviewed' ? 'selected' : '' }}>Entrevistado</option>
                                    <option value="offered" {{ request('status') == 'offered' ? 'selected' : '' }}>Oferta</option>
                                    <option value="hired" {{ request('status') == 'hired' ? 'selected' : '' }}>Contratado</option>
                                    <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rechazado</option>
                                </select>
                            </div>

                            <div>
                                <label for="job_posting_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Vacante</label>
                                <select name="job_posting_id" id="job_posting_id"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                    <option value="">Todas</option>
                                    @foreach($jobPostings as $jobPosting)
                                        <option value="{{ $jobPosting->id }}" {{ request('job_posting_id') == $jobPosting->id ? 'selected' : '' }}>
                                            {{ $jobPosting->title }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="flex items-end">
                                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                    <i class="fas fa-search mr-2"></i>Filtrar
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Tabla de Candidatos -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Candidato
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Vacante
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Estado
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Fecha de Postulación
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Acciones
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                                @forelse($candidates as $candidate)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div>
                                                    <div class="text-sm font-medium text-gray-900 dark:text-white">
                                                        {{ $candidate->full_name }}
                                                    </div>
                                                    <div class="text-sm text-gray-500 dark:text-gray-400">
                                                        {{ $candidate->email }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900 dark:text-white">{{ $candidate->jobPosting->title }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $candidate->status_badge }}">
                                                {{ ucfirst($candidate->status) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                            {{ $candidate->created_at->format('d/m/Y') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <div class="flex space-x-2">
                                                <a href="{{ route('candidates.show', $candidate) }}" class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('candidates.edit', $candidate) }}" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('candidates.destroy', $candidate) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300" onclick="return confirm('¿Está seguro de eliminar este candidato?')">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400 text-center">
                                            No se encontraron candidatos..
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Paginación -->
                    <div class="mt-4">
                        {{ $candidates->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection 