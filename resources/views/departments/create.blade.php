@extends('layouts.admin')

@section('content')
<div class="max-w-xl mx-auto bg-white p-8 rounded shadow">
    <h2 class="text-2xl font-bold mb-6 text-gray-800">Nuevo Departamento</h2>
    <form action="{{ route('departments.store') }}" method="POST" class="space-y-6">
        @csrf
        <div>
            <label class="block text-sm font-medium text-gray-700">Nombre *</label>
            <input type="text" name="name" value="{{ old('name') }}" class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
            @error('name')<span class="text-red-600 text-xs">{{ $message }}</span>@enderror
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Código *</label>
            <input type="text" name="code" value="{{ old('code') }}" class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
            @error('code')<span class="text-red-600 text-xs">{{ $message }}</span>@enderror
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Descripción</label>
            <textarea name="description" rows="2" class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">{{ old('description') }}</textarea>
            @error('description')<span class="text-red-600 text-xs">{{ $message }}</span>@enderror
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Manager</label>
            <select name="manager_id" class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">
                <option value="">Sin asignar</option>
                @foreach($employees as $employee)
                    <option value="{{ $employee->id }}" @selected(old('manager_id') == $employee->id)>{{ $employee->first_name }} {{ $employee->last_name }}</option>
                @endforeach
            </select>
            @error('manager_id')<span class="text-red-600 text-xs">{{ $message }}</span>@enderror
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Ubicación</label>
            <input type="text" name="location" value="{{ old('location') }}" class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">
            @error('location')<span class="text-red-600 text-xs">{{ $message }}</span>@enderror
        </div>
        <div class="flex items-center gap-4">
            <label class="inline-flex items-center">
                <input type="checkbox" name="is_active" value="1" class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500" {{ old('is_active', true) ? 'checked' : '' }}>
                <span class="ml-2 text-gray-700">Activo</span>
            </label>
        </div>
        <div class="flex justify-end">
            <a href="{{ route('departments.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300 mr-2">Cancelar</a>
            <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 font-semibold">Guardar</button>
        </div>
    </form>
</div>
@endsection 