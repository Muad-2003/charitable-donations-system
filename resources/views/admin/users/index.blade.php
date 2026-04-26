<x-layout-dashboard>

    {{-- العنوان + زر إضافة حالة --}}
    <div class="flex items-center justify-between mb-2">
        <h1 class="text-2xl font-semibold text-slate-900">
            إدارة المستخديمين
        </h1>

        <div x-data="">
            <form x-ref="filters" action="{{ route('user.index') }}" method="GET">

                <div class="flex items-center gap-2">
                    <x-text-input type="text" placeholder="بحث..." name="search" value="{{ request('search') }}"
                        form-ref="filters" />


                    <button type="submit" class="bg-emerald-500 text-white text-sm px-2 py-1 rounded-full">
                        بحث
                    </button>
                </div>
            </form>

        </div>


    </div>

    <x-link-button href="{{ route('Logout_All_Users') }}">
        تسجيل خروج جميع المستخدمين
    </x-link-button>

    {{-- table of users --}}
    <section class="bg-white rounded-3xl border border-slate-100 shadow-sm p-4 mt-2">
        <div class="flex items-center justify-between mb-3">
            <h2 class="text-sm font-semibold text-slate-900">
                قائمة المستخديمين
            </h2>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm text-right">
                <thead>
                    <tr class="border-b border-slate-100 text-xs text-slate-500 text-center">
                        <th class="py-3 px-3">اسم المستخدم</th>
                        <th class="py-3 px-3">البريد الإلكتروني</th>
                        <th class="py-3 px-3">الهاتف</th>
                        <th class="py-3 px-3">السكن</th>
                        <th class="py-3 px-3">تاريخ التسجيل</th>
                        <th class="py-3 px-3">الحالة</th>
                        <th class="py-3 px-3">الإجراءات</th>
                    </tr>
                </thead>
                <tbody class="text-slate-700 text-sm">

                    @foreach ($users as $user)
                        <tr class="border-b border-slate-50 hover:bg-slate-50/70 text-center">
                            <td class="py-1 px-1 text-xs">
                                {{ $user->fullName }}
                            </td>

                            <td class="py-1 px-1 text-xs">
                                {{ $user->email }}
                            </td>

                            <td class="py-1 px-1 text-xs">
                                {{ $user->phone_number }}
                            </td>

                            <td class="py-1 px-1 text-xs">
                                {{ $user->address }}
                            </td>

                            <td class="py-1 px-1 text-xs">
                                {{ $user->created_at }}
                            </td>

                            <td class="py-1 px-1 text-xs">
                                {{ $user->status ? 'مفعل' : 'غير مفعل' }}
                            </td>


                            <td class="py-3 px-3">
                                <div x-data="{activateConfirm: false, suspendConfirm: false, loading: false}"
                                    class="items-center">

                                    @if(!$user->status)
                                        <form x-ref="activateForm" action="{{ route('user.update', $user) }}" method="POST"
                                            @submit.prevent="activateConfirm = true">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status" value="1">
                                            <button class="text-emerald-500 hover:text-slate-700" title="تفعيل">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                    stroke-width="1.5" stroke="currentColor" class="size-6">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                                </svg>
                                            </button>
                                        </form>

                                    @else
                                        <form x-ref="suspendForm" action="{{ route('user.update', $user) }}" method="POST"
                                            @submit.prevent="suspendConfirm = true">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status" value="0">

                                            <button class="text-red-500 hover:text-red-700" title="تعليق">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                    stroke-width="1.5" stroke="currentColor" class="size-6">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z" />
                                                </svg>


                                            </button>
                                        </form>
                                    @endif



                                    {{-- activate form --}}
                                    <div x-show="activateConfirm" x-cloak x-transition
                                        class="fixed inset-0 z-50 flex items-center justify-center bg-black/40">
                                        <div @click.outside="activateConfirm = false"
                                            class="bg-white w-full max-w-sm rounded-2xl p-6 space-y-4">


                                            <div
                                                class="mx-auto w-14 h-14 rounded-full bg-emerald-100 flex items-center justify-center">

                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                    stroke-width="1.5" stroke="currentColor"
                                                    class="w-8 h-8 text-emerald-600">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" />
                                                </svg>

                                            </div>


                                            <h3 class="text-lg font-semibold text-slate-900">
                                                هل أنت متأكد من تفعيل هذا المستخدم؟
                                            </h3>


                                            <p class="text-sm text-slate-600">
                                                سيتمكن المستخدم من تسجيل الدخول واستخدام النظام.
                                            </p>


                                            <div class="flex gap-2 pt-3">

                                                <button type="button"
                                                    @click=" loading = true; $refs.activateForm.submit(); "
                                                    :disabled="loading"
                                                    class="flex-1 rounded-xl bg-emerald-600 text-white px-4 py-2 text-sm disabled:opacity-50">
                                                    <span x-show="!loading">تفعيل</span>
                                                    <span x-show="loading">جاري التفعيل...</span>
                                                </button>

                                                <button type="button" @click="activateConfirm = false"
                                                    class="flex-1 rounded-xl border px-4 py-2 text-sm hover:bg-slate-50">
                                                    إلغاء
                                                </button>


                                            </div>
                                        </div>
                                    </div>


                                    {{-- suspend form --}}
                                    <div x-show="suspendConfirm" x-cloak x-transition
                                        class="fixed inset-0 z-50 flex items-center justify-center bg-black/40">
                                        <div @click.outside="suspendConfirm = false"
                                            class="bg-white w-full max-w-sm rounded-2xl p-6 space-y-4">


                                            <div
                                                class="mx-auto w-14 h-14 rounded-full bg-red-100 flex items-center justify-center">

                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                    stroke-width="1.5" stroke="currentColor" class="w-8 h-8 text-red-600">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" />
                                                </svg>

                                            </div>


                                            <h3 class="text-lg font-semibold text-slate-900">
                                                هل أنت متأكد من تعليق هذا المستخدم؟
                                            </h3>


                                            <p class="text-sm text-slate-600">
                                                لن يتمكن المستخدم من تسجيل الدخول أو استخدام النظام.
                                            </p>


                                            <div class="flex gap-2 pt-3">

                                                <button type="button" @click=" loading = true; $refs.suspendForm.submit(); "
                                                    :disabled="loading"
                                                    class="flex-1 rounded-xl bg-emerald-600 text-white px-4 py-2 text-sm disabled:opacity-50">
                                                    <span x-show="!loading">تعليق</span>
                                                    <span x-show="loading">جاري التعليق...</span>
                                                </button>

                                                <button type="button" @click="suspendConfirm = false"
                                                    class="flex-1 rounded-xl border px-4 py-2 text-sm hover:bg-slate-50">
                                                    إلغاء
                                                </button>


                                            </div>
                                        </div>
                                    </div>


                                </div>
                            </td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
            <div class="mt-4">
                {{ $users->withQueryString()->links() }}
            </div>
        </div>
    </section>
</x-layout-dashboard>