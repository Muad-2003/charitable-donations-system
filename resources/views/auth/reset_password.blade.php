<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تعيين كلمة مرور جديدة</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-slate-100 flex items-center justify-center min-h-screen p-4">

    <div class="w-full max-w-sm bg-white rounded-2xl shadow-sm border border-slate-200 p-6">

        <h1 class="text-center text-lg font-semibold text-slate-900 mb-2">
            تعيين كلمة مرور جديدة
        </h1>

        <p class="text-center text-xs text-slate-500 mb-4">
            أدخل رمز التحقق وكلمة المرور الجديدة
        </p>

        @if (session('success'))
            <div class="mb-3 text-xs text-emerald-600 text-center">
                {{ session('success') }}
            </div>
        @endif
        {{-- أخطاء --}}
        @if ($errors->any())
            <div class="mb-3 text-xs text-red-600 text-center">
                {{ $errors->first() }}
            </div>
        @endif


        <form action="{{ route('password.update') }}" method="POST" x-data="{ loading: false }" @submit="loading = true"
            class="space-y-4">
            @csrf

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">
                    رمز التحقق (OTP)
                </label>
                <input type="text" name="otp" maxlength="4" required class="w-full text-center rounded-xl border border-slate-300 bg-slate-50 px-3 py-2 text-lg tracking-widest
                           focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
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

            <button type="submit" :disabled="loading" class="w-full py-2.5 rounded-xl bg-emerald-600 text-white text-sm font-medium
                       hover:bg-emerald-700 disabled:opacity-60 flex items-center justify-center gap-2">
                <span x-show="!loading">تغيير كلمة المرور</span>
                <span x-show="loading">جارٍ التغيير...</span>
            </button>
        </form>


        <div class="mt-4 text-center text-xs text-slate-500">
            <a href="{{ route('login') }}" class="text-emerald-600 hover:underline">
                العودة لتسجيل الدخول
            </a>
        </div>

    </div>

</body>

</html>