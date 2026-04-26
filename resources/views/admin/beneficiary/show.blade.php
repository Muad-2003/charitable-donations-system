<x-layout-dashboard>

    {{-- العنوان + زر رجوع --}}
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-xl font-semibold text-slate-900">
            تفاصيل المستفيد : {{ $beneficiary->fullName }}
        </h1>

        <div
            class="px-4 py-1.5  text-slate-900 transition flex items-center gap-1">
            <span class="flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M21 12a2.25 2.25 0 0 0-2.25-2.25H15a3 3 0 1 1-6 0H5.25A2.25 2.25 0 0 0 3 12m18 0v6a2.25 2.25 0 0 1-2.25 2.25H5.25A2.25 2.25 0 0 1 3 18v-6m18 0V9M3 12V9m18 0a2.25 2.25 0 0 0-2.25-2.25H5.25A2.25 2.25 0 0 0 3 9m18 0V6a2.25 2.25 0 0 0-2.25-2.25H5.25A2.25 2.25 0 0 0 3 6v3" />
                </svg>
                {{ number_format($beneficiary->wallet->balance, 2) }}
            </span>
            د.ل
        </div>

        <x-link href="{{ route('beneficiary.index') }}">
            ←الرجوع إلى إدارة المستفيدين
        </x-link>
    </div>



    {{-- الفورم --}}
    <section class="bg-white rounded-3xl border border-slate-100 shadow-sm p-6 md:p-7">

        {{-- اسم المستفيد --}}
        <div class="mb-4">
            <x-label for="fullName">
                الاسم الثلاثي للمستفيد
            </x-label>

            <x-text-input value="{{ $beneficiary->fullName }}" name="fullName" placeholder="أدخل اسم المستفيد"
                :readonly="true" />
        </div>

        <div class="mb-4">
            <x-label for="surname">
                اللقب
            </x-label>

            <x-text-input value="{{ $beneficiary->surname }}" name="surname" placeholder="أدخل اللقب"
                :readonly="true" />
        </div>

        <div class="mb-4">
            <x-label for="ssn">
                الرقم الوطني
            </x-label>

            <x-text-input value="{{ $beneficiary->ssn }}" type="number" name="ssn" placeholder="أدخل الرقم الوطني"
                :readonly="true" />
        </div>

        <div class="mb-4 grid grid-cols-1 md:grid-cols-2 gap-3">
            <div>
                <x-label for="date_of_birth">
                    تاريخ الولادة
                </x-label>

                <x-text-input value="{{ $beneficiary->date_of_birth }}" type="date" name="date_of_birth"
                    placeholder="أدخل تاريخ الولادة" :readonly="true" />
            </div>

            <div>
                <x-label for="place_of_birth">
                    مكان الولادة
                </x-label>

                <x-text-input value="{{ $beneficiary->place_of_birth }}" name="place_of_birth"
                    placeholder="أدخل مكان الولادة" :readonly="true" />
            </div>
        </div>

        <div class="mb-4">
            <x-label for="address">
                مكان الإقامة
            </x-label>

            <x-text-input value="{{ $beneficiary->address }}" name="address" placeholder="أدخل مكان الإقامة"
                :readonly="true" />
        </div>

        <div class="mb-4">
            <x-label for="phone_number">
                رقم الهاتف
            </x-label>

            <x-text-input value="{{ $beneficiary->phone_number }}" name="phone_number" :readonly="true" />
        </div>

        <div class="mb-4">
            <x-label for="notes">
                الملاحظات
            </x-label>

            <x-text-input value="{{$beneficiary->notes }}" type="textarea" name="notes" placeholder="أدخل الملاحظات"
                :readonly="true" />
        </div>

        <div>
            <h3 class="text-lg font-semibold text-slate-800 mb-2">المرفقات</h3>
            @if($beneficiary->personal_photo_path)
                <div class="mb-4">
                    <h4 class="font-semibold text-slate-700">الصورة الشخصية</h4>
                    <img src="{{ asset('storage/' . $beneficiary->personal_photo_path) }}" alt="الصورة الشخصية"
                        class="mt-2 rounded-lg border border-slate-200" style="max-width: 300px;">
                </div>
            @endif
            @if($beneficiary->bank_statement_photo_path)
                <div>
                    <h4 class="font-semibold text-slate-700">صورة كشف الحساب</h4>
                    <img src="{{ asset('storage/' . $beneficiary->bank_statement_photo_path) }}" alt="صورة كشف الحساب"
                        class="mt-2 rounded-lg border border-slate-200" style="max-width: 300px;">
                </div>
            @endif
            @if(!$beneficiary->personal_photo_path && !$beneficiary->bank_statement_photo_path)
                <p class="text-slate-500">لا توجد مرفقات لعرضها.</p>
            @endif
        </div>

        {{-- <div class="mb-4">
            <x-label for="personal_photo">
                صورة شخصية
            </x-label>

            <x-text-input value="{{ old('personal_photo', $beneficiary->personal_photo) }}" type="file"
                name="personal_photo" placeholder="أدخل صورة شخصية" />
        </div>

        <div class="mb-4">
            <x-label for="bank_statement_photo">
                صورة كشف حساب
            </x-label>

            <x-text-input value="{{ old('bank_statement_photo', $beneficiary->bank_statement_photo) }}" type="file"
                name="bank_statement_photo" placeholder="أدخل صورة كشف حساب" />
        </div> --}}

        {{-- الأزرار --}}
        <div class="flex items-center justify-between gap-3 mt-8">
            <x-link-button href="{{ route('beneficiary.create') }}">
                إضافة مستفيد جديد
            </x-link-button>
        </div>

    </section>
</x-layout-dashboard>