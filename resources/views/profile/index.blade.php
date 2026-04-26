<x-layout>
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-semibold text-slate-900">
            الملف الشخصي
        </h1>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        
        <div class="space-y-6">

            <!-- the user card -->
            <div class="bg-white rounded-2xl border border-slate-100 p-5">
                <div class="flex items-center gap-4">
                    <div
                        class="w-14 h-14 rounded-full bg-emerald-600 text-white flex items-center justify-center text-xl font-bold">
                        {{ mb_substr(auth()->user()->fullName, 0, 1) }}
                    </div>

                    <div>
                        <div class="font-semibold text-slate-800">
                            {{ auth()->user()->fullName }}
                        </div>
                        <div class="text-xs text-slate-500">
                            {{ auth()->user()->email }}
                        </div>

                        <!-- the account status -->
                        @if(auth()->user()->status)
                            <span
                                class="inline-block mt-1 px-2 py-0.5 text-xs rounded-full bg-emerald-100 text-emerald-700">
                                نشط
                            </span>
                        @else
                            <span class="inline-block mt-1 px-2 py-0.5 text-xs rounded-full bg-red-100 text-red-700">
                                معلق
                            </span>
                        @endif
                    </div>
                </div>
            </div>

            <!-- the wallet card -->
            <div class="bg-white rounded-2xl border border-slate-100 p-5 space-y-4">
                <h2 class="text-sm font-semibold text-slate-900">
                    المحفظة
                </h2>

                <div class="rounded-xl bg-emerald-50 px-4 py-3">
                    <div class="text-xs text-slate-600">
                        الرصيد الحالي
                    </div>
                    <div class="text-xl font-bold text-emerald-700">
                        {{ number_format(auth()->user()->wallet->balance ?? 0, 2) }} د.ل
                    </div>
                </div>

                <a href="{{ route('wallet.index') }}"
                    class="block text-center px-4 py-2 rounded-xl bg-slate-900 text-white text-sm hover:bg-black">
                    الذهاب إلى المحفظة
                </a>
            </div>
        </div>

        <!-- the right column: edit personal data -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-2xl border border-slate-100 p-6">

                <h2 class="text-sm font-semibold text-slate-900 mb-4">
                    تعديل البيانات الشخصية
                </h2>

                <form action="{{ route('profile.update') }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-4"
                    x-data="{ loading: false }" @submit="loading = true">
                    @csrf
                    @method('PUT')

                    
                    <div>
                        <x-label for="fullName" :required="true">
                            الاسم الكامل
                        </x-label>
                        <x-text-input name="fullName" value="{{ auth()->user()->fullName }}" />
                    </div>

                    {{-- the email dont edit --}}
                    <div>
                        <x-label for="email">
                            البريد الإلكتروني
                        </x-label>
                        <x-text-input type="email" name="email" value="{{ auth()->user()->email }}" :readonly="true" />
                        <p class="text-[11px] text-slate-500 mt-1">
                            لا يمكن تعديل البريد الإلكتروني
                        </p>
                    </div>

                    
                    <div>
                        <x-label for="phone_number" :required="true">
                            رقم الهاتف
                        </x-label>
                        <x-text-input name="phone_number" value="{{ auth()->user()->phone_number }}"
                            placeholder="09xxxxxxxx" pattern="^09\\d{8}$" title="يجب أن يتكون من 10 أرقام ويبدأ بـ 09" />
                    </div>

                    
                    <div>
                        <x-label for="address" :required="true">
                            العنوان
                        </x-label>
                        <x-text-input name="address" value="{{ auth()->user()->address }}" placeholder="أدخل العنوان" />
                    </div>

                    
                    <div>
                        <x-label for="current_password">
                            كلمة المرور الحالية
                        </x-label>
                        <x-text-input type="password" name="current_password" placeholder="مطلوبة لتغيير كلمة المرور" />
                    </div>

                    
                    <div>
                        <x-label for="password">
                            كلمة المرور الجديدة
                        </x-label>
                        <x-text-input type="password" name="password" placeholder="اتركه فارغًا إن لم ترد التغيير"
                            pattern="^(?=.*[A-Za-z])(?=.*\\d)(?=.*[@#$]).{8,}$"
                            title="8 أحرف على الأقل • حرف • رقم • رمز (@ # $) مثلاً: P@ssw0rd" />
                    </div>

                    
                    <div>
                        <x-label for="password_confirmation">
                            تأكيد كلمة المرور
                        </x-label>
                        <x-text-input type="password" name="password_confirmation"
                            pattern="^(?=.*[A-Za-z])(?=.*\\d)(?=.*[@#$]).{8,}$"
                            title="8 أحرف على الأقل • حرف • رقم • رمز (@ # $) مثلاً: P@ssw0rd" />
                    </div>

                    
                    <div class="md:col-span-2 flex justify-end mt-4">
                        <x-button type="submit" class="disabled:opacity-60" x-bind:disabled="loading">
                            <span x-show="!loading">حفظ التغييرات</span>

                            <span x-show="loading" class="flex items-center gap-2">
                                <svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg"
                                    fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                        stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path>
                                </svg>
                                جاري الحفظ...
                            </span>
                        </x-button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</x-layout>