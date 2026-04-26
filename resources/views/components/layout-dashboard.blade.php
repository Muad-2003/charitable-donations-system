<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>لوحة التحكم - نظام التبرعات الخيرية</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>


<body class="bg-slate-50 font-sans" x-data="{ pageLoading:false, sidebarOpen:false }"
    x-init="window.addEventListener('beforeunload', () => pageLoading = true)">

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

                <button @click="open = false"
                    class="inline-block mt-2 rounded-xl bg-emerald-600 px-6 py-2 text-white text-sm font-medium hover:bg-emerald-700 transition">
                    حسنا
                </button>

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
                    حسنا
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

    <header class="bg-white border border-slate-300">
        <div class="max-w-6xl mx-auto px-4 py-3 flex items-center justify-between">

            <button @click="sidebarOpen = !sidebarOpen"
                class="md:hidden p-2 rounded-lg border border-slate-200 hover:bg-slate-100">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M3.75 6.75h16.5M3.75 12h16.5M12 17.25h8.25" />
                </svg>

            </button>


            {{-- System logo --}}
            <div class="flex items-center space-x-2">
                <div
                    class="w-9 h-9 rounded-full bg-emerald-600 flex items-center justify-center text-white font-bold text-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z" />
                    </svg>
                </div>
                <div class="text-sm leading-4 text-right">
                    <div class="font-semibold text-emerald-800 text-sm">نظام التبرعات الخيرية</div>
                    <div class="text-xs text-slate-500 -mt-0.5">تحت إشراف هيئة الأوقاف</div>
                </div>
            </div>


            @auth('admin')
                {{-- Dropdown (Admin) --}}
                <div class="relative" x-data="{ open:false }">
                    <button @click="open = !open"
                        class="flex items-center gap-2 px-3 py-1.5 rounded-md border border-slate-200 bg-white text-sm hover:bg-slate-50">
                        <span class="text-slate-800">مدير النظام</span>
                        <svg class="w-4 h-4 text-slate-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                        <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5.121 17.804A4 4 0 0112 15h0a4 4 0 016.879 2.804M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </button>

                    <div x-show="open" x-cloak @click.outside="open=false"
                        class="absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-lg border border-slate-100 p-4 text-sm space-y-3 z-50">
                        <div>
                            <div class="font-semibold text-slate-800">{{ Auth::guard('admin')->user()->fullName }}</div>
                            <div class="text-xs text-slate-500">{{ Auth::guard('admin')->user()->email }}</div>
                            <div class="text-xs mt-1 px-2 py-0.5 inline-block rounded-full bg-slate-100 text-slate-700">
                                مدير النظام
                            </div>
                        </div>

                        <hr>

                        <a href="{{ route('home.index') }}"
                            class="flex items-center gap-2 text-slate-600 hover:text-slate-700 font-medium">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="w-4 h-4">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                            </svg>

                            الصفحة الرئسية
                        </a>

                        <form action="{{ route('admin.logout') }}" method="POST" x-data="{ loading: false }"
                            @submit="loading = true">
                            @csrf
                            @method('DELETE')
                            <button type="submit" :disabled="loading"
                                class="flex items-center gap-2 text-red-600 hover:text-red-700 font-medium disabled:opacity-60">
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
            @else
                <x-link href="{{ route('login') }}">
                    تسجيل الدخول
                </x-link>
            @endauth



        </div>
    </header>

    <main class="bg-slate-50 min-h-screen">

        <div class="flex min-h-screen">

            {{-- Sidebar --}}
            <aside :class="sidebarOpen ? 'translate-x-0' : 'translate-x-full md:translate-x-0'" class="fixed md:static inset-y-0 right-0 z-40 w-64 bg-white border-l border-slate-200 h-screen
                transform transition-transform duration-300 md:translate-x-0">

                <div class="py-6 px-4">
                    <nav class="space-y-6 text-sm">

                        {{-- items --}}
                        <a href="{{ route('dashboard.index') }}" class="font-medium block px-3 py-2 rounded-xl transition
                                {{ request()->routeIs('dashboard.index')
    ? 'bg-emerald-600 text-white'
    : 'text-slate-700 hover:bg-slate-100' }}">
                            <span class="flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v7.5C7.5 21.496 6.996 22 6.375 22h-2.25A1.125 1.125 0 013 20.875v-7.75Zm7.875-6.75c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v13.5c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125v-13.5Zm7.875 4.5c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v9c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125v-9Z" />
                                </svg>
                                لوحة التحكم
                            </span>
                        </a>

                        <a href="{{ route('donation_case.index') }}" class="font-medium block px-3 py-2 rounded-xl transition
                                {{ request()->routeIs('donation_case.*')
    ? 'bg-emerald-600 text-white'
    : 'text-slate-700 hover:bg-slate-100' }}">
                            <span class="flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M6 6.878V6a2.25 2.25 0 0 1 2.25-2.25h7.5A2.25 2.25 0 0 1 18 6v.878m-12 0c.235-.083.487-.128.75-.128h10.5c.263 0 .515.045.75.128m-12 0A2.25 2.25 0 0 0 4.5 9v.878m13.5-3A2.25 2.25 0 0 1 19.5 9v.878m0 0a2.246 2.246 0 0 0-.75-.128H5.25c-.263 0-.515.045-.75.128m15 0A2.25 2.25 0 0 1 21 12v6a2.25 2.25 0 0 1-2.25 2.25H5.25A2.25 2.25 0 0 1 3 18v-6c0-.98.626-1.813 1.5-2.122" />
                                </svg>
                                إدارة الحالات
                            </span>
                        </a>

                        <a href="{{ route('beneficiary.index') }}" class="font-medium block px-3 py-2 rounded-xl transition
                                {{ request()->routeIs('beneficiary.*')
    ? 'bg-emerald-600 text-white'
    : 'text-slate-700 hover:bg-slate-100' }}">
                            <span class="flex items-center gap-2"><svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15 9h3.75M15 12h3.75M15 15h3.75M4.5 19.5h15a2.25 2.25 0 0 0 2.25-2.25V6.75A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25v10.5A2.25 2.25 0 0 0 4.5 19.5Zm6-10.125a1.875 1.875 0 1 1-3.75 0 1.875 1.875 0 0 1 3.75 0Zm1.294 6.336a6.721 6.721 0 0 1-3.17.789 6.721 6.721 0 0 1-3.168-.789 3.376 3.376 0 0 1 6.338 0Z" />
                                </svg>

                                إدارة المستفيدين
                            </span>

                        </a>

                        <a href="{{ route('user.index') }}" class="font-medium block px-3 py-2 rounded-xl transition
                                {{ request()->routeIs('user.*')
    ? 'bg-emerald-600 text-white'
    : 'text-slate-700 hover:bg-slate-100' }}">
                            <span class="flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                                </svg>

                                إدارة المستخدمين
                            </span>

                        </a>

                        <a href="{{ route('transactions.index') }}" class="font-medium block px-3 py-2 rounded-xl transition
                                {{ request()->routeIs('transactions.*')
    ? 'bg-emerald-600 text-white'
    : 'text-slate-700 hover:bg-slate-100' }}">
                            <span class="flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M21 12a2.25 2.25 0 0 0-2.25-2.25H15a3 3 0 1 1-6 0H5.25A2.25 2.25 0 0 0 3 12m18 0v6a2.25 2.25 0 0 1-2.25 2.25H5.25A2.25 2.25 0 0 1 3 18v-6m18 0V9M3 12V9m18 0a2.25 2.25 0 0 0-2.25-2.25H5.25A2.25 2.25 0 0 0 3 9m18 0V6a2.25 2.25 0 0 0-2.25-2.25H5.25A2.25 2.25 0 0 0 3 6v3" />
                                </svg>

                                المعاملات المالية
                            </span>

                        </a>

                    </nav>
                </div>
            </aside>
            <div x-show="sidebarOpen" x-transition.opacity @click="sidebarOpen = false"
                class="fixed inset-0 bg-black/40 z-30 md:hidden">
            </div>


            <section class="flex-1">
                <div class="max-w-6xl mx-auto px-6 py-8 space-y-6">

                    {{ $slot }}

                </div>
            </section>

        </div>

    </main>
</body>

</html>