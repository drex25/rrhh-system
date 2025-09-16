@props([
    'features' => []
])

<section class="py-24 bg-white relative overflow-hidden">
    <!-- Background decorations -->
    <div class="absolute inset-0">
        <div class="absolute top-10 left-10 w-20 h-20 bg-blue-100 rounded-full opacity-20"></div>
        <div class="absolute bottom-10 right-10 w-32 h-32 bg-purple-100 rounded-full opacity-20"></div>
        <div class="absolute top-1/2 left-1/4 w-16 h-16 bg-pink-100 rounded-full opacity-20"></div>
    </div>

    <div class="container mx-auto px-4 sm:px-6 relative z-10 max-w-7xl">
        <div class="text-center mb-16">
            <div class="inline-flex items-center px-4 py-2 rounded-full bg-blue-50 text-blue-600 font-medium mb-4">
                <i class="fas fa-star mr-2"></i>
                Características principales
            </div>
            <h2 class="text-3xl sm:text-4xl lg:text-5xl font-bold mb-6 bg-gradient-to-r from-gray-900 to-gray-600 bg-clip-text text-transparent">
                {{ $attributes->get('title', 'Soluciones Completas') }}
            </h2>
            <p class="text-lg sm:text-xl text-gray-600 max-w-3xl mx-auto">
                {{ $attributes->get('subtitle', 'Una plataforma integral diseñada para optimizar cada aspecto de la gestión de recursos humanos') }}
            </p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">
            @forelse($features as $feature)
            <div class="group relative">
                <div class="h-full bg-white p-6 sm:p-8 rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2 border border-gray-100 hover:border-{{ $feature['color'] ?? 'blue' }}-200">
                    <!-- Icon -->
                    <div class="w-16 h-16 rounded-2xl bg-{{ $feature['color'] ?? 'blue' }}-100 flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                        <i class="{{ $feature['icon'] ?? 'fas fa-star' }} text-2xl text-{{ $feature['color'] ?? 'blue' }}-600"></i>
                    </div>
                    
                    <!-- Content -->
                    <h3 class="text-xl sm:text-2xl font-bold mb-4 text-gray-900">{{ $feature['title'] ?? 'Título' }}</h3>
                    <p class="text-gray-600 mb-6 leading-relaxed text-sm sm:text-base">{{ $feature['description'] ?? 'Descripción de la característica.' }}</p>
                    
                    <!-- Link -->
                    <a href="{{ $feature['link'] ?? '#' }}" class="inline-flex items-center text-{{ $feature['color'] ?? 'blue' }}-600 font-semibold hover:text-{{ $feature['color'] ?? 'blue' }}-700 transition-colors duration-200">
                        Conocer más
                        <i class="fas fa-arrow-right ml-2 transform group-hover:translate-x-1 transition-transform duration-200"></i>
                    </a>
                    
                    <!-- Hover effect -->
                    <div class="absolute inset-0 rounded-2xl bg-gradient-to-r from-{{ $feature['color'] ?? 'blue' }}-500 to-{{ $feature['color'] ?? 'blue' }}-600 opacity-0 group-hover:opacity-5 transition-opacity duration-300"></div>
                </div>
            </div>
            @empty
            <!-- Default features if none provided -->
            <div class="group relative">
                <div class="h-full bg-white p-8 rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2 border border-gray-100 hover:border-blue-200">
                    <div class="w-16 h-16 rounded-2xl bg-blue-100 flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-user-plus text-2xl text-blue-600"></i>
                    </div>
                    <h3 class="text-2xl font-bold mb-4 text-gray-900">Reclutamiento</h3>
                    <p class="text-gray-600 mb-6 leading-relaxed">Optimiza tu proceso de selección con un sistema completo de gestión de candidatos.</p>
                    <a href="#" class="inline-flex items-center text-blue-600 font-semibold hover:text-blue-700">
                        Conocer más <i class="fas fa-arrow-right ml-2 transform group-hover:translate-x-1 transition-transform duration-200"></i>
                    </a>
                </div>
            </div>
            
            <div class="group relative">
                <div class="h-full bg-white p-8 rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2 border border-gray-100 hover:border-purple-200">
                    <div class="w-16 h-16 rounded-2xl bg-purple-100 flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-folder-open text-2xl text-purple-600"></i>
                    </div>
                    <h3 class="text-2xl font-bold mb-4 text-gray-900">Legajos Digitales</h3>
                    <p class="text-gray-600 mb-6 leading-relaxed">Centraliza toda la información de tus colaboradores en un solo lugar seguro.</p>
                    <a href="#" class="inline-flex items-center text-purple-600 font-semibold hover:text-purple-700">
                        Conocer más <i class="fas fa-arrow-right ml-2 transform group-hover:translate-x-1 transition-transform duration-200"></i>
                    </a>
                </div>
            </div>
            
            <div class="group relative">
                <div class="h-full bg-white p-8 rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2 border border-gray-100 hover:border-green-200">
                    <div class="w-16 h-16 rounded-2xl bg-green-100 flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-chart-line text-2xl text-green-600"></i>
                    </div>
                    <h3 class="text-2xl font-bold mb-4 text-gray-900">Evaluaciones</h3>
                    <p class="text-gray-600 mb-6 leading-relaxed">Implementa ciclos de feedback continuo y evaluaciones de desempeño.</p>
                    <a href="#" class="inline-flex items-center text-green-600 font-semibold hover:text-green-700">
                        Conocer más <i class="fas fa-arrow-right ml-2 transform group-hover:translate-x-1 transition-transform duration-200"></i>
                    </a>
                </div>
            </div>
            @endforelse
        </div>
    </div>
</section>
