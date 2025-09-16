@props([
    'faqs' => []
])

<section class="py-24 bg-gray-50 relative">
    <div class="container mx-auto px-6">
        <div class="text-center mb-16">
            <div class="inline-flex items-center px-4 py-2 rounded-full bg-blue-50 text-blue-600 font-medium mb-4">
                <i class="fas fa-question-circle mr-2"></i>
                Preguntas frecuentes
            </div>
            <h2 class="text-4xl md:text-5xl font-bold mb-6 bg-gradient-to-r from-gray-900 to-gray-600 bg-clip-text text-transparent">
                {{ $attributes->get('title', '¿Tienes alguna pregunta?') }}
            </h2>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                {{ $attributes->get('subtitle', 'Encuentra respuestas a las preguntas más comunes sobre nuestra plataforma') }}
            </p>
        </div>
        
        <div class="max-w-4xl mx-auto">
            <div class="space-y-4" x-data="{ activeItem: null }">
                @forelse($faqs as $index => $faq)
                <div class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden">
                    <button @click="activeItem = activeItem === {{ $index }} ? null : {{ $index }}" 
                            class="w-full px-8 py-6 text-left focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all duration-200">
                        <div class="flex items-center justify-between">
                            <h3 class="text-lg font-semibold text-gray-900 pr-8">{{ $faq['question'] ?? 'Pregunta por defecto' }}</h3>
                            <div class="flex-shrink-0">
                                <i class="fas fa-chevron-down text-gray-400 transform transition-transform duration-200" 
                                   :class="{ 'rotate-180': activeItem === {{ $index }} }"></i>
                            </div>
                        </div>
                    </button>
                    <div x-show="activeItem === {{ $index }}" 
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 max-h-0"
                         x-transition:enter-end="opacity-100 max-h-screen"
                         x-transition:leave="transition ease-in duration-200"
                         x-transition:leave-start="opacity-100 max-h-screen"
                         x-transition:leave-end="opacity-0 max-h-0"
                         class="overflow-hidden">
                        <div class="px-8 pb-6">
                            <p class="text-gray-600 leading-relaxed">{{ $faq['answer'] ?? 'Respuesta por defecto a la pregunta.' }}</p>
                        </div>
                    </div>
                </div>
                @empty
                <!-- Default FAQs if none provided -->
                <div class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden">
                    <button @click="activeItem = activeItem === 0 ? null : 0" 
                            class="w-full px-8 py-6 text-left focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all duration-200">
                        <div class="flex items-center justify-between">
                            <h3 class="text-lg font-semibold text-gray-900 pr-8">¿Cuánto tiempo toma implementar la plataforma?</h3>
                            <div class="flex-shrink-0">
                                <i class="fas fa-chevron-down text-gray-400 transform transition-transform duration-200" 
                                   :class="{ 'rotate-180': activeItem === 0 }"></i>
                            </div>
                        </div>
                    </button>
                    <div x-show="activeItem === 0" 
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 max-h-0"
                         x-transition:enter-end="opacity-100 max-h-screen"
                         x-transition:leave="transition ease-in duration-200"
                         x-transition:leave-start="opacity-100 max-h-screen"
                         x-transition:leave-end="opacity-0 max-h-0"
                         class="overflow-hidden">
                        <div class="px-8 pb-6">
                            <p class="text-gray-600 leading-relaxed">La implementación típica toma entre 2 a 4 semanas, dependiendo del tamaño de tu empresa y los módulos que elijas. Nuestro equipo te acompañará en todo el proceso, desde la configuración inicial hasta la capacitación de usuarios.</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden">
                    <button @click="activeItem = activeItem === 1 ? null : 1" 
                            class="w-full px-8 py-6 text-left focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all duration-200">
                        <div class="flex items-center justify-between">
                            <h3 class="text-lg font-semibold text-gray-900 pr-8">¿Los datos están seguros en la nube?</h3>
                            <div class="flex-shrink-0">
                                <i class="fas fa-chevron-down text-gray-400 transform transition-transform duration-200" 
                                   :class="{ 'rotate-180': activeItem === 1 }"></i>
                            </div>
                        </div>
                    </button>
                    <div x-show="activeItem === 1" 
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 max-h-0"
                         x-transition:enter-end="opacity-100 max-h-screen"
                         x-transition:leave="transition ease-in duration-200"
                         x-transition:leave-start="opacity-100 max-h-screen"
                         x-transition:leave-end="opacity-0 max-h-0"
                         class="overflow-hidden">
                        <div class="px-8 pb-6">
                            <p class="text-gray-600 leading-relaxed">Absolutamente. Utilizamos cifrado de nivel bancario, centros de datos certificados ISO 27001, y cumplimos con las normativas de protección de datos más estrictas. Realizamos auditorías de seguridad regulares y backups automáticos para garantizar la integridad de tu información.</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden">
                    <button @click="activeItem = activeItem === 2 ? null : 2" 
                            class="w-full px-8 py-6 text-left focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all duration-200">
                        <div class="flex items-center justify-between">
                            <h3 class="text-lg font-semibold text-gray-900 pr-8">¿Puedo migrar mis datos desde otro sistema?</h3>
                            <div class="flex-shrink-0">
                                <i class="fas fa-chevron-down text-gray-400 transform transition-transform duration-200" 
                                   :class="{ 'rotate-180': activeItem === 2 }"></i>
                            </div>
                        </div>
                    </button>
                    <div x-show="activeItem === 2" 
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 max-h-0"
                         x-transition:enter-end="opacity-100 max-h-screen"
                         x-transition:leave="transition ease-in duration-200"
                         x-transition:leave-start="opacity-100 max-h-screen"
                         x-transition:leave-end="opacity-0 max-h-0"
                         class="overflow-hidden">
                        <div class="px-8 pb-6">
                            <p class="text-gray-600 leading-relaxed">Sí, ofrecemos servicios de migración de datos desde la mayoría de sistemas de RRHH existentes. Nuestro equipo técnico se encarga de transferir toda tu información de manera segura, validando la integridad de los datos y minimizando cualquier tiempo de inactividad.</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden">
                    <button @click="activeItem = activeItem === 3 ? null : 3" 
                            class="w-full px-8 py-6 text-left focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all duration-200">
                        <div class="flex items-center justify-between">
                            <h3 class="text-lg font-semibold text-gray-900 pr-8">¿Qué tipo de soporte técnico ofrecen?</h3>
                            <div class="flex-shrink-0">
                                <i class="fas fa-chevron-down text-gray-400 transform transition-transform duration-200" 
                                   :class="{ 'rotate-180': activeItem === 3 }"></i>
                            </div>
                        </div>
                    </button>
                    <div x-show="activeItem === 3" 
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 max-h-0"
                         x-transition:enter-end="opacity-100 max-h-screen"
                         x-transition:leave="transition ease-in duration-200"
                         x-transition:leave-start="opacity-100 max-h-screen"
                         x-transition:leave-end="opacity-0 max-h-0"
                         class="overflow-hidden">
                        <div class="px-8 pb-6">
                            <p class="text-gray-600 leading-relaxed">Ofrecemos soporte técnico por múltiples canales: email, chat en vivo, teléfono y videoconferencia. Los planes Professional y Enterprise incluyen soporte prioritario con tiempos de respuesta garantizados. También proporcionamos recursos de autoayuda, documentación completa y webinars de formación.</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden">
                    <button @click="activeItem = activeItem === 4 ? null : 4" 
                            class="w-full px-8 py-6 text-left focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all duration-200">
                        <div class="flex items-center justify-between">
                            <h3 class="text-lg font-semibold text-gray-900 pr-8">¿Puedo cancelar mi suscripción en cualquier momento?</h3>
                            <div class="flex-shrink-0">
                                <i class="fas fa-chevron-down text-gray-400 transform transition-transform duration-200" 
                                   :class="{ 'rotate-180': activeItem === 4 }"></i>
                            </div>
                        </div>
                    </button>
                    <div x-show="activeItem === 4" 
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 max-h-0"
                         x-transition:enter-end="opacity-100 max-h-screen"
                         x-transition:leave="transition ease-in duration-200"
                         x-transition:leave-start="opacity-100 max-h-screen"
                         x-transition:leave-end="opacity-0 max-h-0"
                         class="overflow-hidden">
                        <div class="px-8 pb-6">
                            <p class="text-gray-600 leading-relaxed">Sí, puedes cancelar tu suscripción en cualquier momento sin penalizaciones. Los contratos anuales se pueden cancelar con 30 días de aviso. Siempre puedes exportar tus datos antes de la cancelación para asegurar la continuidad de tu información.</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden">
                    <button @click="activeItem = activeItem === 5 ? null : 5" 
                            class="w-full px-8 py-6 text-left focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all duration-200">
                        <div class="flex items-center justify-between">
                            <h3 class="text-lg font-semibold text-gray-900 pr-8">¿La plataforma se integra con otros sistemas?</h3>
                            <div class="flex-shrink-0">
                                <i class="fas fa-chevron-down text-gray-400 transform transition-transform duration-200" 
                                   :class="{ 'rotate-180': activeItem === 5 }"></i>
                            </div>
                        </div>
                    </button>
                    <div x-show="activeItem === 5" 
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 max-h-0"
                         x-transition:enter-end="opacity-100 max-h-screen"
                         x-transition:leave="transition ease-in duration-200"
                         x-transition:leave-start="opacity-100 max-h-screen"
                         x-transition:leave-end="opacity-0 max-h-0"
                         class="overflow-hidden">
                        <div class="px-8 pb-6">
                            <p class="text-gray-600 leading-relaxed">Sí, ofrecemos integraciones con más de 100 aplicaciones populares incluyendo sistemas de contabilidad (QuickBooks, SAP), herramientas de productividad (Slack, Microsoft Teams), y plataformas de reclutamiento. También proporcionamos API REST para integraciones personalizadas.</p>
                        </div>
                    </div>
                </div>
                @endforelse
            </div>
        </div>
        
        <!-- Still have questions -->
        <div class="mt-16 text-center">
            <div class="bg-blue-50 rounded-3xl p-8 max-w-2xl mx-auto">
                <h3 class="text-2xl font-bold text-gray-900 mb-4">¿Aún tienes preguntas?</h3>
                <p class="text-gray-600 mb-6">Nuestro equipo de soporte está aquí para ayudarte</p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="#contact" class="inline-flex items-center px-6 py-3 bg-blue-600 text-white font-medium rounded-xl hover:bg-blue-700 transition-colors duration-200">
                        <i class="fas fa-envelope mr-2"></i>
                        Contactar soporte
                    </a>
                    <a href="#" class="inline-flex items-center px-6 py-3 border border-blue-600 text-blue-600 font-medium rounded-xl hover:bg-blue-50 transition-colors duration-200">
                        <i class="fas fa-calendar mr-2"></i>
                        Agendar una llamada
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
