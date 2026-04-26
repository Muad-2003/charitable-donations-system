<!doctype html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="utf-8" />
    <title>إنشاء حساب - منصة التبرعات</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-slate-50 flex items-center justify-center">

    <div class="w-full max-w-md px-4">
        <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-6 md:p-7 space-y-5">

            
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
                    إنشاء حساب جديد
                </h1>
                <p class="text-xs text-slate-500">
                    أنشئ حسابك لبدء التبرع ودعم الحالات الخيرية
                </p>
            </div>

            @if(session('error'))
                <div class="text-xs text-red-700 bg-red-50 border border-red-100 rounded-2xl px-3 py-2">
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('register') }}" method="POST" class="space-y-4" x-data="{ loading: false }"
                @submit="loading = true">
                @csrf

                
                <div class="space-y-1">

                    <x-label for="fullName">
                        الاسم الكامل
                    </x-label>

                    <x-text-input type="text" name="fullName" placeholder="أدخل اسمك الكامل" />
                </div>

                
                <div class="space-y-1">

                    <x-label for="email">
                        البريد الإلكتروني
                    </x-label>

                    <x-text-input type="email" name="email" placeholder="example@email.com" />
                </div>

                
                <div class="space-y-1">

                    <x-label for="phone_number">
                        رقم الهاتف
                    </x-label>

                    <x-text-input type="text" name="phone_number" placeholder="09xxxxxxxx" pattern="^09\d{8}$"
                        title="يجب أن يتكون من 10 أرقام ويبدأ بـ 09" />
                </div>

                <div class="space-y-1">

                    <x-label for="address">
                        العنوان
                    </x-label>

                    <x-text-input type="text" name="address" placeholder="أدخل عنوانك" />
                </div>

                
                <div class="space-y-1">

                    <x-label for="password">
                        كلمة المرور
                    </x-label>

                    <x-text-input type="password" name="password" placeholder="أدخل كلمة المرور"
                        pattern="^(?=.*[A-Za-z])(?=.*\\d)(?=.*[@#$]).{8,}$"
                        title="8 أحرف على الأقل • حرف • رقم • رمز (@ # $) مثلاً: P@ssw0rd" />
                </div>

                
                <div class="space-y-1">

                    <x-label for="password_confirmation">
                        تأكيد كلمة المرور
                    </x-label>

                    <x-text-input type="password" name="password_confirmation" placeholder="أدخل كلمة المرور"
                        pattern="^(?=.*[A-Za-z])(?=.*\\d)(?=.*[@#$]).{8,}$"
                        title="8 أحرف على الأقل • حرف • رقم • رمز (@ # $) مثلاً: P@ssw0rd" />
                </div>


                
                <x-button x-bind:disabled="loading" class="w-full disabled:opacity-60" type="submit">
                    <span x-show="!loading">إنشاء حساب</span>

                    <span x-show="loading" class="flex items-center gap-2">
                        <svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                            </circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path>
                        </svg>
                        جاري إنشاء الحساب...
                    </span>
                </x-button>

            </form>

            
            <p class="text-[11px] text-slate-500 text-center">
                لديك حساب بالفعل؟
                <a href="{{ route('login') }}" class="text-emerald-700 font-medium hover:text-emerald-800">
                    تسجيل الدخول
                </a>
            </p>
        </div>
    </div>

</body>

</html>