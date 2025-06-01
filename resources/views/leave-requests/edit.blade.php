@extends('layouts.admin')

@section('content')
<div class="max-w-2xl mx-auto bg-white p-8 rounded shadow">
    <h1 class="text-2xl font-bold mb-6 text-gray-800">Editar Solicitud de Licencia</h1>
    <form action="{{ route('leave-requests.update', $leaveRequest) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Empleado</label>
            <select name="employee_id" class="w-full border-gray-300 rounded px-3 py-2 @error('employee_id') border-red-500 @enderror">
                <option value="">Seleccione un empleado</option>
                @foreach($employees as $employee)
                    <option value="{{ $employee->id }}" {{ old('employee_id', $leaveRequest->employee_id) == $employee->id ? 'selected' : '' }}>{{ $employee->first_name }} {{ $employee->last_name }}</option>
                @endforeach
            </select>
            @error('employee_id')<div class="text-red-600 text-sm mt-1">{{ $message }}</div>@enderror
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Tipo de Licencia</label>
            <select name="leave_type_id" class="w-full border-gray-300 rounded px-3 py-2 @error('leave_type_id') border-red-500 @enderror">
                <option value="">Seleccione un tipo</option>
                @foreach($leaveTypes as $type)
                    <option value="{{ $type->id }}" {{ old('leave_type_id', $leaveRequest->leave_type_id) == $type->id ? 'selected' : '' }}>{{ $type->name }}</option>
                @endforeach
            </select>
            @error('leave_type_id')<div class="text-red-600 text-sm mt-1">{{ $message }}</div>@enderror
        </div>
        <div class="mb-4 flex gap-4">
            <div class="w-1/2">
                <label class="block text-gray-700 font-semibold mb-2">Desde</label>
                <input type="date" name="start_date" value="{{ old('start_date', $leaveRequest->start_date) }}" class="w-full border-gray-300 rounded px-3 py-2 @error('start_date') border-red-500 @enderror">
                @error('start_date')<div class="text-red-600 text-sm mt-1">{{ $message }}</div>@enderror
            </div>
            <div class="w-1/2">
                <label class="block text-gray-700 font-semibold mb-2">Hasta</label>
                <input type="date" name="end_date" value="{{ old('end_date', $leaveRequest->end_date) }}" class="w-full border-gray-300 rounded px-3 py-2 @error('end_date') border-red-500 @enderror">
                @error('end_date')<div class="text-red-600 text-sm mt-1">{{ $message }}</div>@enderror
            </div>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Motivo</label>
            <textarea name="reason" rows="3" class="w-full border-gray-300 rounded px-3 py-2 @error('reason') border-red-500 @enderror">{{ old('reason', $leaveRequest->reason) }}</textarea>
            @error('reason')<div class="text-red-600 text-sm mt-1">{{ $message }}</div>@enderror
        </div>
        <div class="flex justify-end">
            <a href="{{ route('leave-requests.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300 mr-2">Cancelar</a>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Actualizar</button>
        </div>
    </form>
</div>
@endsection 