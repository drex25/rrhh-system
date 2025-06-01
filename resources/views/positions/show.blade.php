@extends('layouts.admin')

@section('content')
<div class="w-full mx-auto bg-white p-8 rounded shadow">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Detalle de la Posición</h1>
        <a href="{{ route('positions.edit', $position) }}" class="inline-flex items-center px-4 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-600 transition">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536M9 11l6 6M3 17.25V21h3.75l11.06-11.06a2.121 2.121 0 00-3-3L3 17.25z"/></svg>
            Editar
        </a>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <div>
            <div class="text-gray-500 text-xs uppercase">Título</div>
            <div class="text-lg font-semibold text-gray-800">{{ $position->title }}</div>
        </div>
        <div>
            <div class="text-gray-500 text-xs uppercase">Código</div>
            <div class="text-lg text-gray-800">{{ $position->code }}</div>
        </div>
        <div>
            <div class="text-gray-500 text-xs uppercase">Descripción</div>
            <div class="text-gray-800">{{ $position->description ?? '-' }}</div>
        </div>
        <div>
            <div class="text-gray-500 text-xs uppercase">Departamento</div>
            <div class="text-gray-800">{{ $position->department->name ?? '-' }}</div>
        </div>
        <div>
            <div class="text-gray-500 text-xs uppercase">Salario mínimo</div>
            <div class="text-gray-800">{{ $position->min_salary ? number_format($position->min_salary, 2, ',', '.') : '-' }}</div>
        </div>
        <div>
            <div class="text-gray-500 text-xs uppercase">Salario máximo</div>
            <div class="text-gray-800">{{ $position->max_salary ? number_format($position->max_salary, 2, ',', '.') : '-' }}</div>
        </div>
        <div class="md:col-span-2">
            <div class="text-gray-500 text-xs uppercase">Responsabilidades</div>
            <div class="text-gray-800">{{ $position->responsibilities ?? '-' }}</div>
        </div>
        <div>
            <div class="text-gray-500 text-xs uppercase">Estado</div>
            @if($position->is_active)
                <span class="px-2 py-1 text-xs bg-green-100 text-green-800 rounded">Activo</span>
            @else
                <span class="px-2 py-1 text-xs bg-red-100 text-red-800 rounded">Inactivo</span>
            @endif
        </div>
    </div>
</div>
@endsection 