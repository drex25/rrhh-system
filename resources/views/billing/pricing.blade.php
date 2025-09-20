@extends('layouts.public')

@section('content')
<section class="py-24 bg-gradient-to-b from-white to-gray-50">
    <div class="max-w-7xl mx-auto px-6">
        <div class="text-center mb-16">
            <h1 class="text-4xl font-extrabold tracking-tight text-gray-900 mb-4">Planes y Precios</h1>
            <p class="text-gray-600 max-w-2xl mx-auto">Elige el plan que mejor se adapte a tu etapa. Puedes actualizar o cancelar cuando quieras.</p>
        </div>
        <div class="grid gap-10 md:grid-cols-3" x-data="{ annual:false }">
            <div class="col-span-full flex items-center justify-center gap-4 mb-4 select-none">
                <span :class="!annual ? 'font-semibold text-gray-900' : 'text-gray-600'">Mensual</span>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" class="sr-only peer" x-model="annual">
                    <div class="w-14 h-8 bg-gray-300 rounded-full peer-focus:outline-none peer peer-checked:bg-blue-500 transition"></div>
                    <div class="dot absolute left-1 top-1 w-6 h-6 bg-white rounded-full transition peer-checked:translate-x-6"></div>
                </label>
                <span :class="annual ? 'font-semibold text-gray-900' : 'text-gray-600'">Anual <span x-show="annual" class="ml-2 text-xs bg-green-100 text-green-700 px-2 py-0.5 rounded-full">Ahorra 20%</span></span>
            </div>
            @foreach($plans as $p)
            @php($annual = $p->yearly_price_cents ?? ($p->price_cents*12*0.8))
            <div class="relative rounded-3xl border {{ $p->code==='pro' ? 'border-blue-300 ring-2 ring-blue-100' : 'border-gray-200' }} bg-white shadow-sm hover:shadow-xl transition p-8 flex flex-col" x-data="{monthly:{{ $p->price_cents/100 }}, annual:{{ $annual/100 }} }">
                @if($p->code==='pro')
                    <span class="absolute -top-3 left-1/2 -translate-x-1/2 bg-blue-600 text-white text-xs font-semibold px-3 py-1 rounded-full shadow">Más Popular</span>
                @endif
                <h3 class="text-xl font-bold mb-2">{{ $p->name }}</h3>
                <p class="text-sm text-gray-500 mb-4 min-h-[48px]">{{ $p->description }}</p>
                <div class="mb-6">
                    <template x-if="{{ $p->price_cents }} === 0">
                        <span class="text-4xl font-extrabold text-gray-900">Gratis</span>
                    </template>
                    <template x-if="{{ $p->price_cents }} > 0">
                        <div>
                            <span class="text-4xl font-extrabold text-gray-900" x-text="'$'+(annual ? annual.toFixed(0) : monthly.toFixed(0))"></span>
                            <span class="text-sm text-gray-500" x-text="annual ? '/año' : '/mes'"></span>
                        </div>
                    </template>
                </div>
                <ul class="text-sm space-y-2 mb-6 flex-1">
                    @foreach(($p->features ?? []) as $f)
                        <li class="flex items-start gap-2"><i class="fa-solid fa-check text-green-500 mt-0.5"></i><span>{{ $f }}</span></li>
                    @endforeach
                </ul>
                <form method="POST" action="{{ route('billing.subscribe') }}" class="mt-auto">
                    @csrf
                    <input type="hidden" name="plan" value="{{ $p->code }}">
                    <input type="hidden" name="interval" :value="annual ? 'annual' : 'monthly'">
                    <button class="w-full py-3 rounded-xl font-semibold text-white {{ $p->code==='pro' ? 'bg-blue-600 hover:bg-blue-700' : 'bg-gray-900 hover:bg-gray-800' }} transition">Elegir {{ $p->name }}</button>
                </form>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endsection
