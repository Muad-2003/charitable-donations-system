<x-layout-dashboard>

    
    <div class="flex items-center justify-between mb-2">
        <h1 class="text-2xl font-semibold text-slate-900">
            إدارة المعاملات
        </h1>

        <div x-data="">
            <form x-ref="filters" action="{{ route('transactions.index') }}" method="GET">

                <div class="flex items-center gap-2">
                    <x-text-input type="text" placeholder="بحث..." name="search" value="{{ request('search') }}"
                        form-ref="filters" />


                    <button type="submit" class="bg-emerald-500 text-white text-sm px-2 py-1 rounded-full">
                        بحث
                    </button>
                </div>
            </form>

        </div>


    </div>

    {{-- table of transaction --}}
    <section class="bg-white rounded-3xl border border-slate-100 shadow-sm p-4 mt-2">
        <div class="flex items-center justify-between mb-3">
            <h2 class="text-sm font-semibold text-slate-900">
                قائمة المعاملات
            </h2>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm text-right">
                <thead>
                    <tr class="border-b border-slate-100 text-xs text-slate-500 text-center">
                        <th class="py-3 px-3">رقم العملية</th>
                        <th class="py-3 px-3">نوع العملية</th>
                        <th class="py-3 px-3">المبلغ</th>
                        <th class="py-3 px-3">صاحب المحفظة</th>
                        <th class="py-3 px-3">من محفظة</th>
                        <th class="py-3 px-3">الي محفظة</th>
                        <th class="py-3 px-3">رقم الحالة</th>
                        <th class="py-3 px-3">الوصف</th>
                        <th class="py-3 px-3">تاريخ العملية</th>
                    </tr>
                </thead>
                <tbody class="text-slate-700 text-sm">

                    @forelse ($transactions as $transaction)
                        <tr class="border-b border-slate-50 hover:bg-slate-50/70 text-center">

                            
                            <td class="py-2 px-2 text-xs font-mono">
                                {{ $transaction->transaction_number ?? '-' }}
                            </td>

                            
                            <td class="py-2 px-2 text-xs">
                                @switch($transaction->type)
                                    @case('deposit')
                                        <span class="text-emerald-600 font-medium">شحن</span>
                                        @break
                                    @case('withdraw')
                                        <span class="text-red-500 font-medium">سحب</span>
                                        @break
                                    @default
                                        <span class="text-slate-600">تحويل</span>
                                @endswitch
                            </td>

                            
                            <td class="py-2 px-2 text-xs font-semibold">
                                {{ number_format($transaction->amount, 2) }} د.ل
                            </td>

                            
                            <td class="py-2 px-2 text-xs">
                                {{ $transaction->wallet->walletable->fullName ?? 'غير معروف' }}
                            </td>

                            
                            <td class="py-2 px-2 text-xs">
                                {{ $transaction->fromWallet->walletable->fullName ?? '-' }}
                            </td>

                            
                            <td class="py-2 px-2 text-xs">
                                {{ $transaction->toWallet->walletable->fullName ?? '-' }}
                            </td>

                            
                            <td class="py-2 px-2 text-xs">
                                @if($transaction->donationCase)
                                    <span class="text-emerald-600">
                                        #{{ $transaction->donationCase->id }}
                                    </span>
                                @else
                                    -
                                @endif
                            </td>

                            <td class="py-2 px-2 text-xs">
                                {{ $transaction->description ?? '-' }}
                            </td>

                            
                            <td class="py-2 px-2 text-xs text-slate-500">
                                {{ $transaction->created_at->format('Y/m/d H:i') }}
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="py-4 text-center text-slate-500">
                                لا توجد معاملات
                            </td>
                        </tr>
                    @endforelse

                </tbody>
            </table>
            
            <div class="mt-4">
                {{ $transactions->withQueryString()->links() }}
            </div>
        </div>
    </section>
</x-layout-dashboard>