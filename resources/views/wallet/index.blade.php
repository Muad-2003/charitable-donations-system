<x-layout>
    
    <div class="flex items-center justify-between mb-2">
        <h1 class="text-2xl font-semibold text-slate-900">
            المحفظة الإلكترونية
        </h1>

        <button @click="openTopup = true"
            class="inline-flex items-center gap-2 rounded-full bg-slate-900 text-white text-sm px-4 py-2 hover:bg-black">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            شحن المحفظة
        </button>
    </div>

    
    <section class="grid gap-4 md:grid-cols-2">
        
        <div class="bg-white rounded-3xl border border-slate-100 shadow-sm px-6 py-4 flex items-center justify-between">
            <div class="text-sm text-slate-500">
                الرصيد المتاح
            </div>
            <div class="text-lg font-semibold text-emerald-600">
                {{ number_format(auth()->user()->wallet->balance, 2) }} د.ل
            </div>
        </div>

    </section>

    
    <section class="bg-white rounded-3xl border border-slate-100 shadow-sm p-4 mt-4">
        <div class="flex items-center justify-between mb-3">
            <h2 class="text-sm font-semibold text-slate-900">
                سجل المعاملات
            </h2>
        </div>

        <div class="divide-y divide-slate-100">
            @forelse ($transctions as $transction)
                @if ($transction->type === 'deposit')
                    <div class="flex items-center justify-between py-3 text-sm">
                        <div class="text-emerald-600 font-semibold">
                            د.ل {{ number_format($transction->amount, 2) }}+
                            <span class="inline-block align-middle text-xs">↓</span>
                        </div>
                        <div class="flex-1 px-4 text-right space-y-0.5">
                            <div class="font-medium text-slate-800">
                                {{ $transction->description }}
                            </div>
                            <div class="text-[11px] text-slate-500">
                                نوع العملية: شحن
                            </div>
                        </div>
                        <div class="text-left text-[11px] text-slate-500 space-y-1">
                            <div>{{ $transction->created_at->format('Y/m/d') }}</div>
                            <div>{{ $transction->created_at->format('h:i A') }}</div>
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full bg-slate-900 text-white text-[10px]">
                                مكتملة
                            </span>
                        </div>
                    </div>
                @elseif ($transction->type === 'withdraw')
                    <div class="flex items-center justify-between py-3 text-sm">
                        <div class="text-red-500 font-semibold">
                            د.ل {{ number_format($transction->amount, 2) }}-
                            <span class="inline-block align-middle text-xs">↑</span>
                        </div>
                        <div class="flex-1 px-4 text-right space-y-0.5">
                            <div class="font-medium text-slate-800">
                                تبرع-{{ $transction->description }}
                            </div>
                            <div class="text-[11px] text-slate-500">
                                نوع العملية: سحب
                            </div>
                        </div>
                        <div class="text-left text-[11px] text-slate-500 space-y-1">
                            <div>{{ $transction->created_at->format('Y/m/d') }}</div>
                            <div>{{ $transction->created_at->format('h:i A') }}</div>
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full bg-slate-900 text-white text-[10px]">
                                مكتملة
                            </span>
                        </div>
                    </div>
                @endif
            @empty
                <p>لا يوجد اي معاملات</p>
            @endforelse

        </div>
    </section>

    {{--  the model --}}
    <div x-show="openTopup" x-cloak x-transition.opacity class="fixed inset-0 z-50 flex items-center justify-center">

        {{-- the backround --}}
        <div class="absolute inset-0 bg-black/40" @click="openTopup = false"></div>

        
        <div x-transition class="relative bg-white rounded-3xl shadow-xl w-full max-w-md mx-4 p-6 space-y-4">

            <h2 class="text-base font-semibold text-slate-900 mb-1">
                شحن المحفظة
            </h2>
            <p class="text-xs text-slate-500 mb-3">
                استخدم بطاقة شحن مسبقة الدفع لإضافة رصيد إلى محفظتك.
            </p>

            {{-- form top-up --}}
            <form action="{{ route('wallet.top_up') }}" method="POST" x-data="{ loading: false }"
                @submit="loading = true">
                @csrf
                
                <div class="space-y-2 mb-3">
                    <label class="block text-xs font-medium text-slate-600">
                        كود البطاقة
                    </label>
                    <div class="flex items-center gap-2 rounded-xl border border-slate-200 bg-slate-50 px-3 py-2">
                        <input type="number" name="code" min="0" x-model="topupAmount"
                            placeholder="أدخل كود البطاقة (مثال: 123456789)"
                            class="flex-1 bg-transparent border-none focus:outline-none text-sm text-right" />
                        <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.598 1M12 8V6m0 10v2m8-8a8 8 0 11-16 0 8 8 0 0116 0z" />
                        </svg>
                    </div>
                </div>



                <div class="flex items-center justify-between pt-2">
                    <button type="button" class="text-xs text-slate-500 hover:text-slate-700"
                        @click="openTopup = false">
                        إلغاء
                    </button>

                    <x-button type="submit" x-bind:disabled="loading" class="disabled:opacity-60">
                        <span x-show="!loading">شحن المحفظة</span>

                        <span x-show="loading" class="flex items-center gap-2">
                            <svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                    stroke-width="4">
                                </circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path>
                            </svg>
                            جاري شحن المحفظة...
                        </span>
                    </x-button>

                </div>
            </form>
        </div>
    </div>
</x-layout>