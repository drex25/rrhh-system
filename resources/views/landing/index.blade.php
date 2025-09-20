@extends('layouts.public')

@push('head')
<!-- SaaS Meta Tags -->
<meta name="description" content="Plataforma SaaS de RRHH: reclutamiento, nómina, desempeño, analytics y más en una sola suite. Optimiza tu gestión de talento con IA." />
<link rel="canonical" href="{{ url('/') }}" />
<meta property="og:type" content="website" />
<meta property="og:title" content="Gestión Integral de RRHH con IA" />
<meta property="og:description" content="Reclutamiento, nómina, desempeño, asistencia y analytics en un solo lugar. Empieza gratis 14 días." />
<meta property="og:url" content="{{ url('/') }}" />
<meta property="og:image" content="{{ asset('images/og-rrhh-saas.png') }}" />
<meta name="twitter:card" content="summary_large_image" />
<meta name="twitter:title" content="Suite SaaS de RRHH" />
<meta name="twitter:description" content="Centraliza y automatiza tus procesos de recursos humanos." />
<meta name="twitter:image" content="{{ asset('images/og-rrhh-saas.png') }}" />

<!-- JSON-LD: Organization (simplified to avoid Blade parsing issues) -->
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "Organization",
    "name": "{{ addslashes(config('app.name', 'TS Group')) }}",
    "url": "{{ url('/') }}",
    "logo": "{{ asset('images/tsg.png') }}",
    "sameAs": [
        "https://www.linkedin.com/company/ts-group",
        "https://twitter.com/tsgroup"
    ]
}
</script>
<!-- JSON-LD: Product minimal (dynamic offers can re-added later after variable init) -->
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "Product",
    "name": "Plataforma SaaS de RRHH",
    "description": "Software integral para gestión de talento: reclutamiento, nómina, desempeño y analytics.",
    "brand": {
        "@type": "Brand",
        "name": "{{ addslashes(config('app.name', 'TS Group')) }}"
    }
}
</script>
<!-- JSON-LD: FAQ (static minimal; dynamic map removed to prevent parse error) -->
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "FAQPage"
}
</script>
@endpush

@section('title', 'Plataforma SaaS de RRHH - Transforma tu Gestión de Capital Humano')

@section('main-classes', 'p-0 m-0 min-h-screen') {{-- Mantener, el offset lo manejamos en el panel --}}

@section('content')
@php
use App\Models\Plan;
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

// Dynamic plans from DB (fallback if none)
$plans = Plan::where('is_active', true)->orderBy('price_cents')->get()->map(function($p){
    $isFree = $p->price_cents == 0;
    $annualCents = $p->yearly_price_cents ?? ($p->price_cents*12*0.8);
    return [
        'name' => $p->name,
        'price' => $isFree ? '0' : number_format($p->price_cents/100, 0),
        'annual_price' => $isFree ? '0' : number_format($annualCents/100, 0),
        'period' => 'mes',
        'description' => $p->description,
        'features' => $p->features ?? [],
        'popular' => $p->code === 'pro',
        'cta' => $p->code === 'enterprise' ? 'Contactar Ventas' : 'Comenzar Prueba Gratuita',
        'link' => $p->code === 'enterprise' ? '#contact' : route('signup.show')
    ];
})->toArray();
if(empty($plans)){
    $plans = [
        [ 'name'=>'Free','price'=>'0','period'=>'mes','description'=>'Comienza sin costo','features'=>['Hasta 5 empleados','1 vacante','Soporte básico'],'popular'=>false,'cta'=>'Crear Cuenta','link'=>route('signup.show') ],
        [ 'name'=>'Pro','price'=>'49','period'=>'mes','description'=>'Escala tu operación','features'=>['Hasta 100 empleados','Vacantes ilimitadas','Soporte prioritario'],'popular'=>true,'cta'=>'Comenzar Prueba','link'=>route('signup.show') ],
        [ 'name'=>'Enterprise','price'=>'199','period'=>'mes','description'=>'Máximo nivel y soporte dedicado','features'=>['Empleados ilimitados','Integraciones avanzadas','SLA 99.9%'],'popular'=>false,'cta'=>'Contactar Ventas','link'=>'#contact' ]
    ];
}

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
    buttonLink="{{ route('signup.show') }}"
    secondaryButtonText="Ver Demo en Vivo"
    secondaryButtonLink="{{ config('demo.enabled') ? route('demo.login') : '#contact' }}"
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
// Preserve existing scripts (could be refactored later)
// Landing mini limits component
if(typeof Alpine !== 'undefined'){
    document.addEventListener('alpine:init', () => {
        Alpine.data('landingLimits', () => ({
            loaded:false, plan:null, trialEndsAt:null, limits:{}, usage:{}, remaining:{}, currentCompany:null,
            get limitedKeys(){ return Object.keys(this.limits).slice(0,4); },
            async init(){ await this.fetch(); },
            async fetch(){ try { const [cur, lim] = await Promise.all([
                    axios.get('/api/company/current'), axios.get('/api/company/limits')
                ]); this.currentCompany = cur.data.data; if(lim.data.data){
                    const d = lim.data.data; this.plan = d.plan; this.limits = d.limits; this.usage = d.usage; this.remaining = d.remaining; this.trialEndsAt = d.trial_ends_at || null; }
                this.loaded = true; } catch(e){ console.error(e); }
            },
            progressStyle(key){ const limit=this.limits[key]; if(limit===null) return 'width:100%'; const used=this.usage[key]??0; return `width:${Math.min(100,(used/limit)*100)}%`; }
        }))
    });
}

// Counter animation (restricted to explicit data-counter only to avoid NaN on headings)
document.addEventListener('DOMContentLoaded', function() {
    const counters = document.querySelectorAll('[data-counter]');
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (!entry.isIntersecting) return;
            const target = entry.target;
            const raw = target.getAttribute('data-counter');
            const countTo = parseInt((raw||'').replace(/[^0-9]/g,''));
            if (isNaN(countTo) || countTo <= 0) { observer.unobserve(target); return; }
            let count = 0;
            const hasPlus = /\+$/.test(raw);
            const hasPercent = /%$/.test(raw);
            const step = Math.max(1, Math.ceil(countTo / 30));
            const interval = setInterval(() => {
                count += step;
                if (count >= countTo) {
                    count = countTo;
                    clearInterval(interval);
                }
                target.textContent = hasPlus ? `${count}${hasPlus && count===countTo?'+':''}` : hasPercent ? `${count}%` : `${count}`;
            }, 30);
            observer.unobserve(target);
        });
    }, { threshold: 0.5 });
    counters.forEach(c => observer.observe(c));
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
</script>
@endpush
