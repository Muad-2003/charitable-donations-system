<div class="mb-4"
     x-data="{
        open: false,
        search: '',
        selectedId: null,
        selectedName: '{{ $label }}',
        options: {{ collect($beneficiaries)->map(fn($b) => ['id' => $b->id, 'name' => $b->fullName])->toJson() }},
        get filteredOptions() {
            if (!this.search) return this.options;
            return this.options.filter(o => 
                o.name.toLowerCase().includes(this.search.toLowerCase())
            );
        },
        select(option) {
            this.selectedId = option.id;
            this.selectedName = option.name;
            this.open = false;
        }
     }">


    <x-label for="{{ $name }}" :required="true">{{ $label }}</x-label>

    {{-- القيمة اللي حتتبعت في الفورم --}}
    <input type="hidden" :name="`{{ $name }}`" :value="selectedId">

    {{-- الزر --}}
    <button type="button"
        @click="open = !open"
        class="relative pr-8 w-full rounded-2xl border border-slate-200 bg-slate-50 px-3 py-2.5 text-sm text-right flex items-center justify-between focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
        <span x-text="selectedName"></span>
        <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M19 9l-7 7-7-7"/>
        </svg>
    </button>

    {{-- القائمة --}}
    <div x-show="open" @click.outside="open = false" x-transition class="relative">
        <div class="absolute mt-1 w-full bg-white rounded-2xl shadow-lg border border-slate-100 z-50">

            {{-- البحث --}}
            <div class="p-2 border-b border-slate-100">
                <input type="text" x-model="search"
                       class="w-full rounded-xl border border-slate-200 px-2 py-1.5 text-xs text-right focus:outline-none focus:ring-1 focus:ring-emerald-500"
                       placeholder="ابحث عن المستفيد...">
            </div>

            {{-- الخيارات --}}
            <ul class="max-h-56 overflow-y-auto text-sm">
                <template x-for="option in filteredOptions" :key="option.id">
                    <li>
                        <button type="button"
                            @click="select(option)"
                            class="w-full text-right px-3 py-2 hover:bg-slate-50 text-slate-700 text-xs"
                            x-text="option.name"></button>
                    </li>
                </template>
                <li x-show="filteredOptions.length === 0"
                    class="px-3 py-2 text-xs text-slate-400">
                    لا توجد نتائج مطابقة
                </li>
            </ul>
        </div>
    </div>
</div>
