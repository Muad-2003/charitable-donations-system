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

<x-layout>
    <div class="flex justify-end">
        <x-link href="{{ route('home.index') }}">
            ←الرجوع إلى الرئيسية
        </x-link>
    </div>


    
    <section class="grid gap-6 lg:grid-cols-3">

        <!-- صندوق التبرع -->
        {{-- <div class="lg:col-span-1">
            <!-- صندوق التبرع -->
            <div x-data="{ amount: '' }" class="bg-white rounded-3xl shadow-sm border border-slate-100 p-5 space-y-4">
                <h2 class="text-sm font-semibold text-slate-900">
                    التبرع لهذه الحالة
                </h2>

                <!-- رصيدك الحالي -->
                @auth('web')
                <div class="rounded-2xl bg-emerald-50 px-4 py-3 text-sm">
                    <div class="text-slate-600 text-xs">رصيدك الحالي</div>
                    <div class="text-emerald-700 font-bold text-lg">
                        {{ number_format(auth()->user()->wallet->balance, 2) }}
                    </div>
                </div>
                @else
                <div class="rounded-2xl bg-emerald-50 px-4 py-3 text-sm">
                    <div class="text-slate-600 text-xs">رصيدك الحالي</div>
                    <div class="text-emerald-700 font-bold text-lg">
                        لا يوجد رصيد
                    </div>
                </div>
                @endauth


                <!-- مبلغ التبرع -->
                <form action="{{ route('wallet.donate') }}" method="POST" x-data="{ loading: false }"
                    @submit="loading = true">
                    @csrf

                    <input type="hidden" name="donation_case_id" value="{{ $case->id }}" />
                    <div class="space-y-2 mb-2">
                        <label class="block text-xs font-medium text-slate-600">
                            مبلغ التبرع (د.ل)
                        </label>
                        <x-text-input type="number" name="amount" x-model="amount" placeholder="أدخل المبلغ" />
                    </div>



                    <!-- زر التبرع -->
                    @auth('web')
                    <x-button x-bind:disabled="loading" class="w-full disabled:opacity-60" type="submit">
                        <span x-show="!loading">تبرّع الآن</span>

                        <span x-show="loading" class="flex items-center gap-2">
                            <svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                    stroke-width="4">
                                </circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path>
                            </svg>
                            جاري التبرع...
                        </span>

                    </x-button>
                    @else
                    <p class="text-[11px] text-slate-500 text-center">
                        لا يمكنك التبرع إلا بعد <x-link class="font-medium underline" href="{{ route('login') }}">تسجيل
                            الدخول</x-link>.
                    </p>
                    @endauth
                </form>

            </div>

        </div> --}}

        <div x-data="{
        amount: '',
        openConfirm: false,
        loading: false,
        balance: {{ auth()->check() ? auth()->user()->wallet->balance : 0 }}
    }" class="bg-white rounded-3xl shadow-sm border border-slate-100 p-5 space-y-4">

            <h2 class="text-sm font-semibold text-slate-900">
                التبرع لهذه الحالة
            </h2>

            <!-- balance -->
            <div class="rounded-2xl bg-emerald-50 px-4 py-3 text-sm">
                <div class="text-slate-600 text-xs">رصيدك الحالي</div>
                <div class="text-emerald-700 font-bold text-lg">
                    <span x-text="balance.toFixed(2)"></span> د.ل
                </div>
            </div>

            <form x-ref="donationForm" action="{{ route('wallet.donate') }}" method="POST"
                @submit.prevent="openConfirm = true">
                @csrf

                <input type="hidden" name="donation_case_id" value="{{ $case->id }}">

                <label class="block text-xs font-medium text-slate-600 mb-2">
                    مبلغ التبرع (د.ل)
                </label>

                <input type="number" name="amount" min="1" x-model.number="amount" placeholder="أدخل المبلغ"
                    class="w-full mb-2 rounded-xl border border-slate-200 bg-slate-50 px-3 py-2 text-smfocus:outline-none focus:ring-2 focus:ring-emerald-500" />

                @auth('web')
                    <x-button class="w-full mt-3">
                        تبرّع الآن
                    </x-button>
                @else
                    <p class="text-[11px] text-slate-500 text-center">
                        لا يمكنك التبرع إلا بعد
                        <x-link class="font-medium underline" href="{{ route('login') }}">
                            تسجيلالدخول
                        </x-link>.
                    </p>
                @endauth
                
            </form>

            <!-- the confirm dialog -->
            <div x-show="openConfirm" x-cloak x-transition
                class="fixed inset-0 z-50 flex items-center justify-center bg-black/40">
                <div @click.outside="openConfirm = false" class="bg-white w-full max-w-sm rounded-2xl p-6 space-y-4">
                    <h3 class="text-lg font-semibold text-slate-900 text-center">
                        تأكيد التبرع
                    </h3>

                    <div class="text-sm space-y-2 text-slate-700">
                        <div class="flex justify-between">
                            <span>مبلغ التبرع:</span>
                            <span class="font-semibold text-emerald-600">
                                <span x-text="amount"></span> د.ل
                            </span>
                        </div>

                        <div class="flex justify-between">
                            <span>رصيدك الحالي:</span>
                            <span>
                                <span x-text="balance.toFixed(2)"></span> د.ل
                            </span>
                        </div>

                        <div class="flex justify-between border-t pt-2">
                            <span>الرصيد بعد التبرع:</span>
                            <span class="font-semibold"
                                :class="(balance - amount) < 0 ? 'text-red-600' : 'text-slate-900'">
                                <span x-text="(balance - amount).toFixed(2)"></span> د.ل
                            </span>
                        </div>
                    </div>

                    <!-- the button -->
                    <div class="flex gap-2 pt-3">
                        <button type="button" @click="openConfirm = false"
                            class="flex-1 rounded-xl border px-4 py-2 text-sm hover:bg-slate-50">
                            إلغاء
                        </button>

                        <button type="button" @click=" loading = true; $refs.donationForm.submit(); "
                        :disabled="loading || amount <= 0 || amount > balance"
                            class="flex-1 rounded-xl bg-emerald-600 text-white px-4 py-2 text-sm disabled:opacity-50">
                            <span x-show="!loading">تأكيد التبرع</span>
                            <span x-show="loading">جاري التنفيذ...</span>
                        </button>
                    </div>
                </div>
            </div>

        </div>


        <!-- الصورة واسم الحالة -->
        <div class="lg:col-span-2 space-y-4">
            <div class="relative rounded-3xl overflow-hidden bg-slate-200 h-64">
                <img src="{{ asset('storage/' . $case->img_url) }}" alt="صورة الحالة"
                    class="w-full h-full object-cover">
                <span
                    class="absolute top-3 right-3 px-3 py-1 rounded-full text-xs font-semibold bg-emerald-600 text-white">
                    {{ $case->type }}
                </span>
            </div>

            <div class="flex items-center justify-between gap-3">
                <h1 class="text-xl md:text-2xl font-semibold text-slate-900">
                    {{ $case->title }}
                </h1>
            </div>

            <!-- شريط التقدم + المبلغ -->
            <div class="mt-2 bg-white rounded-2xl border border-slate-100 p-4 space-y-3">
                <div class="flex items-center justify-between text-sm">
                    <span class="text-slate-600">المبلغ المحصّل:</span>
                    <span class="font-semibold text-emerald-700">{{ $case->current_amount }} د.ل</span>
                </div>

                <div class="h-2 rounded-full bg-slate-100 overflow-hidden">
                    <div class="h-full bg-slate-900" style="width: {{ $progress }}%"></div>
                </div>

                <div class="flex flex-wrap items-center justify-between text-[11px] text-slate-600 gap-2">
                    <div>
                        <span class="font-medium">الهدف:</span>
                        <span>{{ $case->target_amount }} د.ل</span>
                    </div>
                    <div>
                        <span class="font-medium">المتبقي:</span>
                        <span>{{ $case->target_amount - $case->current_amount }} د.ل</span>
                    </div>
                    <div class="text-emerald-700 font-semibold">
                        {{ $progressFormatted }}%
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- باقي تفاصيل الحالة -->
    <section class="grid gap-6 lg:grid-cols-3">

        <!-- يمين: تفاصيل النصوص -->
        <div class="lg:col-span-4 space-y-4">

            <!-- تفاصيل الحالة -->
            <div class="bg-white rounded-2xl border border-slate-100 p-4 md:p-5">
                <h2 class="text-sm font-semibold text-slate-900 mb-3">
                    تفاصيل الحالة
                </h2>
                <p class="text-xs md:text-sm leading-relaxed text-slate-600">
                    {{ $case->description }}
                </p>
            </div>

            <!-- معلومات المستفيد -->
            <div class="bg-white rounded-2xl border border-slate-100 p-4 md:p-5">
                <h2 class="text-sm font-semibold text-slate-900 mb-3">
                    معلومات المستفيد
                </h2>

                <div class="space-y-2 text-xs md:text-sm text-slate-700">
                    <div class="flex justify-between">
                        <span class="text-slate-500">اسم المستفيد:</span>
                        <span class="font-medium">{{ $case->beneficiary->fullName }}</span>
                    </div>
                    <div class="my-4 bg-slate-200 h-px w-full border-b border-slate-300"></div>

                    <div class="flex justify-between">
                        <span class="text-slate-500">المدينة:</span>
                        <span class="font-medium">{{ $case->beneficiary->address }}</span>
                    </div>
                    <div class="my-2 bg-slate-200 h-px w-full border-b border-slate-300"></div>

                    <div class="flex justify-between">
                        <span class="text-slate-500">نوع الحالة:</span>
                        <span class="font-medium">{{ $case->type }}</span>
                    </div>
                </div>
            </div>

            <!-- المستندات المرفقة -->
            {{-- <div class="bg-white rounded-2xl border border-slate-100 p-4 md:p-5 space-y-3">
                <h2 class="text-sm font-semibold text-slate-900">
                    المستندات المرفقة
                </h2>

                <div class="space-y-1 text-xs md:text-sm">
                    <button
                        class="w-full flex items-center justify-between rounded-xl border border-slate-200 bg-slate-50 px-3 py-2 hover:bg-slate-100">
                        <span class="flex items-center gap-2">
                            📄
                            <span>doc1.pdf</span>
                        </span>
                        <span class="text-slate-500 text-[11px]">عرض / تحميل</span>
                    </button>

                    <button
                        class="w-full flex items-center justify-between rounded-xl border border-slate-200 bg-slate-50 px-3 py-2 hover:bg-slate-100">
                        <span class="flex items-center gap-2">
                            📄
                            <span>doc2.pdf</span>
                        </span>
                        <span class="text-slate-500 text-[11px]">عرض / تحميل</span>
                    </button>
                </div>
            </div> --}}

            <!-- آخر تحديث -->
            <div
                class="bg-white rounded-2xl border border-slate-100 p-3 text-[11px] text-slate-500 flex items-center justify-between">
                <span>تم إضافة الحالة بتاريخ:</span>
                <span>{{ $case->created_at->format('Y/m/d') }}</span>
            </div>

        </div>

        <!-- يسار: ممكن تضيف شيء إضافي لاحقًا (تقارير، تبرعات سابقة، الخ) -->
        <div class="lg:col-span-1 space-y-4">
            <!-- مكان فارغ لأي شي تحب تضيفه مستقبلاً -->
        </div>

    </section>
</x-layout>