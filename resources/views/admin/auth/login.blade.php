<!doctype html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="utf-8" />
    <title>تسجيل الدخول - منصة التبرعات</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-slate-50 flex items-center justify-center">

    <div class="w-full max-w-md px-4">
        <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-6 md:p-7 space-y-5">

            {{-- الشعار / العنوان --}}
            <div class="text-center space-y-1">
                <div
                    class="inline-flex items-center justify-center w-12 h-12 rounded-2xl bg-emerald-100 text-emerald-700 text-2xl">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z" />
                    </svg>

                </div>
                <h1 class="text-lg font-semibold text-slate-900 mt-2">
                    تسجيل الدخول للمسؤلين
                </h1>
                <p class="text-xs text-slate-500">
                    أهلاً بك في منصة التبرعات الخيرية
                </p>
            </div>

            {{-- رسائل الأخطاء العامة --}}
            @if(session('error'))
                <div class="text-xs text-red-700 bg-red-50 border border-red-100 rounded-2xl px-3 py-2">
                    {{ session('error') }}
                </div>
            @endif


            <form action="{{ route('admin.login') }}" method="POST" class="space-y-4" x-data="{ loading: false }"
                @submit="loading = true">
                @csrf

                {{-- البريد الإلكتروني --}}
                <div class="space-y-1">

                    <x-label for="email">
                        البريد الإلكتروني
                    </x-label>

                    <x-text-input type="email" name="email" placeholder="example@email.com" />
                </div>

                {{-- كلمة المرور --}}
                <div class="space-y-1">

                    <x-label for="password">
                        كلمة المرور
                    </x-label>

                    <x-text-input type="password" name="password" placeholder="أدخل كلمة المرور" />
                </div>

                {{-- تذكرني + نسيت كلمة المرور --}}
                <div class="flex items-center justify-between text-[11px] text-slate-600">
                    <label class="inline-flex items-center gap-1 cursor-pointer">
                        <input type="checkbox" name="remember"
                            class="rounded border-slate-300 text-emerald-600 focus:ring-emerald-500">
                        <span>تذكرني</span>
                    </label>
                </div>

                {{-- زر تسجيل الدخول --}}
                <x-button class="w-full disabled:opacity-60" x-bind:disabled="loading" type="submit">
                    <span x-show="!loading">تسجيل الدخول</span>

                    <span x-show="loading" class="flex items-center gap-2">
                        <svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                            </circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path>
                        </svg>
                        جاري الدخول...
                    </span>
                </x-button>
            </form>
        </div>
    </div>

</body>

</html>