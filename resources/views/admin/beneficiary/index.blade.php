<x-layout-dashboard>

    {{-- العنوان + زر إضافة حالة --}}
    <div class="flex items-center justify-between mb-2">
        <h1 class="text-2xl font-semibold text-slate-900">
            إدارة المستفيدين
        </h1>

        <div x-data="">
            <form x-ref="filters" action="{{ route('beneficiary.index') }}" method="GET">

                <div class="flex items-center gap-2">
                    <x-text-input type="text" placeholder="بحث..." name="search" value="{{ request('search') }}"
                        form-ref="filters" />


                    <button type="submit" class="bg-emerald-500 text-white text-sm px-2 py-1 rounded-full">
                        بحث
                    </button>
                </div>
            </form>

        </div>

        <x-link-button href="{{ route('beneficiary.create') }}">
            إضافة مستفيد جديد
        </x-link-button>
    </div>

    {{-- جدول الحالات --}}
    <section class="bg-white rounded-3xl border border-slate-100 shadow-sm p-4 mt-2">
        <div class="flex items-center justify-between mb-3">
            <h2 class="text-sm font-semibold text-slate-900">
                قائمة المستفيدين
            </h2>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm text-right">
                <thead>
                    <tr class="border-b border-slate-100 text-xs text-slate-500 text-center">
                        <th class="py-3 px-3">الاسم الثلاثي</th>
                        <th class="py-3 px-3">الرقم الوطني</th>
                        <th class="py-3 px-3">المحفظة</th>
                        <th class="py-3 px-3">الإجراءات</th>
                    </tr>
                </thead>
                <tbody class="text-slate-700 text-sm">

                    @foreach ($beneficiaries as $beneficiary)
                        <tr class="border-b border-slate-50 hover:bg-slate-50/70 text-center">
                            <td class="py-1 px-1 text-xs">
                                {{ $beneficiary->fullName }}
                            </td>

                            <td class="py-1 px-1 text-xs">
                                {{ $beneficiary->ssn }}
                            </td>


                            <td class="py-1 px-1 text-xs">
                                {{ $beneficiary->wallet->balance ?? '-'}}
                            </td>


                            <td class="py-3 px-3">
                                <div x-data="{deleteConfirm: false, withdrawConfirm: false, loading: false}"
                                    class="flex items-center justify-between">

                                    <a href="{{ route('beneficiary.show', $beneficiary) }}"
                                        class="text-slate-500 hover:text-slate-700" title="تفاصيل">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="size-6">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z" />
                                        </svg>
                                    </a>

                                    <a href="{{ route('beneficiary.edit', $beneficiary) }}"
                                        class="text-slate-700 hover:text-slate-900" title="تعديل">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="size-6">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                        </svg>

                                    </a>


                                    <form x-ref="deleteForm" action="{{ route('beneficiary.destroy', $beneficiary->id) }}"
                                        method="POST" enctype="multipart/form-data" @submit.prevent="deleteConfirm = true">
                                        @csrf
                                        @method('DELETE')

                                        <button class="text-red-500 hover:text-red-700" title="حذف">

                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="size-6">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                            </svg>

                                        </button>
                                    </form>


                                    <form x-ref="withdrawForm"
                                        action="{{ route('beneficiary.withdraw', $beneficiary->id) }}" method="POST"
                                        @submit.prevent="withdrawConfirm = true">
                                        @csrf

                                        <input type="hidden" name="amount" value="{{ $beneficiary->wallet->balance ?? 0 }}">

                                        <button class="text-green-500 hover:text-green-700" title="سحب كامل الرصيد">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="size-6">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 8.25H7.5a2.25 2.25 0 0 0-2.25 2.25v9
                                                                                            a2.25 2.25 0 0 0 2.25 2.25h9
                                                                                            a2.25 2.25 0 0 0 2.25-2.25v-9
                                                                                            a2.25 2.25 0 0 0-2.25-2.25H15
                                                                                            M9 12l3 3m0 0 3-3m-3 3V2.25" />
                                            </svg>

                                        </button>
                                    </form>


                                    {{-- delete form --}}
                                    <div x-show="deleteConfirm" x-cloak x-transition
                                        class="fixed inset-0 z-50 flex items-center justify-center bg-black/40">
                                        <div @click.outside="deleteConfirm = false"
                                            class="bg-white w-full max-w-sm rounded-2xl p-6 space-y-4">

                                            <!-- أيقونة -->
                                            <div
                                                class="mx-auto w-14 h-14 rounded-full bg-red-100 flex items-center justify-center">

                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                    stroke-width="1.5" stroke="currentColor" class="w-8 h-8 text-red-600">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" />
                                                </svg>

                                            </div>


                                            <h3 class="text-lg font-semibold text-slate-900">
                                                هل أنت متأكد من حذف هذا المستفيد؟
                                            </h3>

                                            <!-- الوصف -->
                                            <p class="text-sm text-slate-600">
                                                لن تتمكن من التراجع عن هذا الإجراء.
                                            </p>

                                            <!-- أزرار -->
                                            <div class="flex gap-2 pt-3">

                                                <button type="button" @click=" loading = true; $refs.deleteForm.submit(); "
                                                    :disabled="loading"
                                                    class="flex-1 rounded-xl bg-emerald-600 text-white px-4 py-2 text-sm disabled:opacity-50">
                                                    <span x-show="!loading">حذف</span>
                                                    <span x-show="loading">جاري الجذف...</span>
                                                </button>

                                                <button type="button" @click="deleteConfirm = false"
                                                    class="flex-1 rounded-xl border px-4 py-2 text-sm hover:bg-slate-50">
                                                    إلغاء
                                                </button>


                                            </div>
                                        </div>
                                    </div>



                                    {{-- withdraw form --}}
                                    <div x-show="withdrawConfirm" x-cloak x-transition
                                        class="fixed inset-0 z-50 flex items-center justify-center bg-black/40">
                                        <div @click.outside="withdrawConfirm = false"
                                            class="bg-white w-full max-w-sm rounded-2xl p-6 space-y-4">

                                            <!-- أيقونة -->
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
                                                هل أنت متأكد من سحب كامل رصيد هذا المستفيد؟
                                            </h3>

                                            <!-- الوصف -->
                                            <p class="text-sm text-slate-600">
                                                لن تتمكن من التراجع عن هذا الإجراء.
                                            </p>

                                            <!-- أزرار -->
                                            <div class="flex gap-2 pt-3">

                                                <button type="button"
                                                    @click=" loading = true; $refs.withdrawForm.submit(); "
                                                    :disabled="loading"
                                                    class="flex-1 rounded-xl bg-emerald-600 text-white px-4 py-2 text-sm disabled:opacity-50">
                                                    <span x-show="!loading">سحب</span>
                                                    <span x-show="loading">جاري السحب...</span>
                                                </button>

                                                <button type="button" @click="withdrawConfirm = false"
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
                {{ $beneficiaries->withQueryString()->links() }}
            </div>
        </div>
    </section>
</x-layout-dashboard>