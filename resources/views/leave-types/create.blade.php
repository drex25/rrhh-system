@extends('layouts.admin')

@section('content')
<div class="max-w-2xl mx-auto bg-white p-8 rounded shadow">
    <h1 class="text-2xl font-bold mb-6 text-gray-800">Nuevo Tipo de Licencia</h1>
    <form action="{{ route('leave-types.store') }}" method="POST">
        @csrf
        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Nombre *</label>
            <input type="text" name="name" value="{{ old('name') }}" class="w-full border-gray-300 rounded px-3 py-2 @error('name') border-red-500 @enderror" required>
            @error('name')<div class="text-red-600 text-sm mt-1">{{ $message }}</div>@enderror
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Días Máximos *</label>
            <input type="number" name="max_days" value="{{ old('max_days') }}" min="1" class="w-full border-gray-300 rounded px-3 py-2 @error('max_days') border-red-500 @enderror" required>
            @error('max_days')<div class="text-red-600 text-sm mt-1">{{ $message }}</div>@enderror
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Descripción</label>
            <textarea name="description" rows="3" class="w-full border-gray-300 rounded px-3 py-2 @error('description') border-red-500 @enderror">{{ old('description') }}</textarea>
            @error('description')<div class="text-red-600 text-sm mt-1">{{ $message }}</div>@enderror
        </div>
        <div class="mb-4">
            <label class="flex items-center">
                <input type="checkbox" name="is_active" value="1" class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500" {{ old('is_active', true) ? 'checked' : '' }}>
                <span class="ml-2 text-gray-700">Activo</span>
            </label>
        </div>
        <div class="flex justify-end">
            <a href="{{ route('leave-types.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300 mr-2">Cancelar</a>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Guardar</button>
        </div>
    </form>
</div>
@endsection 