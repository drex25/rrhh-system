@extends('layouts.public')

@section('title', 'Transforma la Gestión de RRHH')

@push('styles')
<style>
    html, body {
        max-width: 100vw;
        overflow-x: hidden;
    }
    body, main {
        background: none !important;
        padding-top: 0 !important;
        max-width: 100vw;
        overflow-x: hidden;
    }
    .hero-gradient, .hero-pattern, .hero-particles, .custom-shape-divider {
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
    @media (max-width: 1024px) {
        .hero-image {
            max-width: 350px;
        }
        .container {
            padding-left: 0.5rem;
            padding-right: 0.5rem;
        }
    }
    @media (max-width: 768px) {
        .hero-image {
            display: none !important;
        }
        .container {
            padding-left: 0.25rem;
            padding-right: 0.25rem;
        }
        .hero-gradient, .hero-pattern, .hero-particles, .custom-shape-divider {
            min-width: 100vw;
        }
    }
    
    .animate-float {
        animation: float 6s ease-in-out infinite;
    }
    
    @keyframes float {
        0% { transform: translateY(0px); }
        50% { transform: translateY(-20px); }
        100% { transform: translateY(0px); }
    }

    .gradient-text {
        background: linear-gradient(45deg, #3B82F6, #8B5CF6);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .hover-scale {
        transition: all 0.3s ease;
    }

    .hover-scale:hover {
        transform: scale(1.05);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    }

    .glass-effect {
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .feature-card {
        position: relative;
        overflow: hidden;
        transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .feature-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(45deg, transparent, rgba(255, 255, 255, 0.1), transparent);
        transform: translateX(-100%);
        transition: 0.5s;
    }

    .feature-card:hover::before {
        transform: translateX(100%);
    }

    .feature-card:hover {
        transform: translateY(-10px) scale(1.02);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    }

    .stats-card {
        position: relative;
        overflow: hidden;
        transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .stats-card::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        height: 3px;
        background: linear-gradient(90deg, #3B82F6, #8B5CF6);
        transform: scaleX(0);
        transform-origin: left;
        transition: transform 0.5s ease;
    }

    .stats-card:hover::after {
        transform: scaleX(1);
    }

    .stats-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    }

    .scroll-reveal {
        opacity: 0;
        transform: translateY(30px);
        transition: all 0.8s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .scroll-reveal.active {
        opacity: 1;
        transform: translateY(0);
    }

    .scroll-reveal-left {
        opacity: 0;
        transform: translateX(-50px);
        transition: all 0.8s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .scroll-reveal-left.active {
        opacity: 1;
        transform: translateX(0);
    }

    .scroll-reveal-right {
        opacity: 0;
        transform: translateX(50px);
        transition: all 0.8s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .scroll-reveal-right.active {
        opacity: 1;
        transform: translateX(0);
    }

    .custom-shape-divider {
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        overflow: hidden;
        line-height: 0;
    }

    .custom-shape-divider svg {
        position: relative;
        display: block;
        width: calc(100% + 1.3px);
        height: 150px;
    }

    .custom-shape-divider .shape-fill {
        fill: #FFFFFF;
    }

    .benefit-card {
        transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .benefit-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    }

    .parallax-bg {
        background-attachment: fixed;
        background-position: center;
        background-repeat: no-repeat;
        background-size: cover;
    }

    .text-gradient {
        background: linear-gradient(45deg, #3B82F6, #8B5CF6);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .animate-pulse-slow {
        animation: pulse 3s cubic-bezier(0.4, 0, 0.6, 1) infinite;
    }

    @keyframes pulse {
        0%, 100% {
            opacity: 1;
        }
        50% {
            opacity: .5;
        }
    }

    .animate-bounce-slow {
        animation: bounce 3s infinite;
    }

    @keyframes bounce {
        0%, 100% {
            transform: translateY(-5%);
            animation-timing-function: cubic-bezier(0.8, 0, 1, 1);
        }
        50% {
            transform: translateY(0);
            animation-timing-function: cubic-bezier(0, 0, 0.2, 1);
        }
    }

    .hero-particles {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        overflow: hidden;
    }

    .particle {
        position: absolute;
        width: 6px;
        height: 6px;
        background: rgba(255, 255, 255, 0.5);
        border-radius: 50%;
        animation: particle-float 15s infinite linear;
    }

    @keyframes particle-float {
        0% {
            transform: translateY(0) translateX(0);
            opacity: 0;
        }
        50% {
            opacity: 1;
        }
        100% {
            transform: translateY(-100vh) translateX(100px);
            opacity: 0;
        }
    }

    .glow {
        position: relative;
    }

    .glow::after {
        content: '';
        position: absolute;
        top: -2px;
        left: -2px;
        right: -2px;
        bottom: -2px;
        background: linear-gradient(45deg, #3B82F6, #8B5CF6, #3B82F6);
        border-radius: inherit;
        z-index: -1;
        animation: glow-animation 3s linear infinite;
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .glow:hover::after {
        opacity: 1;
    }

    @keyframes glow-animation {
        0% {
            background-position: 0% 50%;
        }
        50% {
            background-position: 100% 50%;
        }
        100% {
            background-position: 0% 50%;
        }
    }

    .hero-gradient {
        background: linear-gradient(135deg, #1a365d 0%, #2d3748 100%);
    }

    .hero-pattern {
        background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
    }

    .floating {
        animation: floating 3s ease-in-out infinite;
    }

    @keyframes floating {
        0% { transform: translateY(0px); }
        50% { transform: translateY(-20px); }
        100% { transform: translateY(0px); }
    }

    .hero-image {
        animation: float 6s ease-in-out infinite;
    }

    @keyframes float {
        0% { transform: translateY(0px) rotate(0deg); }
        50% { transform: translateY(-20px) rotate(2deg); }
        100% { transform: translateY(0px) rotate(0deg); }
    }
</style>
@endpush

@section('main-classes', 'p-0 m-0 min-h-screen')

@section('content')
<!-- HERO RRHH INTEGRAL -->
<section class="relative hero-gradient hero-pattern min-h-screen flex items-center pt-0 overflow-hidden">
    <div class="hero-particles">
        @for ($i = 0; $i < 50; $i++)
            <div class="particle" style="
                left: {{ rand(0, 100) }}%;
                top: {{ rand(0, 100) }}%;
                animation-delay: {{ rand(0, 15) }}s;
                animation-duration: {{ rand(10, 20) }}s;
            "></div>
        @endfor
    </div>
    <div class="absolute inset-0">
        <div class="absolute inset-0 bg-gradient-to-br from-blue-900/50 to-indigo-900/50"></div>
        <div class="absolute top-0 left-0 w-full h-full">
            <div class="absolute top-1/4 left-1/4 w-64 h-64 bg-blue-400 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-float"></div>
            <div class="absolute top-1/3 right-1/4 w-64 h-64 bg-purple-400 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-float" style="animation-delay: -2s"></div>
            <div class="absolute bottom-1/4 left-1/3 w-64 h-64 bg-pink-400 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-float" style="animation-delay: -4s"></div>
        </div>
    </div>
    <div class="container mx-auto px-4 relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div class="text-center lg:text-left">
                <div class="inline-block px-6 py-3 rounded-full glass-effect mb-8" data-aos="fade-up">
                    <span class="text-white/90 text-sm font-medium">Sistema Integral de RRHH</span>
                </div>
                <h1 class="text-5xl md:text-7xl font-extrabold mb-8 text-white drop-shadow-lg" data-aos="fade-up" data-aos-delay="100">
                    Transforma tu <span class="gradient-text">Gestión de RRHH</span>
                </h1>
                <p class="text-2xl mb-12 text-white/90 leading-relaxed" data-aos="fade-up" data-aos-delay="200">
                    Un sistema integral que revoluciona la gestión de recursos humanos, 
                    automatizando procesos y potenciando el talento de tu organización.
                </p>
                <div class="flex flex-col sm:flex-row gap-6 justify-center lg:justify-start items-center" data-aos="fade-up" data-aos-delay="300">
                    <a href="{{ route('login') }}" class="glow inline-block bg-gradient-to-r from-yellow-400 to-yellow-500 hover:from-yellow-500 hover:to-yellow-600 text-blue-900 px-12 py-4 rounded-full font-bold text-lg shadow-lg transition-all duration-300 transform hover:scale-105">
                        <i class="fas fa-play-circle mr-2"></i>Ver demo
                    </a>
                    <a href="#contact" class="glow inline-block glass-effect text-white px-12 py-4 rounded-full font-bold text-lg shadow-lg transition-all duration-300 transform hover:scale-105">
                        <i class="fas fa-calendar-check mr-2"></i>Solicitar demo
                    </a>
                </div>
            </div>
            <div class="hidden lg:block" data-aos="fade-left" data-aos-delay="400">
                <img src="{{ asset('images/rrhh.svg') }}" alt="HR Management" class="hero-image w-full max-w-lg mx-auto">
            </div>
        </div>
    </div>
    <div class="custom-shape-divider">
        <svg data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
            <path d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V0H0V27.35A600.21,600.21,0,0,0,321.39,56.44Z" class="shape-fill"></path>
        </svg>
    </div>
</section>

<!-- ESTADÍSTICAS -->
<section class="py-24 bg-white">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
            <div class="stats-card text-center p-8 rounded-2xl bg-white shadow-lg hover:shadow-xl transition-all duration-300" data-aos="fade-up">
                <div class="text-5xl font-bold text-blue-600 mb-3">98%</div>
                <div class="text-gray-600 font-medium">Satisfacción de usuarios</div>
            </div>
            <div class="stats-card text-center p-8 rounded-2xl bg-white shadow-lg hover:shadow-xl transition-all duration-300" data-aos="fade-up" data-aos-delay="100">
                <div class="text-5xl font-bold text-blue-600 mb-3">+500</div>
                <div class="text-gray-600 font-medium">Empresas activas</div>
            </div>
            <div class="stats-card text-center p-8 rounded-2xl bg-white shadow-lg hover:shadow-xl transition-all duration-300" data-aos="fade-up" data-aos-delay="200">
                <div class="text-5xl font-bold text-blue-600 mb-3">50k+</div>
                <div class="text-gray-600 font-medium">Empleados gestionados</div>
            </div>
            <div class="stats-card text-center p-8 rounded-2xl bg-white shadow-lg hover:shadow-xl transition-all duration-300" data-aos="fade-up" data-aos-delay="300">
                <div class="text-5xl font-bold text-blue-600 mb-3">24/7</div>
                <div class="text-gray-600 font-medium">Soporte técnico</div>
            </div>
        </div>
    </div>
</section>

<!-- MÓDULOS PRINCIPALES -->
<section class="py-24 bg-gradient-to-br from-gray-50 to-white">
    <div class="container mx-auto px-4">
        <div class="text-center mb-20">
            <span class="text-blue-600 font-semibold text-lg" data-aos="fade-up">Módulos</span>
            <h2 class="text-4xl md:text-5xl font-extrabold text-gray-900 mt-3" data-aos="fade-up" data-aos-delay="100">Sistema Integral de RRHH</h2>
            <p class="text-gray-600 mt-6 max-w-2xl mx-auto text-lg" data-aos="fade-up" data-aos-delay="200">
                Una suite completa de herramientas diseñadas para optimizar cada aspecto de la gestión de recursos humanos
            </p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-8">
            @php
                $features = [
                    ['icon' => 'user-plus', 'title' => 'Reclutamiento', 'color' => 'blue', 'description' => 'Publica vacantes, gestiona candidatos y automatiza el proceso de selección.'],
                    ['icon' => 'folder-open', 'title' => 'Legajos', 'color' => 'green', 'description' => 'Centraliza la información y documentación de cada empleado.'],
                    ['icon' => 'calendar-check', 'title' => 'Asistencias', 'color' => 'yellow', 'description' => 'Registra y controla la asistencia y puntualidad del personal.'],
                    ['icon' => 'plane-departure', 'title' => 'Licencias', 'color' => 'pink', 'description' => 'Gestiona vacaciones, ausencias y permisos de manera eficiente.'],
                    ['icon' => 'star', 'title' => 'Evaluaciones', 'color' => 'indigo', 'description' => 'Evalúa el desempeño y planifica el desarrollo de tu equipo.'],
                    ['icon' => 'chalkboard-teacher', 'title' => 'Capacitación', 'color' => 'teal', 'description' => 'Organiza y registra cursos, capacitaciones y formaciones.'],
                    ['icon' => 'file-alt', 'title' => 'Documentos', 'color' => 'orange', 'description' => 'Gestiona contratos, recibos y toda la documentación laboral.'],
                    ['icon' => 'chart-bar', 'title' => 'Reportes', 'color' => 'purple', 'description' => 'Obtén reportes y estadísticas en tiempo real de todos los procesos.'],
                    ['icon' => 'money-check-alt', 'title' => 'Nómina', 'color' => 'gray', 'description' => 'Administra sueldos, liquidaciones y recibos de sueldo.'],
                    ['icon' => 'user-circle', 'title' => 'Portal del Empleado', 'color' => 'blue', 'description' => 'Acceso para empleados a recibos, licencias y autogestión.']
                ];
            @endphp

            @foreach($features as $index => $feature)
                <div class="feature-card flex flex-col items-center text-center p-8 rounded-2xl shadow-lg hover:shadow-xl transition bg-{{ $feature['color'] }}-50" 
                     data-aos="fade-up" 
                     data-aos-delay="{{ $index * 100 }}">
                    <div class="bg-{{ $feature['color'] }}-100 p-5 rounded-full mb-6">
                        <i class="fas fa-{{ $feature['icon'] }} text-3xl text-{{ $feature['color'] }}-600"></i>
                    </div>
                    <h3 class="font-bold text-lg mb-3">{{ $feature['title'] }}</h3>
                    <p class="text-sm text-gray-600">{{ $feature['description'] }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- BENEFICIOS GLOBALES -->
<section class="py-24 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="text-center mb-20">
            <span class="text-blue-600 font-semibold text-lg" data-aos="fade-up">Beneficios</span>
            <h2 class="text-4xl md:text-5xl font-extrabold text-gray-900 mt-3" data-aos="fade-up" data-aos-delay="100">¿Por qué elegir nuestro sistema?</h2>
            <p class="text-gray-600 mt-6 max-w-2xl mx-auto text-lg" data-aos="fade-up" data-aos-delay="200">
                Descubre las ventajas que hacen de nuestra plataforma la mejor opción para tu empresa
            </p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="benefit-card bg-white p-8 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300" data-aos="fade-right">
                <div class="bg-blue-100 p-4 rounded-full w-16 h-16 flex items-center justify-center mb-6">
                    <i class="fas fa-rocket text-2xl text-blue-600"></i>
                </div>
                <h3 class="text-xl font-bold mb-4">Implementación Rápida</h3>
                <p class="text-gray-600">Configuración en tiempo récord y capacitación inmediata para tu equipo.</p>
            </div>
            <div class="benefit-card bg-white p-8 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300" data-aos="fade-up">
                <div class="bg-green-100 p-4 rounded-full w-16 h-16 flex items-center justify-center mb-6">
                    <i class="fas fa-shield-alt text-2xl text-green-600"></i>
                </div>
                <h3 class="text-xl font-bold mb-4">Seguridad Garantizada</h3>
                <p class="text-gray-600">Protección de datos y cumplimiento de normativas de privacidad.</p>
            </div>
            <div class="benefit-card bg-white p-8 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300" data-aos="fade-left">
                <div class="bg-purple-100 p-4 rounded-full w-16 h-16 flex items-center justify-center mb-6">
                    <i class="fas fa-headset text-2xl text-purple-600"></i>
                </div>
                <h3 class="text-xl font-bold mb-4">Soporte 24/7</h3>
                <p class="text-gray-600">Asistencia técnica permanente y resolución de incidencias inmediata.</p>
            </div>
        </div>
    </div>
</section>

<!-- CTA FINAL -->
<section class="py-24 bg-gradient-to-br from-blue-900 via-blue-700 to-indigo-900 relative overflow-hidden">
    <div class="hero-particles">
        @for ($i = 0; $i < 30; $i++)
            <div class="particle" style="
                left: {{ rand(0, 100) }}%;
                top: {{ rand(0, 100) }}%;
                animation-delay: {{ rand(0, 15) }}s;
                animation-duration: {{ rand(10, 20) }}s;
            "></div>
        @endfor
    </div>
    <div class="container mx-auto px-4 relative z-10">
        <div class="max-w-4xl mx-auto text-center">
            <h2 class="text-4xl md:text-5xl font-extrabold text-white mb-8" data-aos="fade-up">¿Listo para transformar tu gestión de RRHH?</h2>
            <p class="text-xl text-white/90 mb-12" data-aos="fade-up" data-aos-delay="100">
                Únete a cientos de empresas que ya están optimizando sus procesos de recursos humanos
            </p>
            <div class="flex flex-col sm:flex-row gap-6 justify-center items-center" data-aos="fade-up" data-aos-delay="200">
                <a href="{{ route('login') }}" class="glow inline-block bg-gradient-to-r from-yellow-400 to-yellow-500 hover:from-yellow-500 hover:to-yellow-600 text-blue-900 px-12 py-4 rounded-full font-bold text-lg shadow-lg transition-all duration-300 transform hover:scale-105">
                    <i class="fas fa-play-circle mr-2"></i>Ver demo
                </a>
                <a href="#contact" class="glow inline-block glass-effect text-white px-12 py-4 rounded-full font-bold text-lg shadow-lg transition-all duration-300 transform hover:scale-105">
                    <i class="fas fa-calendar-check mr-2"></i>Solicitar demo
                </a>
            </div>
        </div>
    </div>
</section>

@push('scripts')
<script>
    // Animación de números
    const animateValue = (element, start, end, duration) => {
        let startTimestamp = null;
        const step = (timestamp) => {
            if (!startTimestamp) startTimestamp = timestamp;
            const progress = Math.min((timestamp - startTimestamp) / duration, 1);
            const value = Math.floor(progress * (end - start) + start);
            element.textContent = value + (element.textContent.includes('+') ? '+' : '%');
            if (progress < 1) {
                window.requestAnimationFrame(step);
            }
        };
        window.requestAnimationFrame(step);
    };

    // Iniciar animación de números cuando los elementos son visibles
    const numberObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const element = entry.target;
                const value = parseInt(element.textContent);
                animateValue(element, 0, value, 2000);
                numberObserver.unobserve(element);
            }
        });
    }, {
        threshold: 0.5
    });

    document.querySelectorAll('.stats-card .text-5xl').forEach((element) => {
        numberObserver.observe(element);
    });
</script>
@endpush
@endsection 