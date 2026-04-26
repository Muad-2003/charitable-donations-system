<x-layout-dashboard>


    {{-- عنوان + كروت الإحصائيات --}}
    <div>
        <h1 class="text-2xl font-semibold text-slate-900 mb-4">
            لوحة التحكم
        </h1>

        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">

            {{-- إجمالي التبرعات --}}
            <div class="bg-white rounded-3xl border border-slate-100 shadow-sm px-4 py-4 flex flex-col justify-between">
                <div class="flex items-center justify-between mb-3">
                    <div class="text-sm text-slate-500">إجمالي التبرعات</div>
                    <div class="w-9 h-9 rounded-full bg-emerald-50 flex items-center justify-center text-emerald-600">
                        $
                    </div>
                </div>
                <div class="text-lg font-semibold text-slate-900">
                    {{ number_format($totalDonations, 2) }} د.ل
                </div>
            </div>

            {{-- عدد المتبرعين --}}
            <div class="bg-white rounded-3xl border border-slate-100 shadow-sm px-4 py-4 flex flex-col justify-between">
                <div class="flex items-center justify-between mb-3">
                    <div class="text-sm text-slate-500">عدد المتبرعين</div>
                    <div class="w-9 h-9 rounded-full bg-blue-50 flex items-center justify-center text-blue-500">
                        👥
                    </div>
                </div>
                <div class="text-lg font-semibold text-slate-900">
                    {{ number_format($donorsCount) }}
                </div>
            </div>

            {{-- الحالات النشطة --}}
            <div class="bg-white rounded-3xl border border-slate-100 shadow-sm px-4 py-4 flex flex-col justify-between">
                <div class="flex items-center justify-between mb-3">
                    <div class="text-sm text-slate-500">الحالات النشطة</div>
                    <div class="w-9 h-9 rounded-full bg-violet-50 flex items-center justify-center text-violet-500">
                        📄
                    </div>
                </div>
                <div class="text-lg font-semibold text-slate-900">
                    {{ number_format($activeCasesCount) }}
                </div>
            </div>

            {{-- المبلغ المحصل --}}
            {{-- <div class="bg-white rounded-3xl border border-slate-100 shadow-sm px-4 py-4 flex flex-col justify-between">
                <div class="flex items-center justify-between mb-3">
                    <div class="text-sm text-slate-500">المبلغ المحصل</div>
                    <div class="w-9 h-9 rounded-full bg-amber-50 flex items-center justify-center text-amber-500">
                        📈
                    </div>
                </div>
                <div class="text-lg font-semibold text-slate-900">
                    27,800 د.ل
                </div>
            </div> --}}

        </div>
    </div>

    {{-- آخر المعاملات --}}
    <section class="bg-white rounded-3xl border border-slate-100 shadow-sm p-4 mt-2">
        <h2 class="text-base font-semibold text-slate-900 mb-3 text-right">
            آخر المعاملات
        </h2>

        <div class="space-y-2 text-sm">

            @forelse ($transactions as $transaction)
                <div class="flex items-center justify-between rounded-2xl bg-slate-50 px-4 py-2">

                    {{-- المبلغ --}}
                    <div class="font-semibold 
                        {{ $transaction->type === 'deposit' ? 'text-emerald-600' : 'text-red-500' }}">
                        {{ number_format($transaction->amount, 2) }} د.ل
                    </div>

                    {{-- التفاصيل --}}
                    <div class="flex-1 px-4 text-right">
                        <div class="font-medium text-slate-800">
                            {{ $transaction->wallet->walletable->fullName ?? 'غير معروف' }}
                        </div>
                        <div class="text-[11px] text-slate-500">
                            @switch($transaction->type)
                                @case('deposit') شحن @break
                                @case('withdraw') سحب @break
                                @default عملية
                            @endswitch

                            @if($transaction->donationCase)
                                - {{ $transaction->description }}
                            @endif
                        </div>
                    </div>

                    {{-- التاريخ --}}
                    <div class="text-left text-[11px] text-slate-500">
                        {{ $transaction->created_at->format('Y/m/d') }}
                    </div>
                </div>
            @empty
                <div class="text-center text-sm text-slate-500 py-4">
                    لا توجد معاملات بعد
                </div>
            @endforelse
        </div>
    </section>

</x-layout-dashboard>