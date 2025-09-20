@props([
    'plans' => []
])

<section class="py-24 bg-gradient-to-br from-gray-50 to-gray-100 relative" x-data="pricingComponent()" id="pricing">
    <!-- Background patterns -->
    <div class="absolute inset-0 overflow-hidden">
        <div class="absolute -top-24 -right-24 w-96 h-96 bg-blue-100 rounded-full opacity-20 blur-3xl"></div>
        <div class="absolute -bottom-24 -left-24 w-96 h-96 bg-purple-100 rounded-full opacity-20 blur-3xl"></div>
    </div>

    <div class="mx-auto px-4 sm:px-6 relative z-10 max-w-7xl">
        <div class="text-center mb-16">
            <div class="inline-flex items-center px-4 py-2 rounded-full bg-blue-50 text-blue-600 font-medium mb-4">
                <i class="fas fa-tags mr-2"></i>
                Planes y precios
            </div>
            <h2 class="text-3xl sm:text-4xl lg:text-5xl font-bold mb-6 bg-gradient-to-r from-gray-900 to-gray-600 bg-clip-text text-transparent">
                {{ $attributes->get('title', 'Elige el plan perfecto') }}
            </h2>
            <p class="text-lg sm:text-xl text-gray-600 max-w-3xl mx-auto mb-8">
                {{ $attributes->get('subtitle', 'Soluciones escalables diseñadas para empresas de todos los tamaños') }}
            </p>
            <!-- Toggle anual/mensual -->
            <div class="flex items-center justify-center space-x-4 mb-12 select-none">
                <span class="text-gray-600 text-sm sm:text-base" :class="!annual ? 'font-semibold text-gray-900' : ''">Mensual</span>
                <div class="relative">
                    <input type="checkbox" id="pricing-toggle" class="sr-only" x-model="annual" @change="persistPreference()">
                    <label for="pricing-toggle" class="flex items-center cursor-pointer" @keydown.enter.prevent="annual=!annual; persistPreference()">
                        <div class="relative">
                            <div class="block bg-gray-300 w-14 h-8 rounded-full"></div>
                            <div class="dot absolute left-1 top-1 bg-white w-6 h-6 rounded-full transition" :class="annual ? 'translate-x-6' : ''"></div>
                        </div>
                    </label>
                </div>
                <span class="text-gray-900 font-medium text-sm sm:text-base" :class="annual ? 'font-semibold' : ''">
                    Anual
                    <span class="ml-2 inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800" x-show="annual" x-transition>
                        Ahorra 20%
                    </span>
                </span>
            </div>
        </div>
        <!-- Pricing Cards Grid -->
        <div class="flex flex-wrap justify-center items-stretch gap-6 lg:gap-8 max-w-7xl mx-auto">
            @forelse($plans as $index => $plan)
            @php $planCode = Str::slug($plan['name'],'-'); @endphp
            <div class="relative group flex-shrink-0 w-full sm:w-96 {{ $plan['popular'] ?? false ? 'lg:transform lg:scale-105' : '' }}" data-plan-code="{{ $planCode }}">
                @if($plan['popular'] ?? false)
                <div class="absolute -top-4 left-1/2 transform -translate-x-1/2 z-10">
                    <span class="bg-gradient-to-r from-blue-600 to-purple-600 text-white px-4 py-2 rounded-full text-sm font-semibold shadow-lg">
                        <i class="fas fa-crown mr-1"></i>
                        Más Popular
                    </span>
                </div>
                @endif
                <div class="h-full bg-white rounded-3xl shadow-xl hover:shadow-2xl transition-all duration-500 p-8 border {{ $plan['popular'] ?? false ? 'border-blue-200 ring-2 ring-blue-100' : 'border-gray-200' }} relative">
                    <div class="text-center mb-8">
                        <h3 class="text-2xl font-bold text-gray-900 mb-2">{{ $plan['name'] ?? 'Plan Básico' }}</h3>
                        <p class="text-gray-600 mb-6 leading-relaxed">{{ $plan['description'] ?? 'Perfecto para empezar' }}</p>
                        <div class="mb-8">
                            <div class="flex items-baseline justify-center mb-2">
                                <span class="text-5xl font-extrabold text-gray-900 price-value" data-monthly="{{ $plan['price'] ?? '0' }}" data-annual="{{ $plan['annual_price'] ?? ($plan['price'] ?? 0) }}" x-text="formattedPrice($el)"></span>
                                <span class="text-xl text-gray-600 ml-2" x-text="annual ? '/año' : '/mes'"></span>
                            </div>
                            <p class="text-sm text-gray-500" x-text="annual ? 'facturación anual' : 'facturación mensual'"></p>
                        </div>
                        <a :href="signupUrl('{{ $plan['link'] ?? route('signup.show') }}','{{ $planCode }}')" @click="selectPlan('{{ $planCode }}')" class="w-full inline-flex items-center justify-center px-6 py-4 border border-transparent text-base font-semibold rounded-xl text-white bg-gradient-to-r {{ $plan['popular'] ?? false ? 'from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700' : 'from-gray-700 to-gray-800 hover:from-gray-800 hover:to-gray-900' }} shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300">
                            {{ $plan['cta'] ?? 'Comenzar prueba' }}
                            <i class="fas fa-arrow-right ml-2"></i>
                        </a>
                    </div>
                    <div class="space-y-4">
                        <h4 class="font-semibold text-gray-900 text-center mb-6 border-b border-gray-100 pb-4">Todo lo que incluye:</h4>
                        @foreach($plan['features'] ?? ['Gestión básica de empleados', 'Reportes estándar', 'Soporte por email'] as $feature)
                        <div class="flex items-start">
                            <i class="fas fa-check text-green-500 mr-3 mt-1 flex-shrink-0"></i>
                            <span class="text-gray-700 leading-relaxed">{{ $feature }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @empty
            <!-- Default plans if none provided -->
            <!-- Plan Básico -->
            <div class="relative group">
                <div class="h-full bg-white rounded-3xl shadow-xl hover:shadow-2xl transition-all duration-500 p-8 border border-gray-200">
                    <div class="text-center mb-8">
                        <h3 class="text-2xl font-bold text-gray-900 mb-2">Básico</h3>
                        <p class="text-gray-600 mb-6">Perfecto para pequeñas empresas</p>
                        <div class="mb-6">
                            <div class="flex items-baseline justify-center">
                                <span class="text-5xl font-extrabold text-gray-900">$29</span>
                                <span class="text-xl text-gray-600 ml-1">/mes</span>
                            </div>
                            <p class="text-sm text-gray-500 mt-1">por usuario</p>
                        </div>
                        <a href="#" class="w-full inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-xl text-white bg-gradient-to-r from-gray-700 to-gray-800 hover:from-gray-800 hover:to-gray-900 shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300">
                            Comenzar prueba
                            <i class="fas fa-arrow-right ml-2"></i>
                        </a>
                    </div>
                    <div class="space-y-4">
                        <h4 class="font-semibold text-gray-900 text-center mb-4">Todo lo que incluye:</h4>
                        <div class="flex items-center">
                            <i class="fas fa-check text-green-500 mr-3"></i>
                            <span class="text-gray-700">Hasta 50 empleados</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-check text-green-500 mr-3"></i>
                            <span class="text-gray-700">Gestión básica</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-check text-green-500 mr-3"></i>
                            <span class="text-gray-700">Reportes estándar</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-check text-green-500 mr-3"></i>
                            <span class="text-gray-700">Soporte por email</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Plan Professional (Featured) -->
            <div class="relative group transform scale-105">
                <div class="absolute -top-4 left-1/2 transform -translate-x-1/2">
                    <span class="bg-gradient-to-r from-blue-600 to-purple-600 text-white px-4 py-1 rounded-full text-sm font-medium">
                        Más popular
                    </span>
                </div>
                <div class="h-full bg-white rounded-3xl shadow-xl hover:shadow-2xl transition-all duration-500 p-8 border border-blue-200 ring-2 ring-blue-100">
                    <div class="text-center mb-8">
                        <h3 class="text-2xl font-bold text-gray-900 mb-2">Profesional</h3>
                        <p class="text-gray-600 mb-6">Ideal para empresas en crecimiento</p>
                        <div class="mb-6">
                            <div class="flex items-baseline justify-center">
                                <span class="text-5xl font-extrabold text-gray-900">$59</span>
                                <span class="text-xl text-gray-600 ml-1">/mes</span>
                            </div>
                            <p class="text-sm text-gray-500 mt-1">por usuario</p>
                        </div>
                        <a href="#" class="w-full inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-xl text-white bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300">
                            Comenzar prueba
                            <i class="fas fa-arrow-right ml-2"></i>
                        </a>
                    </div>
                    <div class="space-y-4">
                        <h4 class="font-semibold text-gray-900 text-center mb-4">Todo lo que incluye:</h4>
                        <div class="flex items-center">
                            <i class="fas fa-check text-green-500 mr-3"></i>
                            <span class="text-gray-700">Hasta 200 empleados</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-check text-green-500 mr-3"></i>
                            <span class="text-gray-700">Funciones avanzadas</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-check text-green-500 mr-3"></i>
                            <span class="text-gray-700">Reportes personalizados</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-check text-green-500 mr-3"></i>
                            <span class="text-gray-700">Soporte prioritario</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-check text-green-500 mr-3"></i>
                            <span class="text-gray-700">Integraciones</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Plan Enterprise -->
            <div class="relative group">
                <div class="h-full bg-white rounded-3xl shadow-xl hover:shadow-2xl transition-all duration-500 p-8 border border-gray-200">
                    <div class="text-center mb-8">
                        <h3 class="text-2xl font-bold text-gray-900 mb-2">Enterprise</h3>
                        <p class="text-gray-600 mb-6">Para grandes organizaciones</p>
                        <div class="mb-6">
                            <div class="flex items-baseline justify-center">
                                <span class="text-5xl font-extrabold text-gray-900">$99</span>
                                <span class="text-xl text-gray-600 ml-1">/mes</span>
                            </div>
                            <p class="text-sm text-gray-500 mt-1">por usuario</p>
                        </div>
                        <a href="#" class="w-full inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-xl text-white bg-gradient-to-r from-gray-700 to-gray-800 hover:from-gray-800 hover:to-gray-900 shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300">
                            Contactar ventas
                            <i class="fas fa-arrow-right ml-2"></i>
                        </a>
                    </div>
                    <div class="space-y-4">
                        <h4 class="font-semibold text-gray-900 text-center mb-4">Todo lo que incluye:</h4>
                        <div class="flex items-center">
                            <i class="fas fa-check text-green-500 mr-3"></i>
                            <span class="text-gray-700">Empleados ilimitados</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-check text-green-500 mr-3"></i>
                            <span class="text-gray-700">Todas las funciones</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-check text-green-500 mr-3"></i>
                            <span class="text-gray-700">API completa</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-check text-green-500 mr-3"></i>
                            <span class="text-gray-700">Soporte 24/7</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-check text-green-500 mr-3"></i>
                            <span class="text-gray-700">Manager dedicado</span>
                        </div>
                    </div>
                </div>
            </div>
            @endforelse
        </div>
        <div class="text-center mt-12">
            <p class="text-gray-600 mb-4">Todas las planes incluyen 14 días de prueba gratuita</p>
            <div class="flex items-center justify-center space-x-8 text-sm text-gray-500">
                <div class="flex items-center">
                    <i class="fas fa-shield-alt mr-2 text-green-500"></i>
                    Datos seguros
                </div>
                <div class="flex items-center">
                    <i class="fas fa-headset mr-2 text-blue-500"></i>
                    Soporte incluido
                </div>
                <div class="flex items-center">
                    <i class="fas fa-sync-alt mr-2 text-purple-500"></i>
                    Cancela cuando quieras
                </div>
            </div>
        </div>
    </div>
</section>

@push('scripts')
<script>
function pricingComponent(){
    return {
        annual:false,
        init(){
            // restore preference
            const pref = localStorage.getItem('pricing_annual');
            if(pref === '1'){ this.annual = true; }
            // update prices initially
            this.updatePrices();
            this.$watch('annual', () => this.updatePrices());
        },
        persistPreference(){ localStorage.setItem('pricing_annual', this.annual ? '1':'0'); },
        formattedPrice(el){
            const monthlyRaw = (el.getAttribute('data-monthly')||'0').toString().replace(/[^0-9.]/g,'');
            const annualRaw = (el.getAttribute('data-annual')||monthlyRaw).toString().replace(/[^0-9.]/g,'');
            const selected = this.annual ? annualRaw : monthlyRaw;
            const num = parseFloat(selected);
            if(isNaN(num)) return '$0';
            return '$' + num.toString();
        },
        updatePrices(){
            this.$nextTick(() => {
                document.querySelectorAll('#pricing .price-value').forEach(el => {
                    const newVal = this.formattedPrice(el);
                    // animate number change
                    el.classList.add('scale-110');
                    setTimeout(()=>{ el.textContent = newVal; el.classList.remove('scale-110'); },150);
                });
            });
        },
        signupUrl(base, plan){
            try {
                const u = new URL(base, window.location.origin);
                u.searchParams.set('plan', plan);
                u.searchParams.set('period', this.annual ? 'annual':'monthly');
                return u.toString();
            } catch(e){ return base + '?plan=' + plan + '&period=' + (this.annual?'annual':'monthly'); }
        },
        selectPlan(plan){ localStorage.setItem('selected_plan', plan); }
    }
}
</script>
@endpush
