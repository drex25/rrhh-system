@extends('layouts.public')

@section('title', 'Plataforma SaaS de RRHH - Transforma tu Gestión de Capital Humano')

@section('main-classes', 'p-0 m-0 min-h-screen')

@section('content')
@php
// Data for all sections
$features = [
    [
        'icon' => 'fas fa-user-plus',
        'title' => 'Reclutamiento Inteligente',
        'description' => 'Optimiza tu proceso de selección con un sistema completo de gestión de candidatos, entrevistas y evaluaciones.',
        'color' => 'blue'
    ],
    [
        'icon' => 'fas fa-users-cog',
        'title' => 'Gestión de Personal',
        'description' => 'Centraliza toda la información de tus colaboradores en legajos digitales accesibles y seguros.',
        'color' => 'purple'
    ],
    [
        'icon' => 'fas fa-calendar-check',
        'title' => 'Control de Asistencia',
        'description' => 'Administra vacaciones, ausencias y permisos de manera eficiente y transparente.',
        'color' => 'pink'
    ],
    [
        'icon' => 'fas fa-chart-line',
        'title' => 'Evaluaciones de Desempeño',
        'description' => 'Implementa ciclos de feedback continuo para potenciar el desarrollo profesional.',
        'color' => 'green'
    ],
    [
        'icon' => 'fas fa-money-check-alt',
        'title' => 'Gestión de Nómina',
        'description' => 'Automatiza el cálculo y generación de recibos de sueldo con todas las variables.',
        'color' => 'yellow'
    ],
    [
        'icon' => 'fas fa-chart-bar',
        'title' => 'Reportes y Analytics',
        'description' => 'Toma decisiones basadas en datos con reportes en tiempo real y dashboards ejecutivos.',
        'color' => 'indigo'
    ]
];

$plans = [
    [
        'name' => 'Starter',
        'price' => '29',
        'period' => 'mes',
        'description' => 'Perfecto para pequeñas empresas que inician su transformación digital',
        'features' => [
            'Hasta 25 empleados',
            'Gestión básica de personal',
            'Control de asistencia',
            'Reportes básicos',
            'Soporte por email'
        ],
        'popular' => false,
        'cta' => 'Comenzar Prueba Gratuita'
    ],
    [
        'name' => 'Professional',
        'price' => '59',
        'period' => 'mes',
        'description' => 'La opción más popular para empresas en crecimiento',
        'features' => [
            'Hasta 100 empleados',
            'Todas las funciones de Starter',
            'Reclutamiento avanzado',
            'Evaluaciones de desempeño',
            'Gestión de nómina',
            'Integraciones',
            'Soporte prioritario'
        ],
        'popular' => true,
        'cta' => 'Comenzar Prueba Gratuita'
    ],
    [
        'name' => 'Enterprise',
        'price' => '99',
        'period' => 'mes',
        'description' => 'Solución completa para empresas grandes y complejas',
        'features' => [
            'Empleados ilimitados',
            'Todas las funciones de Professional',
            'Analytics avanzados',
            'API completa',
            'Onboarding personalizado',
            'Manager dedicado',
            'SLA 99.9%'
        ],
        'popular' => false,
        'cta' => 'Contactar Ventas'
    ]
];

$testimonials = [
    [
        'name' => 'María Rodríguez',
        'position' => 'Directora de RRHH',
        'company' => 'TechCorp',
        'text' => 'Implementamos la plataforma hace 6 meses y ha transformado completamente nuestra gestión de personal. Hemos reducido en 70% el tiempo administrativo.',
        'rating' => 5,
        'color' => 'blue'
    ],
    [
        'name' => 'Juan Martínez',
        'position' => 'CEO',
        'company' => 'Innovatech',
        'text' => 'La implementación fue sorprendentemente rápida. En menos de 2 semanas teníamos todo funcionando. El ROI se vio desde el primer mes.',
        'rating' => 5,
        'color' => 'purple'
    ],
    [
        'name' => 'Laura Sánchez',
        'position' => 'Gerente de RRHH',
        'company' => 'GlobalServices',
        'text' => 'Los reportes en tiempo real y el dashboard ejecutivo nos permiten tomar decisiones estratégicas basadas en datos concretos. Impresionante.',
        'rating' => 5,
        'color' => 'green'
    ]
];

$faqs = [
    [
        'question' => '¿Cuánto tiempo toma implementar la plataforma?',
        'answer' => 'La implementación típica toma entre 1 a 3 semanas, dependiendo del tamaño de tu empresa y los módulos que elijas. Nuestro equipo te acompañará en todo el proceso, desde la configuración inicial hasta la capacitación de usuarios.'
    ],
    [
        'question' => '¿Los datos están seguros en la nube?',
        'answer' => 'Absolutamente. Utilizamos encriptación de nivel bancario AES-256, certificaciones ISO 27001 y SOC 2. Todos los datos se almacenan en servidores seguros con backups automáticos diarios y recuperación ante desastres.'
    ],
    [
        'question' => '¿Puedo integrar con mis sistemas actuales?',
        'answer' => 'Sí, ofrecemos integraciones con más de 100 herramientas populares como Slack, Microsoft Teams, QuickBooks, y sistemas ERP. También contamos con una API REST completa para integraciones personalizadas.'
    ],
    [
        'question' => '¿Qué tipo de soporte técnico incluye?',
        'answer' => 'Todos los planes incluyen soporte técnico. El plan Starter tiene soporte por email, Professional incluye soporte prioritario, y Enterprise cuenta con un manager dedicado y SLA del 99.9%.'
    ],
    [
        'question' => '¿Puedo cancelar mi suscripción en cualquier momento?',
        'answer' => 'Por supuesto. No hay contratos de permanencia. Puedes cancelar tu suscripción en cualquier momento desde tu panel de administración. Mantendrás acceso hasta el final de tu período de facturación actual.'
    ]
];

