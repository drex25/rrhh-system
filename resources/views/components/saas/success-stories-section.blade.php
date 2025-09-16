@props([
    'stories' => [],
    'title' => 'Historias de Éxito',
    'subtitle' => 'Descubre cómo empresas como la tuya han transformado su gestión de RRHH'
])

<section class="py-24 bg-gradient-to-br from-gray-50 to-blue-50 relative overflow-hidden">
    <!-- Background decorations -->
    <div class="absolute inset-0 overflow-hidden">
        <div class="absolute top-20 left-10 w-72 h-72 bg-blue-200 rounded-full opacity-20 blur-3xl animate-pulse"></div>
        <div class="absolute bottom-20 right-10 w-96 h-96 bg-purple-200 rounded-full opacity-20 blur-3xl animate-pulse"></div>
        <div class="absolute top-1/2 left-1/3 w-64 h-64 bg-green-200 rounded-full opacity-10 blur-3xl"></div>
    </div>

    <div class="container mx-auto px-6 relative z-10">
        <!-- Header -->
        <div class="text-center mb-16">
            <div class="inline-flex items-center px-4 py-2 rounded-full bg-green-100 text-green-700 font-medium mb-4">
                <i class="fas fa-trophy mr-2"></i>
                +500 empresas confían en nosotros
            </div>
            <h2 class="text-4xl md:text-5xl font-bold mb-6 bg-gradient-to-r from-gray-900 to-gray-600 bg-clip-text text-transparent">
                {{ $title }}
            </h2>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                {{ $subtitle }}
            </p>
        </div>

        <!-- Success Stories Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 mb-16">
            @forelse($stories as $story)
            <div class="bg-white rounded-3xl p-8 shadow-xl border border-gray-100 hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                <!-- Company header -->
                <div class="flex items-center mb-6">
                    <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-{{ $story['color'] ?? 'blue' }}-500 to-{{ $story['color'] ?? 'blue' }}-600 flex items-center justify-center mr-4">
                        <span class="text-white font-bold text-xl">{{ substr($story['company'] ?? 'C', 0, 1) }}</span>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-gray-900">{{ $story['company'] ?? 'Empresa' }}</h3>
                        <p class="text-gray-600">{{ $story['industry'] ?? 'Industria' }} • {{ $story['employees'] ?? '100' }} empleados</p>
                    </div>
                </div>

                <!-- Challenge -->
                <div class="mb-6">
                    <h4 class="text-lg font-semibold text-gray-900 mb-3 flex items-center">
                        <i class="fas fa-exclamation-triangle text-red-500 mr-2"></i>
                        Desafío
                    </h4>
                    <p class="text-gray-600 leading-relaxed">{{ $story['challenge'] ?? 'Descripción del desafío' }}</p>
                </div>

                <!-- Solution -->
                <div class="mb-6">
                    <h4 class="text-lg font-semibold text-gray-900 mb-3 flex items-center">
                        <i class="fas fa-lightbulb text-yellow-500 mr-2"></i>
                        Solución
                    </h4>
                    <p class="text-gray-600 leading-relaxed">{{ $story['solution'] ?? 'Descripción de la solución' }}</p>
                </div>

                <!-- Results -->
                <div class="bg-gradient-to-r from-green-50 to-blue-50 rounded-2xl p-6">
                    <h4 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                        <i class="fas fa-chart-line text-green-500 mr-2"></i>
                        Resultados
                    </h4>
                    <div class="grid grid-cols-2 gap-4">
                        @if(isset($story['results']))
                            @foreach($story['results'] as $result)
                            <div class="text-center">
                                <div class="text-2xl font-bold text-green-600">{{ $result['value'] }}</div>
                                <div class="text-sm text-gray-600">{{ $result['metric'] }}</div>
                            </div>
                            @endforeach
                        @endif
                    </div>
                </div>

                <!-- Quote -->
                @if(isset($story['quote']))
                <div class="mt-6 pt-6 border-t border-gray-100">
                    <blockquote class="text-gray-700 italic mb-4">"{{ $story['quote'] }}"</blockquote>
                    <div class="flex items-center">
                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-gray-300 to-gray-400 mr-3"></div>
                        <div>
                            <div class="font-semibold text-gray-900">{{ $story['author'] ?? 'Autor' }}</div>
                            <div class="text-sm text-gray-600">{{ $story['position'] ?? 'Cargo' }}</div>
                        </div>
                    </div>
                </div>
                @endif
            </div>
            @empty
            <!-- Default success stories -->
            <div class="bg-white rounded-3xl p-8 shadow-xl border border-gray-100 hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                <div class="flex items-center mb-6">
                    <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center mr-4">
                        <span class="text-white font-bold text-xl">T</span>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-gray-900">TechCorp Solutions</h3>
                        <p class="text-gray-600">Tecnología • 250 empleados</p>
                    </div>
                </div>

                <div class="mb-6">
                    <h4 class="text-lg font-semibold text-gray-900 mb-3 flex items-center">
                        <i class="fas fa-exclamation-triangle text-red-500 mr-2"></i>
                        Desafío
                    </h4>
                    <p class="text-gray-600 leading-relaxed">
                        Procesos manuales de RRHH consumían 40+ horas semanales, errores frecuentes en nóminas y falta de visibilidad en métricas de talento.
                    </p>
                </div>

                <div class="mb-6">
                    <h4 class="text-lg font-semibold text-gray-900 mb-3 flex items-center">
                        <i class="fas fa-lightbulb text-yellow-500 mr-2"></i>
                        Solución
                    </h4>
                    <p class="text-gray-600 leading-relaxed">
                        Implementación completa del sistema RRHH con automatización de nóminas, portal de empleados y analytics avanzados.
                    </p>
                </div>

                <div class="bg-gradient-to-r from-green-50 to-blue-50 rounded-2xl p-6">
                    <h4 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                        <i class="fas fa-chart-line text-green-500 mr-2"></i>
                        Resultados
                    </h4>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="text-center">
                            <div class="text-2xl font-bold text-green-600">85%</div>
                            <div class="text-sm text-gray-600">Reducción tiempo</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-green-600">98%</div>
                            <div class="text-sm text-gray-600">Precisión nóminas</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-green-600">60%</div>
                            <div class="text-sm text-gray-600">Mejor retención</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-green-600">$50K</div>
                            <div class="text-sm text-gray-600">Ahorro anual</div>
                        </div>
                    </div>
                </div>

                <div class="mt-6 pt-6 border-t border-gray-100">
                    <blockquote class="text-gray-700 italic mb-4">
                        "La transformación ha sido increíble. Ahora tenemos visibilidad total de nuestros procesos de RRHH y nuestro equipo puede enfocarse en estrategia en lugar de tareas administrativas."
                    </blockquote>
                    <div class="flex items-center">
                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-gray-300 to-gray-400 mr-3"></div>
                        <div>
                            <div class="font-semibold text-gray-900">María González</div>
                            <div class="text-sm text-gray-600">Directora de RRHH</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-3xl p-8 shadow-xl border border-gray-100 hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                <div class="flex items-center mb-6">
                    <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-purple-500 to-purple-600 flex items-center justify-center mr-4">
                        <span class="text-white font-bold text-xl">R</span>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-gray-900">Retail Excellence</h3>
                        <p class="text-gray-600">Retail • 500 empleados</p>
                    </div>
                </div>

                <div class="mb-6">
                    <h4 class="text-lg font-semibold text-gray-900 mb-3 flex items-center">
                        <i class="fas fa-exclamation-triangle text-red-500 mr-2"></i>
                        Desafío
                    </h4>
                    <p class="text-gray-600 leading-relaxed">
                        Alta rotación de personal (35%), procesos de reclutamiento lentos y dificultades para gestionar horarios de múltiples ubicaciones.
                    </p>
                </div>

                <div class="mb-6">
                    <h4 class="text-lg font-semibold text-gray-900 mb-3 flex items-center">
                        <i class="fas fa-lightbulb text-yellow-500 mr-2"></i>
                        Solución
                    </h4>
                    <p class="text-gray-600 leading-relaxed">
                        Plataforma integrada con ATS optimizado, sistema de evaluación de desempeño y gestión automatizada de horarios.
                    </p>
                </div>

                <div class="bg-gradient-to-r from-green-50 to-blue-50 rounded-2xl p-6">
                    <h4 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                        <i class="fas fa-chart-line text-green-500 mr-2"></i>
                        Resultados
                    </h4>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="text-center">
                            <div class="text-2xl font-bold text-green-600">18%</div>
                            <div class="text-sm text-gray-600">Rotación actual</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-green-600">65%</div>
                            <div class="text-sm text-gray-600">Tiempo reclutamiento</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-green-600">92%</div>
                            <div class="text-sm text-gray-600">Satisfacción empleados</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-green-600">$120K</div>
                            <div class="text-sm text-gray-600">Ahorro costos</div>
                        </div>
                    </div>
                </div>

                <div class="mt-6 pt-6 border-t border-gray-100">
                    <blockquote class="text-gray-700 italic mb-4">
                        "No solo redujimos la rotación a la mitad, sino que ahora podemos predecir y prevenir problemas antes de que ocurran. El ROI ha sido excepcional."
                    </blockquote>
                    <div class="flex items-center">
                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-gray-300 to-gray-400 mr-3"></div>
                        <div>
                            <div class="font-semibold text-gray-900">Carlos Ruiz</div>
                            <div class="text-sm text-gray-600">Gerente General</div>
                        </div>
                    </div>
                </div>
            </div>
            @endforelse
        </div>

        <!-- Stats section -->
        <div class="bg-white rounded-3xl p-12 shadow-xl border border-gray-100">
            <div class="text-center mb-12">
                <h3 class="text-3xl font-bold mb-4 text-gray-900">Resultados que Hablan por Sí Solos</h3>
                <p class="text-gray-600 text-lg">Métricas promedio de nuestros clientes después de 6 meses</p>
            </div>
            
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
                <div class="text-center group">
                    <div class="w-20 h-20 rounded-3xl bg-gradient-to-br from-green-500 to-green-600 flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-clock text-3xl text-white"></i>
                    </div>
                    <div class="text-4xl font-bold text-gray-900 mb-2">73%</div>
                    <div class="text-gray-600 font-medium">Reducción en tiempo administrativo</div>
                </div>
                
                <div class="text-center group">
                    <div class="w-20 h-20 rounded-3xl bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-users text-3xl text-white"></i>
                    </div>
                    <div class="text-4xl font-bold text-gray-900 mb-2">45%</div>
                    <div class="text-gray-600 font-medium">Mejora en retención de empleados</div>
                </div>
                
                <div class="text-center group">
                    <div class="w-20 h-20 rounded-3xl bg-gradient-to-br from-purple-500 to-purple-600 flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-chart-line text-3xl text-white"></i>
                    </div>
                    <div class="text-4xl font-bold text-gray-900 mb-2">89%</div>
                    <div class="text-gray-600 font-medium">Precisión en reportes y métricas</div>
                </div>
                
                <div class="text-center group">
                    <div class="w-20 h-20 rounded-3xl bg-gradient-to-br from-orange-500 to-orange-600 flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-dollar-sign text-3xl text-white"></i>
                    </div>
                    <div class="text-4xl font-bold text-gray-900 mb-2">$85K</div>
                    <div class="text-gray-600 font-medium">Ahorro promedio anual</div>
                </div>
            </div>
        </div>

        <!-- CTA Section -->
        <div class="text-center mt-16">
            <h3 class="text-2xl font-bold mb-4 text-gray-900">¿Listo para escribir tu historia de éxito?</h3>
            <p class="text-gray-600 mb-8 text-lg">Únete a cientos de empresas que ya transformaron su gestión de RRHH</p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="#" class="inline-flex items-center px-8 py-4 bg-blue-600 text-white font-semibold rounded-xl hover:bg-blue-700 transition-colors duration-200 transform hover:scale-105">
                    <i class="fas fa-rocket mr-2"></i>
                    Comenzar Prueba Gratuita
                </a>
                <a href="#" class="inline-flex items-center px-8 py-4 border border-gray-300 text-gray-700 font-semibold rounded-xl hover:bg-gray-50 transition-colors duration-200">
                    <i class="fas fa-calendar mr-2"></i>
                    Agendar Demo Personalizada
                </a>
            </div>
        </div>
    </div>
</section>
