<!doctype html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>منصة التبرعات الخيرية</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>

<body class="bg-slate-50 font-sans min-h-screen flex flex-col" x-data="{ 
        openTopup:false, 
        topupAmount:'', 
        pageLoading: false,
        mobileMenu: false
    }" x-init="window.addEventListener('beforeunload', () => pageLoading = true)">

    @if (session('success'))
        <div x-data="{ open: true }" x-show="open" x-cloak x-transition
            class="fixed inset-0 z-50 flex items-center justify-center bg-black/40">

            <div @click.outside="open = true" class="bg-white w-full max-w-sm rounded-3xl p-6 text-center space-y-4">

                <!-- icone -->
                <div class="mx-auto w-14 h-14 rounded-full bg-emerald-100 flex items-center justify-center">
                    <svg class="w-8 h-8 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                </div>

                <!-- success -->
                <h3 class="text-lg font-semibold text-slate-900">
                    ناجحة!
                </h3>

                <p class="text-sm text-slate-600">
                    {{ session('success') }}
                </p>

                <a href="{{ route('home.index') }}"
                    class="inline-block mt-2 rounded-xl bg-emerald-600 px-6 py-2 text-white text-sm font-medium hover:bg-emerald-700 transition">
                    مواصلة التصفح
                </a>

            </div>
        </div>
    @elseif (session('error'))
        <div x-data="{ open: true }" x-show="open" x-cloak x-transition
            class="fixed inset-0 z-50 flex items-center justify-center bg-black/40">

            <div @click.outside="open = true" class="bg-white w-full max-w-sm rounded-3xl p-6 text-center space-y-4">

                <!-- icone -->
                <div class="mx-auto w-14 h-14 rounded-full bg-red-100 flex items-center justify-center">
                    <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </div>

                <!-- error -->
                <h3 class="text-lg font-semibold text-slate-900">
                    حدث خطأ!
                </h3>

                <p class="text-sm text-slate-600">
                    {{ session('error') }}
                </p>

                <button @click="open = false"
                    class="inline-block mt-2 rounded-xl bg-red-600 px-6 py-2 text-white text-sm font-medium hover:bg-red-700 transition">
                    إغلاق
                </button>                

            </div>
        </div>
    @endif
    
    <!-- Page Loader -->
    <div x-show="pageLoading" x-cloak x-transition.opacity
        class="fixed inset-0 z-50 flex items-center justify-center bg-white/80 backdrop-blur-sm">
        <svg class="animate-spin h-10 w-10 text-emerald-600" xmlns="http://www.w3.org/2000/svg" fill="none"
            viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path>
        </svg>
    </div>


    {{-- the header --}}
    <header class="bg-white border-b border-slate-200 sticky top-0 z-40">
        <div class="max-w-7xl mx-auto px-4 py-3 flex items-center justify-between">

            <!-- Logo -->
            <div class="flex items-center gap-2">
                <div
                    class="w-9 h-9 bg-emerald-600 rounded-full flex items-center justify-center text-white text-lg font-bold">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z" />
                    </svg>
                </div>
                <div class="text-sm leading-4">
                    <div class="font-bold text-emerald-800">نظام التبرعات الخيرية</div>
                    <div class="text-[11px] text-slate-500">تحت إشراف هيئة الأوقاف</div>
                </div>
            </div>

            <!-- Desktop Navigation -->
            <nav class="hidden md:flex items-center gap-4 text-sm font-medium">

                <a href="{{ route('home.index') }}"
                    class="px-4 py-1.5 rounded-full bg-emerald-100 text-emerald-800 hover:bg-emerald-200 transition">
                    الحالات
                </a>

                @auth('web')
                    <!-- Wallet -->
                    <a href="{{ route('wallet.index') }}"
                        class="px-4 py-1.5 rounded-full bg-emerald-600 text-white hover:bg-emerald-700 transition flex items-center gap-1">
                        <span class="flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M21 12a2.25 2.25 0 0 0-2.25-2.25H15a3 3 0 1 1-6 0H5.25A2.25 2.25 0 0 0 3 12m18 0v6a2.25 2.25 0 0 1-2.25 2.25H5.25A2.25 2.25 0 0 1 3 18v-6m18 0V9M3 12V9m18 0a2.25 2.25 0 0 0-2.25-2.25H5.25A2.25 2.25 0 0 0 3 9m18 0V6a2.25 2.25 0 0 0-2.25-2.25H5.25A2.25 2.25 0 0 0 3 6v3" />
                            </svg>
                            {{ number_format(auth()->user()->wallet->balance, 2) }}
                        </span>
                        د.ل
                    </a>

                    <!-- Profile Dropdown -->
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open"
                            class="flex items-center gap-1 px-3 py-1.5 rounded-md bg-slate-100 hover:bg-slate-200 transition text-sm font-medium">
                            <span class="text-slate-700">{{ auth()->user()->fullName ?? 'Anynomus' }}</span>
                            <svg class="w-4 h-4 text-slate-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>

                        <!-- Menu -->
                        <div x-show="open" x-cloak @click.outside="open = false"
                            class="absolute left-0 mt-2 w-56 bg-white rounded-xl shadow-lg border p-4 text-sm space-y-3 z-50">

                            <!-- User Info -->
                            <div>
                                <div class="font-semibold text-slate-800">{{ auth()->user()->fullName ?? 'Anynomus' }}</div>
                                <div class="text-xs text-slate-500">{{ auth()->user()->email ?? 'donor@example.com' }}</div>
                                <div
                                    class="text-xs mt-1 px-2 py-0.5 inline-block bg-emerald-50 text-emerald-700 rounded-full">
                                    متبرع
                                </div>
                            </div>

                            <hr>

                            <a href="{{ route('profile.index') }}"
                                class="flex items-center gap-2 text-slate-700 hover:text-emerald-600">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5.121 17.804A4 4 0 0112 15h0a4 4 0 016.879 2.804M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                الملف الشخصي
                            </a>

                            <form action="{{ route('logout') }}" method="POST" x-data="{ loading: false }"
                                @submit="loading = true">
                                @csrf
                                @method('DELETE')
                                <button :disabled="loading" type="submit"
                                    class="flex items-center gap-2 text-red-600 hover:text-red-700 font-medium disabled:opacity-60">
                                    {{-- <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h6a2 2 0 012 2v1" />
                                    </svg>
                                    تسجيل الخروج --}}
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h6a2 2 0 012 2v1" />
                                    </svg>
                                    <span x-show="!loading">تسجيل الخروج</span>

                                    <span x-show="loading" class="flex items-center gap-2">
                                        <svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg"
                                            fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                                stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path>
                                        </svg>
                                        جاري الخروج...
                                    </span>
                                </button>
                            </form>
                        </div>
                    </div>
                @elseauth('admin')
                    <a href="{{ route('dashboard.index') }}"
                        class="px-4 py-1.5 rounded-full bg-slate-900 text-white hover:bg-black">
                        لوحة التحكم
                    </a>
                @else
                    <a href="{{ route('login') }}" class="px-4 py-1.5 rounded-full bg-slate-900 text-white hover:bg-black">
                        تسجيل الدخول
                    </a>
                @endauth
            </nav>

            <!-- Mobile Button -->
            <button @click="mobileMenu = !mobileMenu"
                class="md:hidden p-2 rounded-lg border border-slate-200 hover:bg-slate-100">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M3 4.5h14.25M3 9h9.75M3 13.5h9.75m4.5-4.5v12m0 0-3.75-3.75M17.25 21 21 17.25" />
                </svg>


            </button>
        </div>

        <!-- Mobile Menu -->
        <div x-show="mobileMenu" x-cloak x-transition @click.outside="mobileMenu=false"
            class="md:hidden bg-white border-t border-slate-200 px-4 py-3 space-y-2 text-sm">

            <a href="{{ route('home.index') }}" class="block px-3 py-2 rounded-lg
                {{ request()->routeIs('home.*') ? 'bg-emerald-600 text-white' : 'hover:bg-slate-100' }}">
                الحالات
            </a>

            @auth('web')
                <!-- wallet -->
                <a href="{{ route('wallet.index') }}"
                    class="block px-3 py-2 rounded-lg
                                                {{ request()->routeIs('wallet.*') ? 'bg-emerald-600 text-white' : 'hover:bg-slate-100' }}">
                    المحفظة
                </a>

                <!-- profile -->
                <a href="{{ route('profile.index') }}"
                    class="block px-3 py-2 rounded-lg
                                                {{ request()->routeIs('profile.*') ? 'bg-emerald-600 text-white' : 'hover:bg-slate-100' }}">
                    الملف الشخصي
                </a>

                <!-- logout -->
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button class="w-full text-right px-3 py-2 rounded-lg text-red-600 hover:bg-red-50">
                        تسجيل الخروج
                    </button>
                </form>

            @elseauth('admin')
                <a href="{{ route('dashboard.index') }}"
                    class="block px-3 py-2 rounded-lg
                                                {{ request()->routeIs('dashboard.*') ? 'bg-emerald-600 text-white' : 'bg-slate-900 text-white' }}">
                    لوحة التحكم
                </a>
            @else
                <a href="{{ route('login') }}"
                    class="block px-3 py-2 rounded-lg
                                                {{ request()->routeIs('login') ? 'bg-emerald-600 text-white' : 'bg-slate-900 text-white' }}">
                    تسجيل الدخول
                </a>
            @endauth
        </div>

    </header>





    <main class="flex-1 max-w-6xl mx-auto w-full px-4 sm:px-6 lg:px-8 py-6 space-y-8">

        {{ $slot }}

    </main>


    <footer class="bg-slate-900 text-slate-300 mt-20">

        <div class="max-w-7xl mx-auto px-6 py-10 grid gap-8 md:grid-cols-3">

            <!-- about the system -->
            <div>
                <h3 class="text-white font-semibold mb-3">
                    نظام التبرعات الخيرية
                </h3>
                <p class="text-sm leading-relaxed text-slate-400">
                    منصة خيرية تهدف إلى تسهيل التبرعات ودعم الحالات الإنسانية تحت إشراف هيئة الأوقاف.
                </p>
            </div>

            <!-- links -->
            <div>
                <h3 class="text-white font-semibold mb-3">روابط سريعة</h3>
                <ul class="space-y-2 text-sm">
                    <li>
                        <a href="{{ route('home.index') }}" class="hover:text-white">
                            الحالات
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('wallet.index') }}" class="hover:text-white">
                            المحفظة
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('profile.index') }}" class="hover:text-white">
                            الملف الشخصي
                        </a>
                    </li>
                </ul>
            </div>

            <!-- contect -->
            <div>
                <h3 class="text-white font-semibold mb-3">تواصل معنا</h3>
                <ul class="space-y-2 text-sm text-slate-400">
                    <li>📧 support@donation.ly</li>
                    <li>📞 092-0000000</li>
                    <li>📍 ليبيا</li>
                </ul>
            </div>
        </div>


        <div class="border-t border-slate-700 text-center py-4 text-xs text-slate-500">
            © {{ date('Y') }} نظام التبرعات الخيرية — جميع الحقوق محفوظة
        </div>
    </footer>


</body>

</html>