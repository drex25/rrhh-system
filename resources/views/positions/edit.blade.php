@extends('layouts.admin')

@section('content')
<div class="w-full mx-auto px-4 md:px-6 lg:px-8 py-6">
    <!-- Header -->
    <div class="flex flex-col md:flex-row items-center justify-between bg-white dark:bg-gray-900 rounded-2xl shadow-lg p-8 mb-8 border border-gray-200 dark:border-gray-800 transform transition-all duration-300 hover:shadow-xl">
        <div class="flex items-center gap-4 mb-4 md:mb-0">
            <div class="p-3 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl shadow-lg">
                <i class="fa-solid fa-briefcase text-2xl text-white"></i>
            </div>
            <div>
                <h1 class="text-3xl md:text-4xl font-extrabold text-gray-800 dark:text-white tracking-tight">Editar Posición</h1>
                <p class="text-gray-500 dark:text-gray-400 mt-1">Modificar cargo existente</p>
            </div>
        </div>
    </div>

    <!-- Formulario -->
    <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-lg p-8 border border-gray-200 dark:border-gray-800 transform transition-all duration-300 hover:shadow-xl">
        <form action="{{ route('positions.update', $position) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-2">Título *</label>
                <input type="text" name="title" value="{{ old('title', $position->title) }}" class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-700 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-800 dark:text-gray-100 transition-all duration-200" required>
                @error('title')<span class="text-red-600 text-xs">{{ $message }}</span>@enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-2">Código *</label>
                <input type="text" name="code" value="{{ old('code', $position->code) }}" class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-700 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-800 dark:text-gray-100 transition-all duration-200" required>
                @error('code')<span class="text-red-600 text-xs">{{ $message }}</span>@enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-2">Descripción</label>
                <textarea name="description" rows="2" class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-700 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-800 dark:text-gray-100 transition-all duration-200">{{ old('description', $position->description) }}</textarea>
                @error('description')<span class="text-red-600 text-xs">{{ $message }}</span>@enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-2">Departamento *</label>
                @if($departments->count())
                    <select name="department_id" class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-700 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-800 dark:text-gray-100 transition-all duration-200" required>
                        <option value="">Seleccione...</option>
                        @foreach($departments as $department)
                            <option value="{{ $department->id }}" @selected(old('department_id', $position->department_id) == $department->id)>{{ $department->name }}</option>
                        @endforeach
                    </select>
                @else
                    <div class="flex items-center gap-2 bg-yellow-50 text-yellow-800 p-2 rounded">
                        No hay departamentos. <a href="{{ route('departments.create') }}" class="underline text-blue-600">Crear uno</a>
                    </div>
                @endif
                @error('department_id')<span class="text-red-600 text-xs">{{ $message }}</span>@enderror
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-2">Salario mínimo</label>
                    <input type="number" step="0.01" name="min_salary" value="{{ old('min_salary', $position->min_salary) }}" class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-700 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-800 dark:text-gray-100 transition-all duration-200">
                    @error('min_salary')<span class="text-red-600 text-xs">{{ $message }}</span>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-2">Salario máximo</label>
                    <input type="number" step="0.01" name="max_salary" value="{{ old('max_salary', $position->max_salary) }}" class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-700 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-800 dark:text-gray-100 transition-all duration-200">
                    @error('max_salary')<span class="text-red-600 text-xs">{{ $message }}</span>@enderror
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-2">Responsabilidades</label>
                <textarea name="responsibilities" rows="2" class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-700 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-800 dark:text-gray-100 transition-all duration-200">{{ old('responsibilities', $position->responsibilities) }}</textarea>
                @error('responsibilities')<span class="text-red-600 text-xs">{{ $message }}</span>@enderror
            </div>
            <div class="flex items-center gap-4">
                <label class="inline-flex items-center">
                    <input type="checkbox" name="is_active" value="1" class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500" {{ old('is_active', $position->is_active) ? 'checked' : '' }}>
                    <span class="ml-2 text-gray-700 dark:text-gray-200">Activo</span>
                </label>
            </div>
            <div class="flex justify-end">
                <a href="{{ route('positions.index') }}" class="px-6 py-2.5 bg-gray-200 text-gray-700 rounded-xl hover:bg-gray-300 mr-2 transition-all duration-200">Cancelar</a>
                <button type="submit" class="px-6 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-xl hover:scale-105 hover:from-indigo-600 hover:to-blue-600 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-blue-400 font-semibold">Guardar cambios</button>
            </div>
        </form>
    </div>
</div>
@endsection 