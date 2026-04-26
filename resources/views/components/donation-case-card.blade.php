@php
    // احسب النسبة %
    $progress = 0;
    if ($case->target_amount > 0) {
        $progress = ($case->current_amount / $case->target_amount) * 100;
    }

    // لا تتعدى 100% حتى لو في زيادة
    $progress = min($progress, 100);

    $progressFormatted = number_format($progress, 0); // 0 = بدون فاصلة
@endphp

@if ($case->status == 'active')
    <article class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden flex flex-col">
        <div class="relative h-44">
            <img src="{{ asset('storage/' . $case->img_url) }}" class="w-full h-full object-cover" alt="">
            <span class="absolute top-3 right-3 px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-600 text-white">
                {{ $case->type }}
            </span>
        </div>

        <div class="p-4 flex flex-col justify-between flex-1">
            <h3 class="font-semibold text-slate-900 text-sm sm:text-base">
                {{ $case->title }}
            </h3>
            <p class="text-xs sm:text-sm text-slate-500">
                {{ $case->description }}
            </p>

            {{-- التقدم --}}
            <div class="mt-2 space-y-1">
                <div class="flex items-center justify-between text-xs text-slate-500">
                    <span>المجموع: {{ $case->current_amount }} د.ل</span>
                    <span>الهدف: {{ $case->target_amount }} د.ل</span>
                </div>

                <div class="h-2 rounded-full bg-slate-100 overflow-hidden">
                    <div class="h-full bg-emerald-500" style="width: {{ $progress }}%"></div>
                </div>

                <div class="flex justify-between text-[11px] text-slate-500">
                    <span>{{ $progressFormatted }}٪ مكتمل</span>
                    <span>المستفيد: {{ $case->beneficiary->fullName }}</span>
                </div>
            </div>


            {{ $slot }}
        </div>
    </article>
@endif