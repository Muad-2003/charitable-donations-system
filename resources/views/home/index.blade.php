<x-layout>

    {{-- البانر العلوي --}}
    <section class="rounded-3xl bg-emerald-600 text-white px-6 py-8 sm:px-10 sm:py-10">
        <div class="max-w-2xl space-y-3">
            <h1 class="text-2xl sm:text-3xl font-bold">
                مرحبًا بك في منصة التبرعات الخيرية
            </h1>
            <p class="text-sm sm:text-base text-emerald-50">
                ساهم في دعم المحتاجين من خلال التبرع للحالات الموثوقة والمعتمدة من هيئة الأوقاف.
            </p>
            <div class="flex flex-wrap gap-2 text-xs sm:text-sm mt-4">
                <span class="px-3 py-1 rounded-full bg-emerald-500/70">حالات عاجلة</span>
                <span class="px-3 py-1 rounded-full bg-emerald-500/70">كفالة أيتام</span>
                <span class="px-3 py-1 rounded-full bg-emerald-500/70">مشاريع وقفية</span>
            </div>
        </div>
    </section>



    {{-- أرقام المنصة --}}
    <section class="py-14">
        <div class="max-w-7xl mx-auto px-4">

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 text-center">

                <div class="bg-white rounded-3xl p-6 shadow-lg">
                    <div class="text-emerald-700 text-2xl font-bold">
                        {{ number_format($stats['transactions_count']) }}
                    </div>
                    <p class="text-xs text-slate-500 mt-1">
                        عدد العمليات الرقمية
                    </p>
                </div>

                <div class="bg-white rounded-3xl p-6 shadow-lg">
                    <div class="text-emerald-700 text-2xl font-bold">
                        {{ number_format($stats['completed_cases']) }}
                    </div>
                    <p class="text-xs text-slate-500 mt-1">
                        الفرص المكتملة
                    </p>
                </div>

                <div class="bg-white rounded-3xl p-6 shadow-lg">
                    <div class="text-emerald-700 text-2xl font-bold">
                        {{ number_format($stats['active_cases']) }}
                    </div>
                    <p class="text-xs text-slate-500 mt-1">
                        عدد الفرص النشطة
                    </p>
                </div>

            </div>

        </div>
    </section>



    {{-- الفلاتر --}}
    <section class="space-y-4">
        <div class="mx-auto max-w-2xl text-center">
            <h2 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">احدث الحالات</h2>
            <p class="mt-2 text-lg leading-8 text-gray-600">
                الحالات المعروضة هي اخر الحالات التي تم اضافتها حديثا
            </p>
            <div class="mt-10 flex items-center justify-center gap-x-6">

                <x-link-button href="{{ route('home.index', ['type' => '']) }}" :active="!request('type')">
                    جميع الحالات
                </x-link-button>

                <x-link-button href="{{ route('home.index', ['type' => 'وقف']) }}" :active="request('type') == 'وقف'">
                    وقف
                </x-link-button>

                <x-link-button href="{{ route('home.index', ['type' => 'يتيم']) }}" :active="request('type') == 'يتيم'">
                    يتيم
                </x-link-button>

                <x-link-button href="{{ route('home.index', ['type' => 'صدقة']) }}" :active="request('type') == 'صدقة'">
                    صدقة
                </x-link-button>

                <x-link-button href="{{ route('home.index', ['type' => 'علاج']) }}" :active="request('type') == 'علاج'">
                    علاج
                </x-link-button>


            </div>
        </div>

        @if($cases->isEmpty())
            <div class="mx-auto mt-16 max-w-2xl text-center">
                <h1 class="text-2xl font-semibold">لا يوجد اي حلات تبرعيه</h1>
            </div>
        @else
            <div class="mx-auto mt-16 grid max-w-2xl grid-cols-1 gap-x-8 gap-y-20 lg:mx-0 lg:max-w-none lg:grid-cols-3">

                @foreach ($cases as $case)
                    <x-donation-case-card :$case>

                        <x-link-button href="{{ route('home.show', $case) }}">
                            عرض التفاصيل والتبرع
                        </x-link-button>
                    </x-donation-case-card>
                @endforeach

            </div>
        @endif
    </section>



</x-layout>