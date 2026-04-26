<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>التحقق من الرمز</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-slate-100 flex items-center justify-center min-h-screen p-4">

    <div class="w-full max-w-sm bg-white rounded-2xl shadow-sm border border-slate-200 p-6">

        <h3 class="text-center text-lg font-semibold text-slate-900 mb-4">
            التحقق من البريد الإلكتروني
        </h3>

        {{-- errors --}}
        @if ($errors->any())
            <div class="mb-3 text-xs text-red-600 text-center">
                {{ $errors->first() }}
            </div>
        @endif
        
        <form method="POST" action="{{ route('otp.verify') }}" class="space-y-4" x-data="{ loading: false }"
            @submit="loading = true">
            @csrf

            <div>
                <label for="otp" class="text-sm font-medium text-slate-700 mb-1 block">
                    أدخل رمز التحقق المكوّن من 4 أرقام
                </label>

                <input type="text" name="otp" id="otp" maxlength="4" pattern="\d{4}" required autofocus class="w-full text-center rounded-xl border border-slate-300 bg-slate-50 px-3 py-2 text-lg tracking-widest
                           focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
            </div>

            <button type="submit" :disabled="loading"
                class="w-full py-2.5 rounded-xl bg-emerald-600 text-white text-sm font-medium hover:bg-emerald-700 disabled:opacity-60">
                <span x-show="!loading">تحقق</span>

                <span x-show="loading" class="flex items-center gap-2">
                    <svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                        </circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path>
                    </svg>
                    جاري التحقق...
                </span>
            </button>
        </form>

        <form method="POST" action="{{ route('otp.resend') }}" class="mt-3" x-data="{ loading: false }"
            @submit="loading = true">
            @csrf
            <button type="submit" :disabled="loading"
                class="w-full text-xs text-emerald-700 hover:underline text-center disabled:opacity-60">
                <span x-show="!loading">إعادة إرسال الرمز</span>

                <span x-show="loading" class="flex items-center gap-2">
                    <svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                        </circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path>
                    </svg>
                    جاري إعادة إرسال الرمز...
                </span>
            </button>
        </form>

    </div>

</body>

</html>