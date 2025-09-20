@extends('layouts.admin')

@section('content')
<div class="mb-6">
  <h1 class="text-2xl font-semibold text-gray-800 dark:text-gray-100 flex items-center gap-2">
    <span class="material-icons-outlined text-3xl">business</span>
    Companies
  </h1>
  <p class="text-sm text-gray-500 mt-1">Manage the companies linked to your user. Switch context or review plan usage.</p>
</div>

<div x-data="companiesPage" x-cloak>
  <div class="flex flex-wrap gap-3 mb-6 items-center">
    <button @click="refresh()" class="inline-flex items-center px-3 py-1.5 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded shadow-sm text-sm hover:bg-gray-50 dark:hover:bg-gray-700">
      <span class="material-icons-outlined text-base mr-1">refresh</span> Refresh
    </button>
    <button @click="openCreate()" class="inline-flex items-center px-3 py-1.5 bg-blue-600 text-white border border-blue-700 rounded shadow-sm text-sm hover:bg-blue-700">
      <span class="material-icons-outlined text-base mr-1">add_business</span> New Company
    </button>
  </div>

  <template x-if="loading">
    <div class="text-gray-500 text-sm">Loading companies...</div>
  </template>

  <template x-if="!loading && companies.length === 0">
    <div class="text-gray-500 text-sm flex flex-col items-start gap-3">
      <span>No companies found for your account.</span>
      <button @click="openCreate()" class="inline-flex items-center px-3 py-1.5 bg-blue-600 text-white rounded text-xs hover:bg-blue-700">
        <span class="material-icons-outlined text-base mr-1">add</span> Create Your First Company
      </button>
    </div>
  </template>

  <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5" x-show="!loading">
    <template x-for="c in companies" :key="c.id">
      <div class="p-4 rounded border bg-white dark:bg-gray-800 relative">
        <div class="flex justify-between items-start mb-2">
          <h2 class="font-semibold" x-text="c.name"></h2>
          <span class="text-xs px-2 py-0.5 rounded bg-blue-100 text-blue-700" x-text="c.plan ?? 'N/A'"></span>
        </div>
        <p class="text-xs text-gray-500 mb-3" x-text="'Created: ' + (new Date(c.created_at)).toLocaleDateString()"></p>

        <div class="text-xs mb-2" x-show="c.id === current?.id">
          <span class="inline-flex items-center px-2 py-0.5 rounded bg-green-100 text-green-700">Current</span>
        </div>

        <div class="flex gap-2">
          <button @click="switchTo(c.id)" :disabled="c.id === current?.id" class="px-2.5 py-1 text-xs rounded border bg-white dark:bg-gray-700 disabled:opacity-40">
            Switch
          </button>
          <button @click="viewLimits(c.id)" class="px-2.5 py-1 text-xs rounded border bg-white dark:bg-gray-700">
            Limits
          </button>
        </div>
      </div>
    </template>
  </div>

  <!-- Limits Modal -->
  <div x-show="showLimits" style="display:none" class="fixed inset-0 z-40 flex items-center justify-center">
    <div class="absolute inset-0 bg-black/40" @click="showLimits=false"></div>
    <div class="relative z-50 bg-white dark:bg-gray-800 rounded-lg shadow-xl w-full max-w-xl p-6">
      <h3 class="text-lg font-semibold mb-4">Plan Limits</h3>
      <template x-if="!limitsData">
        <div class="text-sm text-gray-500">Loading...</div>
      </template>
      <template x-if="limitsData">
        <div>
          <div class="flex items-center gap-2 mb-4">
            <span class="text-sm font-medium">Plan:</span>
            <span class="text-xs px-2 py-0.5 rounded bg-blue-100 text-blue-700" x-text="limitsData.plan"></span>
          </div>
          <div class="space-y-3 max-h-72 overflow-y-auto pr-1">
            <template x-for="(limit, key) in limitsData.limits" :key="key">
              <div class="border rounded p-3">
                <div class="flex justify-between text-xs mb-1">
                  <span class="font-medium capitalize" x-text="key.replace('_',' ')"></span>
                  <span x-text="(limitsData.usage[key] ?? 0) + ' / ' + (limit ?? '∞')"></span>
                </div>
                <div class="w-full h-2 bg-gray-200 dark:bg-gray-700 rounded overflow-hidden">
                  <div class="h-2 bg-blue-500" :style="progressStyle(key)"></div>
                </div>
                <p class="mt-1 text-[10px] text-gray-500" x-show="limitsData.remaining[key] !== null" x-text="'Remaining: ' + limitsData.remaining[key]"></p>
              </div>
            </template>
          </div>
        </div>
      </template>
      <div class="mt-6 flex justify-end gap-2">
        <button @click="showLimits=false" class="px-3 py-1.5 text-xs rounded border">Close</button>
      </div>
    </div>
  </div>

  <!-- Create Company Modal -->
  <div x-show="showCreate" style="display:none" class="fixed inset-0 z-40 flex items-center justify-center">
    <div class="absolute inset-0 bg-black/40" @click="showCreate=false"></div>
    <div class="relative z-50 bg-white dark:bg-gray-800 rounded-lg shadow-xl w-full max-w-md p-6">
      <h3 class="text-lg font-semibold mb-4">Create Company</h3>
      <form @submit.prevent="create()" class="space-y-4">
        <div>
          <label class="block text-xs font-medium mb-1">Name</label>
          <input type="text" x-model="form.name" required class="w-full px-2 py-1.5 text-sm rounded border bg-white dark:bg-gray-900" placeholder="Acme Inc" />
        </div>
        <div>
          <label class="block text-xs font-medium mb-1">Plan (initial)</label>
            <select x-model="form.plan" class="w-full px-2 py-1.5 text-sm rounded border bg-white dark:bg-gray-900">
              <option value="free">Free</option>
              <option value="pro">Pro</option>
            </select>
        </div>
        <div class="flex justify-end gap-2 pt-2">
          <button type="button" @click="showCreate=false" class="px-3 py-1.5 text-xs rounded border">Cancel</button>
          <button type="submit" class="px-3 py-1.5 text-xs rounded bg-blue-600 text-white" x-text="creating ? 'Creating...' : 'Create'"></button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
  document.addEventListener('alpine:init', () => {
    Alpine.data('companiesPage', () => ({
      loading: true,
      companies: [],
      current: null,
      showLimits:false,
      limitsData:null,
      showCreate:false,
      creating:false,
      form:{name:'', plan:'free'},
      async init(){
        await Promise.all([this.fetchCompanies(), this.fetchCurrent()]);
      },
      openCreate(){ this.showCreate = true; this.form={name:'',plan:'free'}; },
      async create(){
        if(!this.form.name.trim()) return;
        this.creating = true;
        try {
          const {data} = await axios.post('/api/companies', this.form);
          // Switch to the new company immediately
          await axios.post('/api/company/switch', {company_id:data.data.id});
          this.showCreate=false; await this.refresh();
        } catch(e){ console.error(e); alert('Create failed'); }
        this.creating = false;
      },
      async fetchCompanies(){
        this.loading = true;
        try { const {data} = await axios.get('/api/companies/mine'); this.companies = data.data || []; } catch(e){ console.error(e); }
        this.loading = false;
      },
      async fetchCurrent(){
        try { const {data} = await axios.get('/api/company/current'); this.current = data.data || null; } catch(e){ console.error(e); }
      },
      async refresh(){ await Promise.all([this.fetchCompanies(), this.fetchCurrent()]); },
      async switchTo(id){
        if(!confirm('Switch to this company?')) return;
        try { await axios.post('/api/company/switch', {company_id:id}); await this.refresh(); } catch(e){ console.error(e); alert('Switch failed'); }
      },
      async viewLimits(id){
        this.showLimits = true; this.limitsData = null;
        try { const {data} = await axios.get('/api/company/limits'); this.limitsData = data.data; } catch(e){ console.error(e); }
      },
      progressStyle(key){
        if(!this.limitsData) return 'width:0%';
        const limit = this.limitsData.limits[key];
        if(limit === null) return 'width:100%';
        const used = this.limitsData.usage[key] ?? 0;
        const pct = Math.min(100, (used/limit)*100);
        return `width:${pct}%`;
      }
    }))
  })
</script>
@endpush
