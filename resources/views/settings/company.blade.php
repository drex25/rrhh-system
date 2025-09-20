@extends('layouts.admin')

@section('title', 'Configuración de Empresa')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <div class="flex items-center justify-between mb-6">
                    <h1 class="text-2xl font-semibold text-gray-900">
                        <i class="fas fa-building mr-2 text-blue-600"></i>
                        Configuración de Empresa
                    </h1>
                </div>

                @if (session('success'))
                    <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('settings.company.update') }}" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <!-- Company Logo Section -->
                    <div class="bg-gray-50 p-6 rounded-lg">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">
                            <i class="fas fa-image mr-2 text-blue-600"></i>
                            Logo de la Empresa
                        </h3>
                        
                        <div class="flex items-center space-x-6">
                            <div class="shrink-0">
                                @if ($company->logo)
                                    <img class="h-20 w-20 object-cover rounded-lg border-2 border-gray-300" 
                                         src="{{ asset('storage/' . $company->logo) }}" 
                                         alt="Logo de {{ $company->name }}"
                                         id="current-logo">
                                @else
                                    <div class="h-20 w-20 bg-gray-200 rounded-lg border-2 border-gray-300 flex items-center justify-center" id="no-logo-placeholder">
                                        <i class="fas fa-building text-gray-400 text-2xl"></i>
                                    </div>
                                @endif
                            </div>
                            
                            <div class="flex-1">
                                <div class="flex items-center space-x-3">
                                    <label for="logo" class="cursor-pointer bg-white py-2 px-3 border border-gray-300 rounded-md shadow-sm text-sm leading-4 font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                        <i class="fas fa-upload mr-2"></i>
                                        Subir logo
                                    </label>
                                    <input id="logo" name="logo" type="file" accept="image/*" class="sr-only" onchange="previewLogo(event)">
                                    
                                    @if ($company->logo)
                                        <button type="button" onclick="removeLogo()" class="bg-red-600 py-2 px-3 border border-transparent rounded-md shadow-sm text-sm font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                            <i class="fas fa-trash mr-2"></i>
                                            Eliminar
                                        </button>
                                    @endif
                                </div>
                                <p class="mt-2 text-sm text-gray-500">
                                    PNG, JPG, GIF hasta 2MB. Recomendado: 200x200px
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Basic Information -->
                    <div class="bg-gray-50 p-6 rounded-lg">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">
                            <i class="fas fa-info-circle mr-2 text-blue-600"></i>
                            Información Básica
                        </h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nombre de la Empresa *</label>
                                <input type="text" name="name" id="name" 
                                       value="{{ old('name', $company->name) }}" 
                                       class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                       required>
                            </div>

                            <div>
                                <label for="business_type" class="block text-sm font-medium text-gray-700 mb-2">Tipo de Empresa</label>
                                <select name="business_type" id="business_type" 
                                        class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                    <option value="">Seleccionar tipo</option>
                                    @foreach ($businessTypes as $value => $label)
                                        <option value="{{ $value }}" {{ old('business_type', $company->business_type) === $value ? 'selected' : '' }}>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label for="tax_id" class="block text-sm font-medium text-gray-700 mb-2">CUIT/RUT/NIT</label>
                                <input type="text" name="tax_id" id="tax_id" 
                                       value="{{ old('tax_id', $company->tax_id) }}" 
                                       class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                       placeholder="Ej: 20-12345678-9">
                            </div>

                            <div>
                                <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">Teléfono</label>
                                <input type="text" name="phone" id="phone" 
                                       value="{{ old('phone', $company->phone) }}" 
                                       class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                       placeholder="Ej: +54 11 1234-5678">
                            </div>

                            <div class="md:col-span-2">
                                <label for="website" class="block text-sm font-medium text-gray-700 mb-2">Sitio Web</label>
                                <input type="url" name="website" id="website" 
                                       value="{{ old('website', $company->website) }}" 
                                       class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                       placeholder="https://www.ejemplo.com">
                            </div>

                            <div class="md:col-span-2">
                                <label for="address" class="block text-sm font-medium text-gray-700 mb-2">Dirección</label>
                                <textarea name="address" id="address" rows="3" 
                                          class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                          placeholder="Dirección completa de la empresa">{{ old('address', $company->address) }}</textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Regional Settings -->
                    <div class="bg-gray-50 p-6 rounded-lg">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">
                            <i class="fas fa-globe mr-2 text-blue-600"></i>
                            Configuración Regional
                        </h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="timezone" class="block text-sm font-medium text-gray-700 mb-2">Zona Horaria *</label>
                                <select name="timezone" id="timezone" 
                                        class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                        required>
                                    @foreach ($timezones as $value => $label)
                                        <option value="{{ $value }}" {{ old('timezone', $company->timezone) === $value ? 'selected' : '' }}>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label for="currency" class="block text-sm font-medium text-gray-700 mb-2">Moneda *</label>
                                <select name="currency" id="currency" 
                                        class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                        required>
                                    @foreach ($currencies as $value => $label)
                                        <option value="{{ $value }}" {{ old('currency', $company->currency) === $value ? 'selected' : '' }}>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="flex justify-end pt-6 border-t border-gray-200">
                        <button type="submit" 
                                class="bg-blue-600 py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            <i class="fas fa-save mr-2"></i>
                            Guardar Configuración
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function previewLogo(event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const currentLogo = document.getElementById('current-logo');
            const placeholder = document.getElementById('no-logo-placeholder');
            
            if (currentLogo) {
                currentLogo.src = e.target.result;
            } else if (placeholder) {
                placeholder.outerHTML = `<img class="h-20 w-20 object-cover rounded-lg border-2 border-gray-300" src="${e.target.result}" alt="Preview" id="current-logo">`;
            }
        };
        reader.readAsDataURL(file);
    }
}

function removeLogo() {
    if (confirm('¿Estás seguro de que quieres eliminar el logo de la empresa?')) {
        fetch('{{ route("settings.company.remove-logo") }}', {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const currentLogo = document.getElementById('current-logo');
                if (currentLogo) {
                    currentLogo.outerHTML = `<div class="h-20 w-20 bg-gray-200 rounded-lg border-2 border-gray-300 flex items-center justify-center" id="no-logo-placeholder">
                        <i class="fas fa-building text-gray-400 text-2xl"></i>
                    </div>`;
                }
                
                // Remove the delete button
                event.target.remove();
                
                // Show success message
                const successDiv = document.createElement('div');
                successDiv.className = 'mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative';
                successDiv.innerHTML = '<span class="block sm:inline">Logo eliminado correctamente</span>';
                document.querySelector('form').parentNode.insertBefore(successDiv, document.querySelector('form'));
                
                // Auto-hide success message after 3 seconds
                setTimeout(() => {
                    successDiv.remove();
                }, 3000);
            } else {
                alert('Error al eliminar el logo');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error al eliminar el logo');
        });
    }
}
</script>
@endpush
@endsection