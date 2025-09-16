@props([
    'integrations' => [],
    'title' => 'Integraciones Poderosas',
    'subtitle' => 'Conecta con las herramientas que ya usas para maximizar tu productividad'
])

<section class="py-24 bg-white relative overflow-hidden">
    <!-- Background patterns -->
    <div class="absolute inset-0 overflow-hidden">
        <div class="absolute -top-24 -left-24 w-96 h-96 bg-blue-100 rounded-full opacity-20 blur-3xl"></div>
        <div class="absolute -bottom-24 -right-24 w-96 h-96 bg-purple-100 rounded-full opacity-20 blur-3xl"></div>
    </div>

    <div class="container mx-auto px-6 relative z-10">
        <div class="text-center mb-16">
            <div class="inline-flex items-center px-4 py-2 rounded-full bg-blue-50 text-blue-600 font-medium mb-4">
                <i class="fas fa-plug mr-2"></i>
                +100 integraciones disponibles
            </div>
            <h2 class="text-4xl md:text-5xl font-bold mb-6 bg-gradient-to-r from-gray-900 to-gray-600 bg-clip-text text-transparent">
                {{ $title }}
            </h2>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                {{ $subtitle }}
            </p>
        </div>
        
        <!-- Integration Categories -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-16">
            <!-- Productivity -->
            <div class="bg-gradient-to-br from-blue-50 to-indigo-50 p-8 rounded-3xl border border-blue-100 group hover:shadow-xl transition-all duration-300">
                <div class="w-16 h-16 rounded-2xl bg-blue-500 flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                    <i class="fas fa-rocket text-2xl text-white"></i>
                </div>
                <h3 class="text-2xl font-bold mb-4 text-gray-900">Productividad</h3>
                <p class="text-gray-600 mb-6">Conecta con Slack, Microsoft Teams, Google Workspace y más</p>
                <div class="grid grid-cols-4 gap-3">
                    <div class="w-12 h-12 bg-white rounded-lg shadow-sm flex items-center justify-center group-hover:scale-105 transition-transform duration-200">
                        <span class="text-xs font-bold text-gray-500">Slack</span>
                    </div>
                    <div class="w-12 h-12 bg-white rounded-lg shadow-sm flex items-center justify-center group-hover:scale-105 transition-transform duration-200">
                        <span class="text-xs font-bold text-gray-500">Teams</span>
                    </div>
                    <div class="w-12 h-12 bg-white rounded-lg shadow-sm flex items-center justify-center group-hover:scale-105 transition-transform duration-200">
                        <span class="text-xs font-bold text-gray-500">Gmail</span>
                    </div>
                    <div class="w-12 h-12 bg-white rounded-lg shadow-sm flex items-center justify-center group-hover:scale-105 transition-transform duration-200">
                        <span class="text-xs font-bold text-blue-500">+12</span>
                    </div>
                </div>
            </div>
            
            <!-- Accounting -->
            <div class="bg-gradient-to-br from-green-50 to-emerald-50 p-8 rounded-3xl border border-green-100 group hover:shadow-xl transition-all duration-300">
                <div class="w-16 h-16 rounded-2xl bg-green-500 flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                    <i class="fas fa-calculator text-2xl text-white"></i>
                </div>
                <h3 class="text-2xl font-bold mb-4 text-gray-900">Contabilidad</h3>
                <p class="text-gray-600 mb-6">Sincroniza con QuickBooks, SAP, Xero y sistemas ERP</p>
                <div class="grid grid-cols-4 gap-3">
                    <div class="w-12 h-12 bg-white rounded-lg shadow-sm flex items-center justify-center group-hover:scale-105 transition-transform duration-200">
                        <span class="text-xs font-bold text-gray-500">SAP</span>
                    </div>
                    <div class="w-12 h-12 bg-white rounded-lg shadow-sm flex items-center justify-center group-hover:scale-105 transition-transform duration-200">
                        <span class="text-xs font-bold text-gray-500">QB</span>
                    </div>
                    <div class="w-12 h-12 bg-white rounded-lg shadow-sm flex items-center justify-center group-hover:scale-105 transition-transform duration-200">
                        <span class="text-xs font-bold text-gray-500">Xero</span>
                    </div>
                    <div class="w-12 h-12 bg-white rounded-lg shadow-sm flex items-center justify-center group-hover:scale-105 transition-transform duration-200">
                        <span class="text-xs font-bold text-green-500">+8</span>
                    </div>
                </div>
            </div>
            
            <!-- Recruitment -->
            <div class="bg-gradient-to-br from-purple-50 to-pink-50 p-8 rounded-3xl border border-purple-100 group hover:shadow-xl transition-all duration-300">
                <div class="w-16 h-16 rounded-2xl bg-purple-500 flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                    <i class="fas fa-users text-2xl text-white"></i>
                </div>
                <h3 class="text-2xl font-bold mb-4 text-gray-900">Reclutamiento</h3>
                <p class="text-gray-600 mb-6">Integra con LinkedIn, Indeed, ZonaTalento y job boards</p>
                <div class="grid grid-cols-4 gap-3">
                    <div class="w-12 h-12 bg-white rounded-lg shadow-sm flex items-center justify-center group-hover:scale-105 transition-transform duration-200">
                        <span class="text-xs font-bold text-gray-500">LI</span>
                    </div>
                    <div class="w-12 h-12 bg-white rounded-lg shadow-sm flex items-center justify-center group-hover:scale-105 transition-transform duration-200">
                        <span class="text-xs font-bold text-gray-500">ZT</span>
                    </div>
                    <div class="w-12 h-12 bg-white rounded-lg shadow-sm flex items-center justify-center group-hover:scale-105 transition-transform duration-200">
                        <span class="text-xs font-bold text-gray-500">IDC</span>
                    </div>
                    <div class="w-12 h-12 bg-white rounded-lg shadow-sm flex items-center justify-center group-hover:scale-105 transition-transform duration-200">
                        <span class="text-xs font-bold text-purple-500">+15</span>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- API Section -->
        <div class="bg-gradient-to-r from-gray-900 to-gray-800 rounded-3xl p-12 text-white">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <!-- Left content -->
                <div>
                    <div class="inline-flex items-center px-4 py-2 rounded-full bg-white/10 backdrop-blur-sm border border-white/20 mb-6">
                        <i class="fas fa-code text-blue-400 mr-2"></i>
                        <span class="text-white/90 text-sm font-medium">API REST Completa</span>
                    </div>
                    <h3 class="text-3xl font-bold mb-6">¿Necesitas algo personalizado?</h3>
                    <p class="text-white/80 text-lg mb-8 leading-relaxed">
                        Nuestra API REST te permite crear integraciones personalizadas y automatizar cualquier flujo de trabajo. 
                        Documentación completa, SDKs en múltiples lenguajes y soporte técnico especializado.
                    </p>
                    
                    <div class="space-y-4 mb-8">
                        <div class="flex items-center">
                            <i class="fas fa-check text-green-400 mr-3"></i>
                            <span>Documentación interactiva con Swagger</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-check text-green-400 mr-3"></i>
                            <span>SDKs para Python, PHP, Node.js y más</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-check text-green-400 mr-3"></i>
                            <span>Webhooks en tiempo real</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-check text-green-400 mr-3"></i>
                            <span>Rate limiting y autenticación OAuth 2.0</span>
                        </div>
                    </div>
                    
                    <div class="flex space-x-4">
                        <a href="#" class="inline-flex items-center px-6 py-3 bg-white text-gray-900 font-semibold rounded-xl hover:bg-gray-100 transition-colors duration-200">
                            <i class="fas fa-book mr-2"></i>
                            Ver Documentación
                        </a>
                        <a href="#" class="inline-flex items-center px-6 py-3 border border-white/30 text-white font-semibold rounded-xl hover:bg-white/10 transition-colors duration-200">
                            <i class="fas fa-download mr-2"></i>
                            Descargar SDK
                        </a>
                    </div>
                </div>
                
                <!-- Right side - Code example -->
                <div class="relative">
                    <div class="bg-black/50 rounded-2xl p-6 backdrop-blur-sm border border-white/10">
                        <div class="flex items-center justify-between mb-4">
                            <span class="text-white/70 text-sm font-mono">POST /api/v1/employees</span>
                            <div class="flex space-x-2">
                                <div class="w-3 h-3 rounded-full bg-red-400"></div>
                                <div class="w-3 h-3 rounded-full bg-yellow-400"></div>
                                <div class="w-3 h-3 rounded-full bg-green-400"></div>
                            </div>
                        </div>
                        <pre class="text-green-400 text-sm font-mono leading-relaxed"><code>{
  "name": "Juan Pérez",
  "email": "juan@empresa.com",
  "position": "Desarrollador",
  "department_id": 5,
  "start_date": "2024-01-15"
}</code></pre>
                        <div class="mt-4 pt-4 border-t border-white/10">
                            <span class="text-white/70 text-xs font-mono">Response: 201 Created</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Popular integrations grid -->
        <div class="mt-16">
            <h3 class="text-2xl font-bold text-center mb-8 text-gray-900">Integraciones más populares</h3>
            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-6">
                @forelse($integrations as $integration)
                <div class="bg-white p-6 rounded-2xl shadow-lg border border-gray-100 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 group">
                    <div class="w-12 h-12 rounded-xl bg-{{ $integration['color'] ?? 'gray' }}-100 flex items-center justify-center mx-auto mb-3 group-hover:scale-110 transition-transform duration-300">
                        <i class="{{ $integration['icon'] ?? 'fas fa-plug' }} text-{{ $integration['color'] ?? 'gray' }}-600"></i>
                    </div>
                    <h4 class="text-sm font-semibold text-center text-gray-900">{{ $integration['name'] ?? 'Integración' }}</h4>
                </div>
                @empty
                <!-- Default integrations -->
                <div class="bg-white p-6 rounded-2xl shadow-lg border border-gray-100 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 group">
                    <div class="w-12 h-12 rounded-xl bg-blue-100 flex items-center justify-center mx-auto mb-3 group-hover:scale-110 transition-transform duration-300">
                        <i class="fab fa-slack text-blue-600"></i>
                    </div>
                    <h4 class="text-sm font-semibold text-center text-gray-900">Slack</h4>
                </div>
                
                <div class="bg-white p-6 rounded-2xl shadow-lg border border-gray-100 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 group">
                    <div class="w-12 h-12 rounded-xl bg-purple-100 flex items-center justify-center mx-auto mb-3 group-hover:scale-110 transition-transform duration-300">
                        <i class="fab fa-microsoft text-purple-600"></i>
                    </div>
                    <h4 class="text-sm font-semibold text-center text-gray-900">Teams</h4>
                </div>
                
                <div class="bg-white p-6 rounded-2xl shadow-lg border border-gray-100 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 group">
                    <div class="w-12 h-12 rounded-xl bg-red-100 flex items-center justify-center mx-auto mb-3 group-hover:scale-110 transition-transform duration-300">
                        <i class="fab fa-google text-red-600"></i>
                    </div>
                    <h4 class="text-sm font-semibold text-center text-gray-900">Gmail</h4>
                </div>
                
                <div class="bg-white p-6 rounded-2xl shadow-lg border border-gray-100 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 group">
                    <div class="w-12 h-12 rounded-xl bg-blue-100 flex items-center justify-center mx-auto mb-3 group-hover:scale-110 transition-transform duration-300">
                        <i class="fab fa-linkedin text-blue-600"></i>
                    </div>
                    <h4 class="text-sm font-semibold text-center text-gray-900">LinkedIn</h4>
                </div>
                
                <div class="bg-white p-6 rounded-2xl shadow-lg border border-gray-100 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 group">
                    <div class="w-12 h-12 rounded-xl bg-green-100 flex items-center justify-center mx-auto mb-3 group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-file-excel text-green-600"></i>
                    </div>
                    <h4 class="text-sm font-semibold text-center text-gray-900">Excel</h4>
                </div>
                
                <div class="bg-white p-6 rounded-2xl shadow-lg border border-gray-100 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 group">
                    <div class="w-12 h-12 rounded-xl bg-gray-100 flex items-center justify-center mx-auto mb-3 group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-plus text-gray-600"></i>
                    </div>
                    <h4 class="text-sm font-semibold text-center text-gray-900">Ver todas</h4>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</section>
