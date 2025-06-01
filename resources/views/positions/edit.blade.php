@extends('layouts.admin')

@section('content')
<div class="max-w-xl mx-auto bg-white p-8 rounded shadow">
    <h2 class="text-2xl font-bold mb-6 text-gray-800">Editar Posición</h2>
    <form action="{{ route('positions.update', $position) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')
        <div>
            <label class="block text-sm font-medium text-gray-700">Título *</label>
            <input type="text" name="title" value="{{ old('title', $position->title) }}" class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
            @error('title')<span class="text-red-600 text-xs">{{ $message }}</span>@enderror
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Código *</label>
            <input type="text" name="code" value="{{ old('code', $position->code) }}" class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
            @error('code')<span class="text-red-600 text-xs">{{ $message }}</span>@enderror
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Descripción</label>
            <textarea name="description" rows="2" class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">{{ old('description', $position->description) }}</textarea>
            @error('description')<span class="text-red-600 text-xs">{{ $message }}</span>@enderror
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Departamento *</label>
            @if($departments->count())
                <select name="department_id" class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
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
                <label class="block text-sm font-medium text-gray-700">Salario mínimo</label>
                <input type="number" step="0.01" name="min_salary" value="{{ old('min_salary', $position->min_salary) }}" class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">
                @error('min_salary')<span class="text-red-600 text-xs">{{ $message }}</span>@enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Salario máximo</label>
                <input type="number" step="0.01" name="max_salary" value="{{ old('max_salary', $position->max_salary) }}" class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">
                @error('max_salary')<span class="text-red-600 text-xs">{{ $message }}</span>@enderror
            </div>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Responsabilidades</label>
            <textarea name="responsibilities" rows="2" class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">{{ old('responsibilities', $position->responsibilities) }}</textarea>
            @error('responsibilities')<span class="text-red-600 text-xs">{{ $message }}</span>@enderror
        </div>
        <div class="flex items-center gap-4">
            <label class="inline-flex items-center">
                <input type="checkbox" name="is_active" value="1" class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500" {{ old('is_active', $position->is_active) ? 'checked' : '' }}>
                <span class="ml-2 text-gray-700">Activo</span>
            </label>
        </div>
        <div class="flex justify-end">
            <a href="{{ route('positions.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300 mr-2">Cancelar</a>
            <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 font-semibold">Guardar cambios</button>
        </div>
    </form>
</div>
@endsection 