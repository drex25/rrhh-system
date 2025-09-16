@props([
    'title',
    'subtitle' => null,
    'buttonText' => 'Comenzar ahora',
    'buttonLink' => '#',
    'secondaryButtonText' => null,
    'secondaryButtonLink' => '#',
    'backgroundImage' => null,
    'showStats' => true
])

<section class="relative min-h-screen flex items-center justify-center overflow-hidden bg-gradient-to-br from-indigo-900 via-blue-900 to-purple-900">
    <!-- Animated background elements -->
    <div class="absolute inset-0 overflow-hidden">
        <div class="absolute top-0 left-0 w-full h-full">
            <!-- Animated gradient blobs -->
            <div class="absolute top-1/4 left-1/4 w-96 h-96 bg-blue-500 rounded-full mix-blend-multiply filter blur-[128px] opacity-30 animate-pulse"></div>
            <div class="absolute bottom-1/4 right-1/4 w-96 h-96 bg-purple-500 rounded-full mix-blend-multiply filter blur-[128px] opacity-30 animate-pulse" style="animation-delay: -3s"></div>
            <div class="absolute top-1/2 right-1/3 w-96 h-96 bg-pink-500 rounded-full mix-blend-multiply filter blur-[128px] opacity-20 animate-pulse" style="animation-delay: -5s"></div>
        </div>
        
        <!-- Grid pattern overlay -->
        <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNjAiIGhlaWdodD0iNjAiIHZpZXdCb3g9IjAgMCA2MCA2MCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48ZyBmaWxsPSJub25lIiBmaWxsLXJ1bGU9ImV2ZW5vZGQiPjxnIGZpbGw9IiNmZmZmZmYiIGZpbGwtb3BhY2l0eT0iMC4wNSI+PHBhdGggZD0iTTAgMGg2MHY2MEgweiIvPjwvZz48L2c+PC9zdmc+')] bg-[30px_30px]"></div>
    </div>
    
    <div class="container mx-auto px-4 sm:px-6 relative z-10 max-w-7xl pb-24 sm:pb-32 lg:pb-40">
        <div class="flex flex-col lg:flex-row items-center justify-between gap-8 lg:gap-12">
            <!-- Left content -->
            <div class="w-full lg:w-1/2 text-center lg:text-left space-y-6 lg:space-y-8">
                <div class="inline-flex items-center px-4 py-2 rounded-full bg-white/10 backdrop-blur-md border border-white/20 mb-4 animate-fade-in">
                    <span class="w-3 h-3 bg-green-400 rounded-full mr-2 animate-pulse"></span>
                    <span class="text-white/90 text-sm font-medium">{{ $attributes->get('badge', 'Plataforma Integral de RRHH') }}</span>
                </div>
                
                <h1 class="text-4xl sm:text-5xl md:text-6xl lg:text-7xl font-extrabold text-white leading-tight tracking-tight">
                    <span class="block">Transforma tu</span>
                    <span class="block bg-gradient-to-r from-blue-400 to-purple-400 bg-clip-text text-transparent">Gestión de RRHH</span>
                    <span class="block">con Inteligencia</span>
                    <span class="block">Artificial</span>
                </h1>
                
                <p class="text-lg sm:text-xl lg:text-2xl text-white/80 leading-relaxed max-w-2xl mx-auto lg:mx-0 font-light">
                    La plataforma SaaS más completa para optimizar todos tus procesos de capital humano. Desde reclutamiento hasta nómina, todo en un solo lugar.
                </p>
                
                <div class="flex flex-col sm:flex-row gap-4 sm:gap-6 pt-4">
                    <a href="{{ $buttonLink }}" class="group inline-flex items-center justify-center px-8 py-4 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-semibold rounded-full shadow-2xl hover:shadow-blue-500/25 transform hover:-translate-y-1 hover:scale-105 transition-all duration-300 text-lg">
                        <i class="fas fa-rocket mr-3 group-hover:animate-bounce"></i>
                        {{ $buttonText }}
                        <i class="fas fa-arrow-right ml-3 group-hover:translate-x-1 transition-transform"></i>
                    </a>
                    
                    @if($secondaryButtonText)
                    <a href="{{ $secondaryButtonLink }}" class="group inline-flex items-center justify-center px-8 py-4 bg-white/10 backdrop-blur-md text-white font-semibold rounded-full border border-white/20 hover:bg-white/20 transform hover:-translate-y-1 transition-all duration-300 text-lg">
                        <i class="fas fa-play mr-3 group-hover:scale-110 transition-transform"></i>
                        {{ $secondaryButtonText }}
                    </a>
                    @endif
                </div>
                
                <!-- Trust indicators -->
                @if($showStats)
                <div class="grid grid-cols-3 gap-6 pt-8 lg:pt-12 pb-16 lg:pb-20">
                    <div class="text-center lg:text-left">
                        <div class="text-3xl sm:text-4xl lg:text-5xl font-bold text-white mb-2" data-counter="98">98%</div>
                        <div class="text-sm sm:text-base text-white/70 font-medium">Satisfacción</div>
                    </div>
                    <div class="text-center lg:text-left">
                        <div class="text-3xl sm:text-4xl lg:text-5xl font-bold text-white mb-2" data-counter="500">500+</div>
                        <div class="text-sm sm:text-base text-white/70 font-medium">Empresas</div>
                    </div>
                    <div class="text-center lg:text-left">
                        <div class="text-3xl sm:text-4xl lg:text-5xl font-bold text-white mb-2">24/7</div>
                        <div class="text-sm sm:text-base text-white/70 font-medium">Soporte</div>
                    </div>
                </div>
                @endif
            </div>
            
            <!-- Right content - Hero image -->
            <div class="w-full lg:w-1/2 flex justify-center lg:justify-end mt-12 lg:mt-0">
                <div class="relative max-w-lg w-full">
                    <!-- Background decorative elements -->
                    <div class="absolute -top-8 -left-8 w-32 h-32 bg-blue-400/30 rounded-full filter blur-xl animate-pulse"></div>
                    <div class="absolute -bottom-8 -right-8 w-32 h-32 bg-purple-400/30 rounded-full filter blur-xl animate-pulse" style="animation-delay: -2s"></div>
                    <div class="absolute top-1/2 -right-4 w-24 h-24 bg-pink-400/20 rounded-full filter blur-lg animate-pulse" style="animation-delay: -1s"></div>
                    
                    <!-- Main illustration container -->
                    <div class="relative bg-gradient-to-br from-white/20 to-white/10 backdrop-blur-xl rounded-3xl p-6 border border-white/30 shadow-2xl">
                        <!-- Dashboard mockup -->
                        <svg class="w-full h-auto" viewBox="0 0 500 400" xmlns="http://www.w3.org/2000/svg">
                            <!-- Dashboard Background with better gradient -->
                            <rect x="40" y="40" width="420" height="320" rx="24" fill="url(#modernDashboard)" stroke="rgba(255,255,255,0.4)" stroke-width="3"/>
                            
                            <!-- Modern Header -->
                            <rect x="60" y="60" width="380" height="50" rx="15" fill="rgba(255,255,255,0.15)"/>
                            <circle cx="85" cy="85" r="8" fill="#ef4444"/>
                            <circle cx="110" cy="85" r="8" fill="#f59e0b"/>
                            <circle cx="135" cy="85" r="8" fill="#10b981"/>
                            
                            <!-- Navigation -->
                            <rect x="320" y="70" width="60" height="8" rx="4" fill="rgba(255,255,255,0.4)"/>
                            <rect x="390" y="70" width="40" height="8" rx="4" fill="rgba(255,255,255,0.3)"/>
                            
                            <!-- Main Content Area -->
                            <rect x="60" y="130" width="380" height="210" rx="15" fill="rgba(255,255,255,0.08)"/>
                            
                            <!-- Analytics Chart -->
                            <rect x="80" y="150" width="180" height="120" rx="12" fill="rgba(59, 130, 246, 0.1)" stroke="rgba(59, 130, 246, 0.3)" stroke-width="2"/>
                            <path d="M95 250 L120 230 L145 235 L170 215 L195 200 L220 185 L245 170" stroke="#60a5fa" stroke-width="4" fill="none" stroke-linecap="round"/>
                            <circle cx="245" cy="170" r="4" fill="#60a5fa"/>
                            
                            <!-- Employee Grid -->
                            <rect x="280" y="150" width="140" height="35" rx="10" fill="rgba(139, 92, 246, 0.1)" stroke="rgba(139, 92, 246, 0.3)" stroke-width="1"/>
                            <circle cx="300" cy="167" r="10" fill="#8b5cf6"/>
                            <rect x="320" y="160" width="70" height="6" rx="3" fill="rgba(255,255,255,0.4)"/>
                            <rect x="320" y="172" width="50" height="4" rx="2" fill="rgba(255,255,255,0.25)"/>
                            
                            <rect x="280" y="195" width="140" height="35" rx="10" fill="rgba(16, 185, 129, 0.1)" stroke="rgba(16, 185, 129, 0.3)" stroke-width="1"/>
                            <circle cx="300" cy="212" r="10" fill="#10b981"/>
                            <rect x="320" y="205" width="70" height="6" rx="3" fill="rgba(255,255,255,0.4)"/>
                            <rect x="320" y="217" width="50" height="4" rx="2" fill="rgba(255,255,255,0.25)"/>
                            
                            <rect x="280" y="240" width="140" height="35" rx="10" fill="rgba(245, 158, 11, 0.1)" stroke="rgba(245, 158, 11, 0.3)" stroke-width="1"/>
                            <circle cx="300" cy="257" r="10" fill="#f59e0b"/>
                            <rect x="320" y="250" width="70" height="6" rx="3" fill="rgba(255,255,255,0.4)"/>
                            <rect x="320" y="262" width="50" height="4" rx="2" fill="rgba(255,255,255,0.25)"/>
                            
                            <!-- Modern Statistics Bars -->
                            <rect x="80" y="285" width="45" height="45" rx="10" fill="rgba(59, 130, 246, 0.2)" stroke="rgba(59, 130, 246, 0.4)" stroke-width="2"/>
                            <rect x="85" y="310" width="35" height="15" rx="7" fill="#3b82f6"/>
                            
                            <rect x="140" y="285" width="45" height="45" rx="10" fill="rgba(139, 92, 246, 0.2)" stroke="rgba(139, 92, 246, 0.4)" stroke-width="2"/>
                            <rect x="145" y="300" width="35" height="25" rx="7" fill="#8b5cf6"/>
                            
                            <rect x="200" y="285" width="45" height="45" rx="10" fill="rgba(16, 185, 129, 0.2)" stroke="rgba(16, 185, 129, 0.4)" stroke-width="2"/>
                            <rect x="205" y="295" width="35" height="30" rx="7" fill="#10b981"/>
                            
                            <!-- Floating Action Buttons -->
                            <circle cx="380" cy="100" r="18" fill="rgba(59, 130, 246, 0.2)" stroke="#3b82f6" stroke-width="2"/>
                            <path d="M375 100 L378 103 L385 96" stroke="#3b82f6" stroke-width="2.5" fill="none" stroke-linecap="round"/>
                            
                            <circle cx="420" cy="140" r="15" fill="rgba(16, 185, 129, 0.2)" stroke="#10b981" stroke-width="2"/>
                            <path d="M415 140 h10 M420 135 v10" stroke="#10b981" stroke-width="2" stroke-linecap="round"/>
                            
                            <!-- Enhanced Gradients -->
                            <defs>
                                <linearGradient id="modernDashboard" x1="0%" y1="0%" x2="100%" y2="100%">
                                    <stop offset="0%" style="stop-color:rgba(59, 130, 246, 0.15);stop-opacity:1" />
                                    <stop offset="50%" style="stop-color:rgba(139, 92, 246, 0.12);stop-opacity:1" />
                                    <stop offset="100%" style="stop-color:rgba(16, 185, 129, 0.1);stop-opacity:1" />
                                </linearGradient>
                            </defs>
                        </svg>
                        
                        <!-- Enhanced Floating Elements -->
                        <div class="absolute top-6 right-6 bg-gradient-to-r from-green-500 to-emerald-500 text-white px-4 py-2 rounded-full text-sm font-semibold shadow-lg animate-bounce border border-green-400/50">
                            <i class="fas fa-wifi mr-2"></i>
                            En línea
                        </div>
                        
                        <!-- Productivity Badge -->
                        <div class="absolute -left-6 top-1/3 bg-gradient-to-r from-blue-500/90 to-indigo-500/90 backdrop-blur-md rounded-xl p-4 border border-blue-400/50 shadow-xl transform hover:scale-105 transition-transform">
                            <div class="text-white text-lg font-bold">+24%</div>
                            <div class="text-blue-100 text-sm">Productividad</div>
                            <i class="fas fa-chart-line text-blue-200 text-xs mt-1"></i>
                        </div>
                        
                        <!-- Accuracy Badge -->
                        <div class="absolute -right-6 bottom-1/3 bg-gradient-to-r from-purple-500/90 to-pink-500/90 backdrop-blur-md rounded-xl p-4 border border-purple-400/50 shadow-xl transform hover:scale-105 transition-transform">
                            <div class="text-white text-lg font-bold">98%</div>
                            <div class="text-purple-100 text-sm">Precisión</div>
                            <i class="fas fa-bullseye text-purple-200 text-xs mt-1"></i>
                        </div>
                        
                        <!-- Efficiency Badge -->
                        <div class="absolute top-1/2 -left-8 bg-gradient-to-r from-emerald-500/90 to-teal-500/90 backdrop-blur-md rounded-xl p-3 border border-emerald-400/50 shadow-xl transform hover:scale-105 transition-transform">
                            <div class="text-white text-base font-bold">5x</div>
                            <div class="text-emerald-100 text-xs">Más rápido</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Wave divider -->
    <div class="absolute bottom-0 left-0 w-full overflow-hidden leading-none">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none" class="w-full h-[80px] sm:h-[100px] lg:h-[120px] text-white">
            <path d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V120H0V27.35A600.21,600.21,0,0,0,321.39,56.44Z" fill="currentColor"></path>
        </svg>
    </div>
</section>

@push('scripts')
<script>
// Counter animation
document.addEventListener('DOMContentLoaded', function() {
    const counters = document.querySelectorAll('[data-counter]');
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const target = entry.target;
                const countTo = parseInt(target.getAttribute('data-counter'));
                let count = 0;
                const interval = setInterval(() => {
                    count += Math.ceil(countTo / 50);
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
