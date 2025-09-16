@props([
    'testimonials' => []
])

<section class="py-24 bg-white relative overflow-hidden">
    <!-- Background decorations -->
    <div class="absolute inset-0">
        <div class="absolute top-20 left-20 w-32 h-32 bg-gradient-to-r from-blue-100 to-purple-100 rounded-full opacity-30 blur-xl"></div>
        <div class="absolute bottom-20 right-20 w-40 h-40 bg-gradient-to-r from-pink-100 to-yellow-100 rounded-full opacity-30 blur-xl"></div>
    </div>

    <div class="container mx-auto px-6 relative z-10">
        <div class="text-center mb-16">
            <div class="inline-flex items-center px-4 py-2 rounded-full bg-blue-50 text-blue-600 font-medium mb-4">
                <i class="fas fa-quote-left mr-2"></i>
                Testimonios
            </div>
            <h2 class="text-4xl md:text-5xl font-bold mb-6 bg-gradient-to-r from-gray-900 to-gray-600 bg-clip-text text-transparent">
                {{ $attributes->get('title', 'Lo que dicen nuestros clientes') }}
            </h2>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                {{ $attributes->get('subtitle', 'Empresas de todos los tamaños confían en nuestra plataforma para transformar su gestión de RRHH') }}
            </p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($testimonials as $testimonial)
            <div class="group">
                <div class="h-full bg-white p-8 rounded-3xl shadow-lg hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2 border border-gray-100 relative overflow-hidden">
                    <!-- Quote icon -->
                    <div class="absolute top-6 right-6 text-blue-100 text-4xl">
                        <i class="fas fa-quote-right"></i>
                    </div>
                    
                    <!-- Stars -->
                    <div class="flex mb-6">
                        @for($i = 1; $i <= 5; $i++)
                            @if($i <= ($testimonial['rating'] ?? 5))
                                <i class="fas fa-star text-yellow-400"></i>
                            @else
                                <i class="far fa-star text-gray-300"></i>
                            @endif
                        @endfor
                    </div>
                    
                    <!-- Testimonial text -->
                    <blockquote class="text-gray-700 mb-6 leading-relaxed italic text-lg">
                        "{{ $testimonial['text'] ?? 'Testimonial por defecto sobre la excelente experiencia con la plataforma.' }}"
                    </blockquote>
                    
                    <!-- Author -->
                    <div class="flex items-center">
                        <div class="w-12 h-12 rounded-full bg-gradient-to-br from-{{ $testimonial['color'] ?? 'blue' }}-400 to-{{ $testimonial['color'] ?? 'blue' }}-600 flex items-center justify-center mr-4 text-white font-bold text-xl">
                            {{ substr($testimonial['name'] ?? 'M', 0, 1) }}
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-900">{{ $testimonial['name'] ?? 'María Rodríguez' }}</h4>
                            <p class="text-sm text-gray-500">{{ $testimonial['position'] ?? 'Directora de RRHH' }}</p>
                            <p class="text-sm text-gray-400">{{ $testimonial['company'] ?? 'TechCorp' }}</p>
                        </div>
                    </div>
                    
                    <!-- Hover effect -->
                    <div class="absolute inset-0 rounded-3xl bg-gradient-to-r from-{{ $testimonial['color'] ?? 'blue' }}-500 to-{{ $testimonial['color'] ?? 'blue' }}-600 opacity-0 group-hover:opacity-3 transition-opacity duration-300"></div>
                </div>
            </div>
            @empty
            <!-- Default testimonials if none provided -->
            <div class="group">
                <div class="h-full bg-white p-8 rounded-3xl shadow-lg hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2 border border-gray-100 relative overflow-hidden">
                    <div class="absolute top-6 right-6 text-blue-100 text-4xl">
                        <i class="fas fa-quote-right"></i>
                    </div>
                    <div class="flex mb-6">
                        <i class="fas fa-star text-yellow-400"></i>
                        <i class="fas fa-star text-yellow-400"></i>
                        <i class="fas fa-star text-yellow-400"></i>
                        <i class="fas fa-star text-yellow-400"></i>
                        <i class="fas fa-star text-yellow-400"></i>
                    </div>
                    <blockquote class="text-gray-700 mb-6 leading-relaxed italic text-lg">
                        "Implementamos la plataforma hace 6 meses y ha transformado completamente nuestra gestión de personal. Los procesos son más ágiles y nuestro equipo está más satisfecho."
                    </blockquote>
                    <div class="flex items-center">
                        <div class="w-12 h-12 rounded-full bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center mr-4 text-white font-bold text-xl">
                            M
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-900">María Rodríguez</h4>
                            <p class="text-sm text-gray-500">Directora de RRHH</p>
                            <p class="text-sm text-gray-400">TechCorp</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="group">
                <div class="h-full bg-white p-8 rounded-3xl shadow-lg hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2 border border-gray-100 relative overflow-hidden">
                    <div class="absolute top-6 right-6 text-purple-100 text-4xl">
                        <i class="fas fa-quote-right"></i>
                    </div>
                    <div class="flex mb-6">
                        <i class="fas fa-star text-yellow-400"></i>
                        <i class="fas fa-star text-yellow-400"></i>
                        <i class="fas fa-star text-yellow-400"></i>
                        <i class="fas fa-star text-yellow-400"></i>
                        <i class="fas fa-star text-yellow-400"></i>
                    </div>
                    <blockquote class="text-gray-700 mb-6 leading-relaxed italic text-lg">
                        "La implementación fue rápida y el soporte es excepcional. Hemos reducido costos administrativos y mejorado la experiencia de nuestros colaboradores."
                    </blockquote>
                    <div class="flex items-center">
                        <div class="w-12 h-12 rounded-full bg-gradient-to-br from-purple-400 to-purple-600 flex items-center justify-center mr-4 text-white font-bold text-xl">
                            J
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-900">Juan Martínez</h4>
                            <p class="text-sm text-gray-500">CEO</p>
                            <p class="text-sm text-gray-400">Innovatech</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="group">
                <div class="h-full bg-white p-8 rounded-3xl shadow-lg hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2 border border-gray-100 relative overflow-hidden">
                    <div class="absolute top-6 right-6 text-green-100 text-4xl">
                        <i class="fas fa-quote-right"></i>
                    </div>
                    <div class="flex mb-6">
                        <i class="fas fa-star text-yellow-400"></i>
                        <i class="fas fa-star text-yellow-400"></i>
                        <i class="fas fa-star text-yellow-400"></i>
                        <i class="fas fa-star text-yellow-400"></i>
                        <i class="fas fa-star-half-alt text-yellow-400"></i>
                    </div>
                    <blockquote class="text-gray-700 mb-6 leading-relaxed italic text-lg">
                        "Los reportes y análisis nos han permitido tomar decisiones estratégicas basadas en datos reales. La plataforma es intuitiva y nuestro equipo la adoptó rápidamente."
                    </blockquote>
                    <div class="flex items-center">
                        <div class="w-12 h-12 rounded-full bg-gradient-to-br from-green-400 to-green-600 flex items-center justify-center mr-4 text-white font-bold text-xl">
                            L
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-900">Laura Sánchez</h4>
                            <p class="text-sm text-gray-500">Gerente de RRHH</p>
                            <p class="text-sm text-gray-400">GlobalServices</p>
                        </div>
                    </div>
                </div>
            </div>
            @endforelse
        </div>
        
        <!-- Companies logos -->
        <div class="mt-16 pt-16 border-t border-gray-200">
            <p class="text-center text-gray-500 mb-8 font-medium">Confían en nosotros más de 500 empresas</p>
            <div class="flex items-center justify-center space-x-12 grayscale opacity-60 hover:grayscale-0 hover:opacity-100 transition-all duration-500">
                <!-- You can replace these with actual company logos -->
                <div class="w-24 h-12 bg-gray-200 rounded-lg flex items-center justify-center">
                    <span class="text-gray-500 font-bold text-sm">LOGO 1</span>
                </div>
                <div class="w-24 h-12 bg-gray-200 rounded-lg flex items-center justify-center">
                    <span class="text-gray-500 font-bold text-sm">LOGO 2</span>
                </div>
                <div class="w-24 h-12 bg-gray-200 rounded-lg flex items-center justify-center">
                    <span class="text-gray-500 font-bold text-sm">LOGO 3</span>
                </div>
                <div class="w-24 h-12 bg-gray-200 rounded-lg flex items-center justify-center">
                    <span class="text-gray-500 font-bold text-sm">LOGO 4</span>
                </div>
                <div class="w-24 h-12 bg-gray-200 rounded-lg flex items-center justify-center">
                    <span class="text-gray-500 font-bold text-sm">LOGO 5</span>
                </div>
            </div>
        </div>
    </div>
</section>