$integrations = [
    ['name' => 'Slack', 'icon' => 'fab fa-slack', 'color' => 'blue'],
    ['name' => 'Teams', 'icon' => 'fab fa-microsoft', 'color' => 'purple'],
    ['name' => 'Gmail', 'icon' => 'fab fa-google', 'color' => 'red'],
    ['name' => 'LinkedIn', 'icon' => 'fab fa-linkedin', 'color' => 'blue'],
    ['name' => 'Excel', 'icon' => 'fas fa-file-excel', 'color' => 'green'],
    ['name' => 'QuickBooks', 'icon' => 'fas fa-calculator', 'color' => 'green']
];

$successStories = [
    [
        'company' => 'TechCorp Solutions',
        'industry' => 'Tecnología',
        'employees' => '250',
        'color' => 'blue',
        'challenge' => 'Procesos manuales de RRHH consumían 40+ horas semanales, errores frecuentes en nóminas y falta de visibilidad en métricas de talento.',
        'solution' => 'Implementación completa del sistema RRHH con automatización de nóminas, portal de empleados y analytics avanzados.',
        'results' => [
            ['value' => '85%', 'metric' => 'Reducción tiempo'],
            ['value' => '98%', 'metric' => 'Precisión nóminas'],
            ['value' => '60%', 'metric' => 'Mejor retención'],
            ['value' => '$50K', 'metric' => 'Ahorro anual']
        ],
        'quote' => 'La transformación ha sido increíble. Ahora tenemos visibilidad total de nuestros procesos de RRHH y nuestro equipo puede enfocarse en estrategia en lugar de tareas administrativas.',
        'author' => 'María González',
        'position' => 'Directora de RRHH'
    ],
    [
        'company' => 'Retail Excellence',
        'industry' => 'Retail',
        'employees' => '500',
        'color' => 'purple',
        'challenge' => 'Alta rotación de personal (35%), procesos de reclutamiento lentos y dificultades para gestionar horarios de múltiples ubicaciones.',
        'solution' => 'Plataforma integrada con ATS optimizado, sistema de evaluación de desempeño y gestión automatizada de horarios.',
        'results' => [
            ['value' => '18%', 'metric' => 'Rotación actual'],
            ['value' => '65%', 'metric' => 'Tiempo reclutamiento'],
            ['value' => '92%', 'metric' => 'Satisfacción empleados'],
            ['value' => '$120K', 'metric' => 'Ahorro costos']
        ],
        'quote' => 'No solo redujimos la rotación a la mitad, sino que ahora podemos predecir y prevenir problemas antes de que ocurran. El ROI ha sido excepcional.',
        'author' => 'Carlos Ruiz',
        'position' => 'Gerente General'
    ]
];
@endphp

<!-- Hero Section - FIRST -->
<x-saas.hero-section 
    title="Transforma tu Gestión de RRHH con Inteligencia Artificial"
    subtitle="La plataforma SaaS más completa para optimizar todos tus procesos de capital humano. Desde reclutamiento hasta nómina, todo en un solo lugar."
    buttonText="Comenzar Prueba Gratuita"
    buttonLink="{{ route('login') }}"
    secondaryButtonText="Ver Demo en Vivo"
    secondaryButtonLink="#contact"
    :showStats="true"
/>

<!-- Features Section -->
<x-saas.features-grid 
    :features="$features"
    title="Todo lo que necesitas para gestionar tu talento"
    subtitle="Funcionalidades diseñadas para empresas modernas que buscan eficiencia y crecimiento"
/>

<!-- Pricing Section -->
<x-saas.pricing-section 
    :plans="$plans"
    title="Planes que se adaptan a tu empresa"
    subtitle="Comienza gratis y escala conforme creces. Sin sorpresas, sin costos ocultos."
/>

<!-- Testimonials Section -->
<x-saas.testimonials-section 
    :testimonials="$testimonials"
    title="Más de 500 empresas confían en nosotros"
    subtitle="Descubre por qué somos la plataforma de RRHH preferida por empresas líderes en toda Argentina"
/>

<!-- Security Section -->
<x-saas.security-section />

<!-- Integrations Section -->
<x-saas.integrations-section :integrations="$integrations" />

<!-- Success Stories Section -->
<x-saas.success-stories-section :stories="$successStories" />

<!-- FAQ Section -->
<x-saas.faq-section 
    :faqs="$faqs"
    title="Preguntas Frecuentes"
    subtitle="Todo lo que necesitas saber sobre nuestra plataforma"
/>

<!-- Contact Section - LAST -->
<x-saas.contact-section />

@endsection

@push('scripts')
<script>
// Counter animation
document.addEventListener('DOMContentLoaded', function() {
    const counters = document.querySelectorAll('.text-4xl.font-bold, [data-counter]');
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const target = entry.target;
                const countTo = parseInt(target.getAttribute('data-counter') || target.innerText.replace(/\D/g, ''));
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

// Form handling
document.addEventListener('DOMContentLoaded', function() {
    const contactForm = document.getElementById('contact-form');
    if (contactForm) {
        contactForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Show success message
            Swal.fire({
                icon: 'success',
                title: '¡Mensaje enviado!',
                text: 'Te contactaremos pronto.',
                confirmButtonColor: '#3b82f6'
            });
            
            // Reset form
            this.reset();
        });
    }
});

// Pricing toggle
document.addEventListener('DOMContentLoaded', function() {
    const toggle = document.getElementById('pricing-toggle');
    if (toggle) {
        toggle.addEventListener('change', function() {
            // Toggle pricing logic here
            console.log('Pricing toggle changed:', this.checked);
        });
    }
});
</script>
@endpush
