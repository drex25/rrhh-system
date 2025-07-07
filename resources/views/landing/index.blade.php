@extends('layouts.public')

@section('title', 'Soluciones Integrales de RRHH')

@push('styles')
<style>
    html, body {
        max-width: 100vw;
        overflow-x: hidden;
    }
    
    .container {
        max-width: 1200px;
        margin-left: auto;
        margin-right: auto;
        width: 100%;
        padding-left: 1rem;
        padding-right: 1rem;
        box-sizing: border-box;
    }

    /* Modern animations and effects */
    .animate-float { animation: float 6s ease-in-out infinite; }
    .animate-fade-in { animation: fadeIn 1s ease-out forwards; }
    .animate-slide-up { animation: slideUp 0.8s ease-out forwards; }
    .animate-slide-in-right { animation: slideInRight 0.8s ease-out forwards; }
    .animate-scale { animation: scale 0.5s ease-out forwards; }
    .animate-pulse { animation: pulse 2s infinite; }
    
    @keyframes float { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-20px); } }
    @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
    @keyframes slideUp { from { opacity: 0; transform: translateY(30px); } to { opacity: 1; transform: translateY(0); } }
    @keyframes slideInRight { from { opacity: 0; transform: translateX(50px); } to { opacity: 1; transform: translateX(0); } }
    @keyframes scale { from { transform: scale(0.8); opacity: 0; } to { transform: scale(1); opacity: 1; } }
    @keyframes pulse { 0%, 100% { transform: scale(1); } 50% { transform: scale(1.05); } }
    
    /* Modern design elements */
    .glass-card {
        background: rgba(255, 255, 255, 0.05);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 24px;
    }
    
    .gradient-text {
        background: linear-gradient(90deg, #3B82F6, #8B5CF6);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }
    
    .gradient-bg {
        background: linear-gradient(135deg, #3B82F6, #8B5CF6);
    }
    
    .feature-card {
        transition: all 0.3s ease;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
    }
    
    .feature-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    }
    
    .btn-primary {
        background: linear-gradient(90deg, #3B82F6, #8B5CF6);
        color: white;
        padding: 14px 32px;
        border-radius: 50px;
        font-weight: 600;
        transition: all 0.3s ease;
        border: none;
        box-shadow: 0 4px 15px rgba(59, 130, 246, 0.3);
    }
    
    .btn-primary:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(59, 130, 246, 0.4);
    }
    
    .btn-secondary {
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
        color: white;
        padding: 14px 32px;
        border-radius: 50px;
        font-weight: 600;
        transition: all 0.3s ease;
        border: 1px solid rgba(255, 255, 255, 0.2);
    }
    
    .btn-secondary:hover {
        background: rgba(255, 255, 255, 0.2);
        transform: translateY(-3px);
    }
    
    /* Responsive adjustments */
    @media (max-width: 1024px) {
        .hero-image { max-width: 400px; }
    }
    
    @media (max-width: 768px) {
        .hero-image { max-width: 300px; }
        .hero-heading { font-size: 2.5rem; }
    }
    
    @media (max-width: 640px) {
        .hero-image { display: none; }
        .hero-heading { font-size: 2rem; }
    }
</style>
@endpush

@section('main-classes', 'p-0 m-0 min-h-screen')

@section('content')
<!-- Hero Section - Modern and Immersive -->
<section class="relative min-h-screen flex items-center justify-center overflow-hidden bg-gradient-to-br from-indigo-900 via-blue-900 to-purple-900">
    <!-- Animated background elements -->
    <div class="absolute inset-0 overflow-hidden">
        <div class="absolute top-0 left-0 w-full h-full">
            <!-- Animated gradient blobs -->
            <div class="absolute top-1/4 left-1/4 w-96 h-96 bg-blue-500 rounded-full mix-blend-multiply filter blur-[128px] opacity-30 animate-float"></div>
            <div class="absolute bottom-1/4 right-1/4 w-96 h-96 bg-purple-500 rounded-full mix-blend-multiply filter blur-[128px] opacity-30 animate-float" style="animation-delay: -3s"></div>
            <div class="absolute top-1/2 right-1/3 w-96 h-96 bg-pink-500 rounded-full mix-blend-multiply filter blur-[128px] opacity-20 animate-float" style="animation-delay: -5s"></div>
        </div>
        
        <!-- Grid pattern overlay -->
        <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNjAiIGhlaWdodD0iNjAiIHZpZXdCb3g9IjAgMCA2MCA2MCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48ZyBmaWxsPSJub25lIiBmaWxsLXJ1bGU9ImV2ZW5vZGQiPjxnIGZpbGw9IiNmZmZmZmYiIGZpbGwtb3BhY2l0eT0iMC4wNSI+PHBhdGggZD0iTTAgMGg2MHY2MEgweiIvPjwvZz48L2c+PC9zdmc+')] bg-[30px_30px]"></div>
    </div>
    
    <div class="container mx-auto px-6 relative z-10">
        <div class="flex flex-col lg:flex-row items-center justify-between gap-12">
            <!-- Left content -->
            <div class="w-full lg:w-1/2 text-center lg:text-left">
                <div class="inline-flex items-center px-4 py-2 rounded-full bg-white/10 backdrop-blur-md border border-white/20 mb-6 animate-fade-in">
                    <span class="w-3 h-3 bg-green-400 rounded-full mr-2 animate-pulse"></span>
                    <span class="text-white/90 text-sm font-medium">Plataforma Integral de RRHH</span>
                </div>
                
                <h1 class="hero-heading text-5xl md:text-6xl lg:text-7xl font-extrabold mb-6 text-white leading-tight animate-slide-up" style="animation-delay: 0.2s">
                    Potencia tu <span class="gradient-text">Capital Humano</span>
                </h1>
                
                <p class="text-xl text-white/80 leading-relaxed mb-10 max-w-2xl animate-slide-up" style="animation-delay: 0.4s">
                    Transforma la gestión de talento con nuestra plataforma integral. Automatiza procesos, 
                    mejora la experiencia de tus colaboradores y toma decisiones basadas en datos.
                </p>
                
                <div class="flex flex-col sm:flex-row gap-4 animate-slide-up" style="animation-delay: 0.6s">
                    <a href="{{ route('login') }}" class="btn-primary">
                        <span class="flex items-center justify-center">
                            <i class="fas fa-rocket mr-2"></i>
                            Comenzar ahora
                        </span>
                    </a>
                    <a href="#contact" class="btn-secondary">
                        <span class="flex items-center justify-center">
                            <i class="fas fa-headset mr-2"></i>
                            Solicitar demo
                        </span>
                    </a>
                </div>
                
                <!-- Trust indicators -->
                <div class="mt-12 grid grid-cols-3 gap-4 animate-slide-up" style="animation-delay: 0.8s">
                    <div class="flex flex-col items-center lg:items-start">
                        <div class="text-4xl font-bold text-white mb-1">98%</div>
                        <div class="text-sm text-white/70">Satisfacción</div>
                    </div>
                    <div class="flex flex-col items-center lg:items-start">
                        <div class="text-4xl font-bold text-white mb-1">500+</div>
                        <div class="text-sm text-white/70">Empresas</div>
                    </div>
                    <div class="flex flex-col items-center lg:items-start">
                        <div class="text-4xl font-bold text-white mb-1">24/7</div>
                        <div class="text-sm text-white/70">Soporte</div>
                    </div>
                </div>
            </div>
            
            <!-- Right content - Hero image -->
            <div class="w-full lg:w-1/2 flex justify-center lg:justify-end animate-slide-in-right">
                <img src="https://cdn.pixabay.com/photo/2022/05/08/03/10/dashboard-7181959_1280.png" alt="HR Dashboard" class="hero-image w-full max-w-xl rounded-2xl shadow-2xl border border-white/10">
            </div>
        </div>
    </div>
    
    <!-- Wave divider -->
    <div class="absolute bottom-0 left-0 w-full overflow-hidden leading-none">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none" class="w-full h-[100px] text-white">
            <path d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V120H0V27.35A600.21,600.21,0,0,0,321.39,56.44Z" fill="currentColor"></path>
        </svg>
    </div>
</section>

<!-- Features Section - Modern Card Layout -->
<section class="py-24 bg-white">
    <div class="container mx-auto px-6">
        <div class="text-center mb-16">
            <h2 class="text-4xl md:text-5xl font-bold mb-6" data-aos="fade-up">Soluciones Completas</h2>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto" data-aos="fade-up" data-aos-delay="100">
                Una plataforma integral diseñada para optimizar cada aspecto de la gestión de recursos humanos
            </p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- Feature 1 -->
            <div class="feature-card bg-white p-8" data-aos="fade-up" data-aos-delay="100">
                <div class="w-16 h-16 rounded-2xl bg-blue-100 flex items-center justify-center mb-6">
                    <i class="fas fa-user-plus text-2xl text-blue-600"></i>
                </div>
                <h3 class="text-2xl font-bold mb-4">Reclutamiento</h3>
                <p class="text-gray-600 mb-6">Optimiza tu proceso de selección con un sistema completo de gestión de candidatos, entrevistas y evaluaciones.</p>
                <a href="#" class="text-blue-600 font-semibold flex items-center">
                    Conocer más <i class="fas fa-arrow-right ml-2"></i>
                </a>
            </div>
            
            <!-- Feature 2 -->
            <div class="feature-card bg-white p-8" data-aos="fade-up" data-aos-delay="200">
                <div class="w-16 h-16 rounded-2xl bg-purple-100 flex items-center justify-center mb-6">
                    <i class="fas fa-folder-open text-2xl text-purple-600"></i>
                </div>
                <h3 class="text-2xl font-bold mb-4">Legajos Digitales</h3>
                <p class="text-gray-600 mb-6">Centraliza toda la información de tus colaboradores en un solo lugar, accesible y seguro.</p>
                <a href="#" class="text-purple-600 font-semibold flex items-center">
                    Conocer más <i class="fas fa-arrow-right ml-2"></i>
                </a>
            </div>
            
            <!-- Feature 3 -->
            <div class="feature-card bg-white p-8" data-aos="fade-up" data-aos-delay="300">
                <div class="w-16 h-16 rounded-2xl bg-pink-100 flex items-center justify-center mb-6">
                    <i class="fas fa-calendar-check text-2xl text-pink-600"></i>
                </div>
                <h3 class="text-2xl font-bold mb-4">Gestión de Licencias</h3>
                <p class="text-gray-600 mb-6">Administra vacaciones, ausencias y permisos de manera eficiente y transparente para todo tu equipo.</p>
                <a href="#" class="text-pink-600 font-semibold flex items-center">
                    Conocer más <i class="fas fa-arrow-right ml-2"></i>
                </a>
            </div>
            
            <!-- Feature 4 -->
            <div class="feature-card bg-white p-8" data-aos="fade-up" data-aos-delay="400">
                <div class="w-16 h-16 rounded-2xl bg-green-100 flex items-center justify-center mb-6">
                    <i class="fas fa-chart-line text-2xl text-green-600"></i>
                </div>
                <h3 class="text-2xl font-bold mb-4">Evaluaciones</h3>
                <p class="text-gray-600 mb-6">Implementa ciclos de feedback continuo y evaluaciones de desempeño para potenciar el desarrollo profesional.</p>
                <a href="#" class="text-green-600 font-semibold flex items-center">
                    Conocer más <i class="fas fa-arrow-right ml-2"></i>
                </a>
            </div>
            
            <!-- Feature 5 -->
            <div class="feature-card bg-white p-8" data-aos="fade-up" data-aos-delay="500">
                <div class="w-16 h-16 rounded-2xl bg-yellow-100 flex items-center justify-center mb-6">
                    <i class="fas fa-money-check-alt text-2xl text-yellow-600"></i>
                </div>
                <h3 class="text-2xl font-bold mb-4">Nómina</h3>
                <p class="text-gray-600 mb-6">Automatiza el cálculo y generación de recibos de sueldo, integrando todas las variables salariales.</p>
                <a href="#" class="text-yellow-600 font-semibold flex items-center">
                    Conocer más <i class="fas fa-arrow-right ml-2"></i>
                </a>
            </div>
            
            <!-- Feature 6 -->
            <div class="feature-card bg-white p-8" data-aos="fade-up" data-aos-delay="600">
                <div class="w-16 h-16 rounded-2xl bg-indigo-100 flex items-center justify-center mb-6">
                    <i class="fas fa-user-circle text-2xl text-indigo-600"></i>
                </div>
                <h3 class="text-2xl font-bold mb-4">Portal del Empleado</h3>
                <p class="text-gray-600 mb-6">Empodera a tus colaboradores con acceso a sus recibos, solicitudes y gestiones personales.</p>
                <a href="#" class="text-indigo-600 font-semibold flex items-center">
                    Conocer más <i class="fas fa-arrow-right ml-2"></i>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Benefits Section - With Image -->
<section class="py-24 bg-gray-50">
    <div class="container mx-auto px-6">
        <div class="flex flex-col lg:flex-row items-center gap-16">
            <!-- Left side image -->
            <div class="w-full lg:w-1/2" data-aos="fade-right">
                <img src="https://cdn.pixabay.com/photo/2017/07/31/11/21/people-2557396_1280.jpg" alt="Team Collaboration" class="rounded-3xl shadow-2xl w-full">
            </div>
            
            <!-- Right side content -->
            <div class="w-full lg:w-1/2" data-aos="fade-left">
                <h2 class="text-4xl font-bold mb-8">Beneficios que <span class="gradient-text">transforman</span></h2>
                
                <div class="space-y-8">
                    <!-- Benefit 1 -->
                    <div class="flex gap-4">
                        <div class="flex-shrink-0 w-12 h-12 rounded-xl bg-blue-100 flex items-center justify-center">
                            <i class="fas fa-tachometer-alt text-blue-600"></i>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold mb-2">Eficiencia Operativa</h3>
                            <p class="text-gray-600">Reduce hasta un 70% el tiempo dedicado a tareas administrativas con nuestros procesos automatizados.</p>
                        </div>
                    </div>
                    
                    <!-- Benefit 2 -->
                    <div class="flex gap-4">
                        <div class="flex-shrink-0 w-12 h-12 rounded-xl bg-purple-100 flex items-center justify-center">
                            <i class="fas fa-chart-pie text-purple-600"></i>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold mb-2">Decisiones Estratégicas</h3>
                            <p class="text-gray-600">Accede a datos en tiempo real y análisis avanzados para tomar decisiones informadas sobre tu capital humano.</p>
                        </div>
                    </div>
                    
                    <!-- Benefit 3 -->
                    <div class="flex gap-4">
                        <div class="flex-shrink-0 w-12 h-12 rounded-xl bg-green-100 flex items-center justify-center">
                            <i class="fas fa-users text-green-600"></i>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold mb-2">Experiencia Mejorada</h3>
                            <p class="text-gray-600">Ofrece a tus colaboradores una experiencia digital intuitiva que aumenta su satisfacción y compromiso.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Testimonials Section -->
<section class="py-24 bg-white">
    <div class="container mx-auto px-6">
        <div class="text-center mb-16">
            <h2 class="text-4xl font-bold mb-6" data-aos="fade-up">Lo que dicen nuestros clientes</h2>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto" data-aos="fade-up" data-aos-delay="100">
                Empresas de todos los tamaños confían en nuestra plataforma para transformar su gestión de RRHH
            </p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Testimonial 1 -->
            <div class="bg-gray-50 p-8 rounded-3xl shadow-lg" data-aos="fade-up" data-aos-delay="100">
                <div class="flex items-center mb-6">
                    <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center mr-4">
                        <span class="text-blue-600 font-bold text-xl">M</span>
                    </div>
                    <div>
                        <h4 class="font-bold">María Rodríguez</h4>
                        <p class="text-sm text-gray-500">Directora de RRHH, TechCorp</p>
                    </div>
                </div>
                <p class="text-gray-600 italic">"Implementamos la plataforma hace 6 meses y ha transformado completamente nuestra gestión de personal. Los procesos son más ágiles y nuestro equipo está más satisfecho."</p>
                <div class="mt-4 flex text-yellow-400">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                </div>
            </div>
            
            <!-- Testimonial 2 -->
            <div class="bg-gray-50 p-8 rounded-3xl shadow-lg" data-aos="fade-up" data-aos-delay="200">
                <div class="flex items-center mb-6">
                    <div class="w-12 h-12 rounded-full bg-purple-100 flex items-center justify-center mr-4">
                        <span class="text-purple-600 font-bold text-xl">J</span>
                    </div>
                    <div>
                        <h4 class="font-bold">Juan Martínez</h4>
                        <p class="text-sm text-gray-500">CEO, Innovatech</p>
                    </div>
                </div>
                <p class="text-gray-600 italic">"La implementación fue rápida y el soporte es excepcional. Hemos reducido costos administrativos y mejorado la experiencia de nuestros colaboradores."</p>
                <div class="mt-4 flex text-yellow-400">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                </div>
            </div>
            
            <!-- Testimonial 3 -->
            <div class="bg-gray-50 p-8 rounded-3xl shadow-lg" data-aos="fade-up" data-aos-delay="300">
                <div class="flex items-center mb-6">
                    <div class="w-12 h-12 rounded-full bg-green-100 flex items-center justify-center mr-4">
                        <span class="text-green-600 font-bold text-xl">L</span>
                    </div>
                    <div>
                        <h4 class="font-bold">Laura Sánchez</h4>
                        <p class="text-sm text-gray-500">Gerente de RRHH, GlobalServices</p>
                    </div>
                </div>
                <p class="text-gray-600 italic">"Los reportes y análisis nos han permitido tomar decisiones estratégicas basadas en datos reales. La plataforma es intuitiva y nuestro equipo la adoptó rápidamente."</p>
                <div class="mt-4 flex text-yellow-400">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star-half-alt"></i>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Contact Section -->
<section id="contact" class="py-24 bg-gradient-to-br from-indigo-900 via-blue-900 to-purple-900 relative overflow-hidden">
    <!-- Background elements -->
    <div class="absolute inset-0 overflow-hidden">
        <div class="absolute top-0 left-0 w-full h-full">
            <div class="absolute top-1/4 right-1/4 w-96 h-96 bg-blue-500 rounded-full mix-blend-multiply filter blur-[128px] opacity-30 animate-float"></div>
            <div class="absolute bottom-1/3 left-1/3 w-96 h-96 bg-purple-500 rounded-full mix-blend-multiply filter blur-[128px] opacity-30 animate-float" style="animation-delay: -4s"></div>
        </div>
        <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNjAiIGhlaWdodD0iNjAiIHZpZXdCb3g9IjAgMCA2MCA2MCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48ZyBmaWxsPSJub25lIiBmaWxsLXJ1bGU9ImV2ZW5vZGQiPjxnIGZpbGw9IiNmZmZmZmYiIGZpbGwtb3BhY2l0eT0iMC4wNSI+PHBhdGggZD0iTTAgMGg2MHY2MEgweiIvPjwvZz48L2c+PC9zdmc+')] bg-[30px_30px]"></div>
    </div>
    
    <div class="container mx-auto px-6 relative z-10">
        <div class="max-w-4xl mx-auto">
            <div class="text-center mb-12">
                <h2 class="text-4xl md:text-5xl font-bold text-white mb-6" data-aos="fade-up">¿Listo para transformar tu gestión de RRHH?</h2>
                <p class="text-xl text-white/80 mb-8" data-aos="fade-up" data-aos-delay="100">
                    Solicita una demostración personalizada y descubre cómo podemos ayudarte
                </p>
            </div>
            
            <div class="bg-white/10 backdrop-blur-md rounded-3xl p-8 border border-white/20" data-aos="fade-up" data-aos-delay="200">
                <form class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="name" class="block text-white/80 text-sm font-medium mb-2">Nombre completo</label>
                        <input type="text" id="name" name="name" class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white placeholder-white/50 focus:outline-none focus:ring-2 focus:ring-white/30" placeholder="Tu nombre">
                    </div>
                    
                    <div>
                        <label for="email" class="block text-white/80 text-sm font-medium mb-2">Correo electrónico</label>
                        <input type="email" id="email" name="email" class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white placeholder-white/50 focus:outline-none focus:ring-2 focus:ring-white/30" placeholder="tu@email.com">
                    </div>
                    
                    <div>
                        <label for="company" class="block text-white/80 text-sm font-medium mb-2">Empresa</label>
                        <input type="text" id="company" name="company" class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white placeholder-white/50 focus:outline-none focus:ring-2 focus:ring-white/30" placeholder="Nombre de tu empresa">
                    </div>
                    
                    <div>
                        <label for="phone" class="block text-white/80 text-sm font-medium mb-2">Teléfono</label>
                        <input type="tel" id="phone" name="phone" class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white placeholder-white/50 focus:outline-none focus:ring-2 focus:ring-white/30" placeholder="Tu número de contacto">
                    </div>
                    
                    <div class="md:col-span-2">
                        <label for="message" class="block text-white/80 text-sm font-medium mb-2">Mensaje</label>
                        <textarea id="message" name="message" rows="4" class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white placeholder-white/50 focus:outline-none focus:ring-2 focus:ring-white/30" placeholder="¿Cómo podemos ayudarte?"></textarea>
                    </div>
                    
                    <div class="md:col-span-2 flex justify-center">
                        <button type="submit" class="btn-primary w-full md:w-auto">
                            <span class="flex items-center justify-center">
                                <i class="fas fa-paper-plane mr-2"></i>
                                Solicitar demostración
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

@push('scripts')
<script>
// Counter animation
document.addEventListener('DOMContentLoaded', function() {
    const counters = document.querySelectorAll('.text-4xl.font-bold');
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const target = entry.target;
                const countTo = parseInt(target.innerText.replace(/\D/g, ''));
                let count = 0;
                const interval = setInterval(() => {
                    count += Math.ceil(countTo / 30);
                    if (count >= countTo) {
                        target.innerText = target.innerText.includes('+') ? 
                            countTo + '+' : 
                            target.innerText.includes('%') ? 
                                countTo + '%' : 
                                countTo;
                        clearInterval(interval);
                    } else {
                        target.innerText = target.innerText.includes('+') ? 
                            count + '+' : 
                            target.innerText.includes('%') ? 
                                count + '%' : 
                                count;
                    }
                }, 30);
                observer.unobserve(target);
            }
        });
    }, { threshold: 0.5 });
    
    counters.forEach(counter => {
        observer.observe(counter);
    });
});
</script>
@endpush
@endsection