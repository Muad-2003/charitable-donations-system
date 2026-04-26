<x-layout-dashboard>

    {{-- العنوان + زر رجوع --}}
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-semibold text-slate-900">
            إضافة مستفيد جديد
        </h1>

        <x-link href="{{ route('beneficiary.index') }}">
            ←الرجوع إلى إدارة المستفيدين
        </x-link>
    </div>

    {{-- الفورم --}}
    <section class="bg-white rounded-3xl border border-slate-100 shadow-sm p-6 md:p-7">
        <form action="{{ route('beneficiary.store') }}" method="POST" enctype="multipart/form-data"
            x-data="{ loading: false }" @submit="loading = true">
            @csrf
            {{-- أضف action="" لما تجهّز الراوت --}}

            {{-- اسم المستفيد --}}
            <div class="mb-4">
                <x-label for="fullName" :required="true">
                    الاسم الثلاثي للمستفيد
                </x-label>

                <x-text-input name="fullName" placeholder="أدخل اسم المستفيد" />
            </div>

            <div class="mb-4">
                <x-label for="surname" :required="true">
                    اللقب
                </x-label>

                <x-text-input name="surname" placeholder="أدخل اللقب" />
            </div>

            <div class="mb-4">
                <x-label for="ssn" :required="true">
                    الرقم الوطني
                </x-label>

                <x-text-input type="number" name="ssn" placeholder="أدخل الرقم الوطني" />
            </div>

            <div class="mb-4 grid grid-cols-1 md:grid-cols-2 gap-3">
                <div>
                    <x-label for="date_of_birth" :required="true">
                        تاريخ الولادة
                    </x-label>

                    <x-text-input type="date" name="date_of_birth" placeholder="أدخل تاريخ الولادة" />
                </div>

                <div>
                    <x-label for="place_of_birth" :required="true">
                        مكان الولادة
                    </x-label>

                    <x-text-input name="place_of_birth" placeholder="أدخل مكان الولادة" />
                </div>
            </div>

            <div class="mb-4">
                <x-label for="address" :required="true">
                    مكان الإقامة
                </x-label>

                <x-text-input name="address" placeholder="أدخل مكان الإقامة" />
            </div>

            <div class="mb-4">
                <x-label for="phone_number" :required="true">
                    رقم الهاتف
                </x-label>

                <x-text-input type="number" name="phone_number" placeholder="أدخل رقم الهاتف" />
            </div>

            <div class="mb-4">
                <x-label for="notes">
                    الملاحظات
                </x-label>

                <x-text-input type="textarea" name="notes" placeholder="أدخل الملاحظات" />
            </div>


            <div class="mb-4">
                <x-label for="personal_photo">
                    صورة شخصية
                </x-label>

                <x-text-input type="file" name="personal_photo" placeholder="أدخل صورة شخصية" />
            </div>

            <div class="mb-4">
                <x-label for="bank_statement_photo">
                    صورة كشف حساب
                </x-label>

                <x-text-input type="file" name="bank_statement_photo" placeholder="أدخل صورة كشف حساب" />
            </div>

            {{-- ملاحظة --}}
            <p class="text-xs text-slate-500 mb-4">
                الحقول المميزة بعلامة (<span class="text-red-500">*</span>) مطلوبة.
            </p>

            {{-- الأزرار --}}
            <div class="flex items-center justify-between gap-3 mt-8">
                <x-button x-bind:disabled="loading" class="disabled:opacity-60" type="submit">
                    <span x-show="!loading">إضافة</span>
                    <span x-show="loading" class="flex items-center gap-2">
                        <svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                            </circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path>
                        </svg>
                        جاري إضافة المستفيد...
                    </span>
                </x-button>

                <x-button type="reset">
                    إعادة تعيين
                </x-button>

            </div>

        </form>
    </section>

</x-layout-dashboard>