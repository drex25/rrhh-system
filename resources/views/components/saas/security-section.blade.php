@props([
    'title' => 'Seguridad y Confianza',
    'subtitle' => 'Protegemos tu información con los más altos estándares de seguridad'
])

<section class="py-24 bg-gray-50 relative overflow-hidden">
    <!-- Background decorations -->
    <div class="absolute inset-0">
        <div class="absolute top-10 right-10 w-32 h-32 bg-blue-100 rounded-full opacity-20 blur-xl"></div>
        <div class="absolute bottom-10 left-10 w-40 h-40 bg-green-100 rounded-full opacity-20 blur-xl"></div>
    </div>

    <div class="container mx-auto px-6 relative z-10">
        <div class="text-center mb-16">
            <div class="inline-flex items-center px-4 py-2 rounded-full bg-green-50 text-green-600 font-medium mb-4">
                <i class="fas fa-shield-alt mr-2"></i>
                Seguridad certificada
            </div>
            <h2 class="text-4xl md:text-5xl font-bold mb-6 bg-gradient-to-r from-gray-900 to-gray-600 bg-clip-text text-transparent">
                {{ $title }}
            </h2>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                {{ $subtitle }}
            </p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-16">
            <!-- ISO 27001 -->
            <div class="text-center group">
                <div class="w-20 h-20 rounded-2xl bg-blue-100 flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform duration-300">
                    <i class="fas fa-certificate text-3xl text-blue-600"></i>
                </div>
                <h3 class="text-xl font-bold mb-2 text-gray-900">ISO 27001</h3>
                <p class="text-gray-600 text-sm">Certificación internacional en gestión de seguridad de la información</p>
            </div>
            
            <!-- SOC 2 -->
            <div class="text-center group">
                <div class="w-20 h-20 rounded-2xl bg-green-100 flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform duration-300">
                    <i class="fas fa-check-double text-3xl text-green-600"></i>
                </div>
                <h3 class="text-xl font-bold mb-2 text-gray-900">SOC 2 Type II</h3>
                <p class="text-gray-600 text-sm">Auditoría de controles de seguridad, disponibilidad y confidencialidad</p>
            </div>
            
            <!-- GDPR -->
            <div class="text-center group">
                <div class="w-20 h-20 rounded-2xl bg-purple-100 flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform duration-300">
                    <i class="fas fa-user-shield text-3xl text-purple-600"></i>
                </div>
                <h3 class="text-xl font-bold mb-2 text-gray-900">GDPR</h3>
                <p class="text-gray-600 text-sm">Cumplimiento total del Reglamento General de Protección de Datos</p>
            </div>
            
            <!-- Encryption -->
            <div class="text-center group">
                <div class="w-20 h-20 rounded-2xl bg-yellow-100 flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform duration-300">
                    <i class="fas fa-lock text-3xl text-yellow-600"></i>
                </div>
                <h3 class="text-xl font-bold mb-2 text-gray-900">AES-256</h3>
                <p class="text-gray-600 text-sm">Cifrado de nivel bancario para todos los datos en tránsito y reposo</p>
            </div>
        </div>
        
        <!-- Detailed Features -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <!-- Left side - Image -->
            <div class="relative">
                <div class="absolute inset-0 bg-gradient-to-r from-blue-600/20 to-purple-600/20 rounded-3xl blur-3xl"></div>
                <img src="https://cdn.pixabay.com/photo/2018/05/14/16/54/cyber-3400789_1280.jpg" alt="Security" class="relative rounded-3xl shadow-2xl w-full">
            </div>
            
            <!-- Right side - Content -->
            <div class="space-y-8">
                <div class="flex gap-4">
                    <div class="flex-shrink-0 w-12 h-12 rounded-xl bg-blue-100 flex items-center justify-center">
                        <i class="fas fa-cloud-download-alt text-blue-600"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold mb-2 text-gray-900">Backups Automáticos</h3>
                        <p class="text-gray-600">Respaldos automáticos cada 6 horas con retención de 30 días. Recuperación de datos en menos de 4 horas.</p>
                    </div>
                </div>
                
                <div class="flex gap-4">
                    <div class="flex-shrink-0 w-12 h-12 rounded-xl bg-green-100 flex items-center justify-center">
                        <i class="fas fa-eye text-green-600"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold mb-2 text-gray-900">Monitoreo 24/7</h3>
                        <p class="text-gray-600">Supervisión continua de la infraestructura con alertas en tiempo real y respuesta inmediata.</p>
                    </div>
                </div>
                
                <div class="flex gap-4">
                    <div class="flex-shrink-0 w-12 h-12 rounded-xl bg-purple-100 flex items-center justify-center">
                        <i class="fas fa-users-cog text-purple-600"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold mb-2 text-gray-900">Control de Acceso</h3>
                        <p class="text-gray-600">Autenticación de dos factores, roles granulares y auditoría completa de accesos.</p>
                    </div>
                </div>
                
                <div class="flex gap-4">
                    <div class="flex-shrink-0 w-12 h-12 rounded-xl bg-yellow-100 flex items-center justify-center">
                        <i class="fas fa-server text-yellow-600"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold mb-2 text-gray-900">Infraestructura Segura</h3>
                        <p class="text-gray-600">Centros de datos tier 4 con redundancia geográfica y disponibilidad del 99.99%.</p>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Trust badges -->
        <div class="mt-16 text-center">
            <p class="text-gray-600 mb-8 font-medium">Confianza validada por líderes de la industria</p>
            <div class="flex items-center justify-center space-x-12 grayscale opacity-60 hover:grayscale-0 hover:opacity-100 transition-all duration-500">
                <!-- Replace with actual security partner logos -->
                <div class="w-24 h-12 bg-gray-200 rounded-lg flex items-center justify-center">
                    <span class="text-gray-500 font-bold text-xs">AWS</span>
                </div>
                <div class="w-24 h-12 bg-gray-200 rounded-lg flex items-center justify-center">
                    <span class="text-gray-500 font-bold text-xs">Cloudflare</span>
                </div>
                <div class="w-24 h-12 bg-gray-200 rounded-lg flex items-center justify-center">
                    <span class="text-gray-500 font-bold text-xs">Microsoft</span>
                </div>
                <div class="w-24 h-12 bg-gray-200 rounded-lg flex items-center justify-center">
                    <span class="text-gray-500 font-bold text-xs">Google</span>
                </div>
            </div>
        </div>
    </div>
</section>
