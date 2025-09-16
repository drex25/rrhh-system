@props([
    'title' => '¿Listo para transformar tu gestión de RRHH?',
    'subtitle' => 'Solicita una demostración personalizada y descubre cómo podemos ayudarte',
    'buttonText' => 'Solicitar demostración',
    'buttonLink' => '#'
])

<section class="py-24 bg-gradient-to-br from-indigo-900 via-blue-900 to-purple-900 relative overflow-hidden">
    <!-- Background elements -->
    <div class="absolute inset-0 overflow-hidden">
        <div class="absolute top-0 left-0 w-full h-full">
            <div class="absolute top-1/4 right-1/4 w-96 h-96 bg-blue-500 rounded-full mix-blend-multiply filter blur-[128px] opacity-30 animate-pulse"></div>
            <div class="absolute bottom-1/3 left-1/3 w-96 h-96 bg-purple-500 rounded-full mix-blend-multiply filter blur-[128px] opacity-30 animate-pulse" style="animation-delay: -4s"></div>
        </div>
        <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNjAiIGhlaWdodD0iNjAiIHZpZXdCb3g9IjAgMCA2MCA2MCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48ZyBmaWxsPSJub25lIiBmaWxsLXJ1bGU9ImV2ZW5vZGQiPjxnIGZpbGw9IiNmZmZmZmYiIGZpbGwtb3BhY2l0eT0iMC4wNSI+PHBhdGggZD0iTTAgMGg2MHY2MEgweiIvPjwvZz48L2c+PC9zdmc+')] bg-[30px_30px]"></div>
    </div>
    
    <div class="container mx-auto px-6 relative z-10">
        <div class="max-w-4xl mx-auto">
            <div class="text-center mb-12">
                <h2 class="text-4xl md:text-5xl font-bold text-white mb-6">{{ $title }}</h2>
                <p class="text-xl text-white/80 mb-8">{{ $subtitle }}</p>
            </div>
            
            <div class="bg-white/10 backdrop-blur-md rounded-3xl p-8 border border-white/20">
                <form class="grid grid-cols-1 md:grid-cols-2 gap-6" action="#" method="POST">
                    @csrf
                    <div>
                        <label for="contact_name" class="block text-white/80 text-sm font-medium mb-2">Nombre completo</label>
                        <input type="text" 
                               id="contact_name" 
                               name="name" 
                               required
                               class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white placeholder-white/50 focus:outline-none focus:ring-2 focus:ring-white/30 focus:border-white/30 transition-all duration-200" 
                               placeholder="Tu nombre">
                    </div>
                    
                    <div>
                        <label for="contact_email" class="block text-white/80 text-sm font-medium mb-2">Correo electrónico</label>
                        <input type="email" 
                               id="contact_email" 
                               name="email" 
                               required
                               class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white placeholder-white/50 focus:outline-none focus:ring-2 focus:ring-white/30 focus:border-white/30 transition-all duration-200" 
                               placeholder="tu@email.com">
                    </div>
                    
                    <div>
                        <label for="contact_company" class="block text-white/80 text-sm font-medium mb-2">Empresa</label>
                        <input type="text" 
                               id="contact_company" 
                               name="company" 
                               required
                               class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white placeholder-white/50 focus:outline-none focus:ring-2 focus:ring-white/30 focus:border-white/30 transition-all duration-200" 
                               placeholder="Nombre de tu empresa">
                    </div>
                    
                    <div>
                        <label for="contact_phone" class="block text-white/80 text-sm font-medium mb-2">Teléfono</label>
                        <input type="tel" 
                               id="contact_phone" 
                               name="phone" 
                               class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white placeholder-white/50 focus:outline-none focus:ring-2 focus:ring-white/30 focus:border-white/30 transition-all duration-200" 
                               placeholder="Tu número de contacto">
                    </div>
                    
                    <div>
                        <label for="contact_employees" class="block text-white/80 text-sm font-medium mb-2">Número de empleados</label>
                        <select id="contact_employees" 
                                name="employees" 
                                class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-white/30 focus:border-white/30 transition-all duration-200">
                            <option value="" class="text-gray-900">Selecciona un rango</option>
                            <option value="1-10" class="text-gray-900">1-10 empleados</option>
                            <option value="11-50" class="text-gray-900">11-50 empleados</option>
                            <option value="51-200" class="text-gray-900">51-200 empleados</option>
                            <option value="201-500" class="text-gray-900">201-500 empleados</option>
                            <option value="500+" class="text-gray-900">Más de 500 empleados</option>
                        </select>
                    </div>
                    
                    <div>
                        <label for="contact_interest" class="block text-white/80 text-sm font-medium mb-2">Área de interés</label>
                        <select id="contact_interest" 
                                name="interest" 
                                class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-white/30 focus:border-white/30 transition-all duration-200">
                            <option value="" class="text-gray-900">Selecciona un área</option>
                            <option value="reclutamiento" class="text-gray-900">Reclutamiento y Selección</option>
                            <option value="nomina" class="text-gray-900">Nómina y Payroll</option>
                            <option value="performance" class="text-gray-900">Evaluación de Desempeño</option>
                            <option value="legajos" class="text-gray-900">Legajos Digitales</option>
                            <option value="completo" class="text-gray-900">Solución Completa</option>
                        </select>
                    </div>
                    
                    <div class="md:col-span-2">
                        <label for="contact_message" class="block text-white/80 text-sm font-medium mb-2">Mensaje</label>
                        <textarea id="contact_message" 
                                  name="message" 
                                  rows="4" 
                                  class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white placeholder-white/50 focus:outline-none focus:ring-2 focus:ring-white/30 focus:border-white/30 transition-all duration-200 resize-none" 
                                  placeholder="¿Cómo podemos ayudarte? Cuéntanos sobre tus necesidades específicas..."></textarea>
                    </div>
                    
                    <div class="md:col-span-2">
                        <div class="flex items-start">
                            <input type="checkbox" 
                                   id="contact_terms" 
                                   name="terms" 
                                   required
                                   class="mt-1 mr-3 h-4 w-4 text-blue-600 bg-white/10 border-white/30 rounded focus:ring-white/30">
                            <label for="contact_terms" class="text-sm text-white/80">
                                Acepto los <a href="#" class="text-blue-300 hover:text-blue-200 underline">términos y condiciones</a> 
                                y la <a href="#" class="text-blue-300 hover:text-blue-200 underline">política de privacidad</a>
                            </label>
                        </div>
                    </div>
                    
                    <div class="md:col-span-2 flex justify-center">
                        <button type="submit" 
                                class="w-full md:w-auto inline-flex items-center justify-center px-8 py-4 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300 hover:from-blue-700 hover:to-indigo-700">
                            <i class="fas fa-paper-plane mr-2"></i>
                            {{ $buttonText }}
                        </button>
                    </div>
                </form>
            </div>
            
            <!-- Additional contact info -->
            <div class="mt-12 grid grid-cols-1 md:grid-cols-3 gap-8 text-center">
                <div class="text-white/80">
                    <div class="w-12 h-12 rounded-full bg-white/10 flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-envelope text-xl"></i>
                    </div>
                    <h3 class="font-semibold mb-2">Email</h3>
                    <p class="text-sm">contacto@tsgroup.com.ar</p>
                </div>
                
                <div class="text-white/80">
                    <div class="w-12 h-12 rounded-full bg-white/10 flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-phone text-xl"></i>
                    </div>
                    <h3 class="font-semibold mb-2">Teléfono</h3>
                    <p class="text-sm">+54 (11) 1234-5678</p>
                </div>
                
                <div class="text-white/80">
                    <div class="w-12 h-12 rounded-full bg-white/10 flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-clock text-xl"></i>
                    </div>
                    <h3 class="font-semibold mb-2">Horarios</h3>
                    <p class="text-sm">Lun - Vie: 9:00 - 18:00</p>
                </div>
            </div>
        </div>
    </div>
</section>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');
    if (form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Aquí puedes agregar la lógica de envío del formulario
            // Por ejemplo, usando fetch para enviar a una API
            
            // Mostrar mensaje de éxito
            Swal.fire({
                icon: 'success',
                title: '¡Mensaje enviado!',
                text: 'Nos pondremos en contacto contigo pronto.',
                confirmButtonColor: '#3B82F6'
            });
        });
    }
});
</script>
@endpush
