<x-layout-dashboard>

    {{-- العنوان + زر رجوع --}}
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-semibold text-slate-900">
            تعديل المستفيد {{ $beneficiary->fullName }}
        </h1>

        <x-link href="{{ route('beneficiary.index') }}">
            ←الرجوع إلى إدارة المستفيدين
        </x-link>
    </div>

    {{-- الفورم --}}
    <section class="bg-white rounded-3xl border border-slate-100 shadow-sm p-6 md:p-7">

        <form action="{{ route('beneficiary.update', $beneficiary->id) }}" method="POST" enctype="multipart/form-data"
            x-data="{ loading: false }" @submit="loading = true">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <x-label for="fullName">
                    الاسم الثلاثي للمستفيد
                </x-label>

                <x-text-input value="{{ old('fullName', $beneficiary->fullName) }}" name="fullName"
                    placeholder="أدخل اسم المستفيد" />
            </div>

            <div class="mb-4">
                <x-label for="surname">
                    اللقب
                </x-label>

                <x-text-input value="{{ old('surname', $beneficiary->surname) }}" name="surname"
                    placeholder="أدخل اللقب" />
            </div>

            <div class="mb-4">
                <x-label for="ssn">
                    الرقم الوطني
                </x-label>

                <x-text-input value="{{ old('ssn', $beneficiary->ssn) }}" type="number" name="ssn"
                    placeholder="أدخل الرقم الوطني" />
            </div>

            <div class="mb-4 grid grid-cols-1 md:grid-cols-2 gap-3">
                <div>
                    <x-label for="date_of_birth">
                        تاريخ الولادة
                    </x-label>

                    <x-text-input value="{{ old('date_of_birth', $beneficiary->date_of_birth) }}" type="date"
                        name="date_of_birth" placeholder="أدخل تاريخ الولادة" />
                </div>

                <div>
                    <x-label for="place_of_birth">
                        مكان الولادة
                    </x-label>

                    <x-text-input value="{{ old('place_of_birth', $beneficiary->place_of_birth) }}"
                        name="place_of_birth" placeholder="أدخل مكان الولادة" />
                </div>
            </div>

            <div class="mb-4">
                <x-label for="address">
                    مكان الإقامة
                </x-label>

                <x-text-input value="{{ old('address', $beneficiary->address) }}" name="address"
                    placeholder="أدخل مكان الإقامة" />
            </div>

            <div class="mb-4">
                <x-label for="phone_number">
                    رقم الهاتف
                </x-label>

                <x-text-input value="{{ old('phone_number', $beneficiary->phone_number) }}" name="phone_number" />
            </div>

            <div class="mb-4">
                <x-label for="notes">
                    الملاحظات
                </x-label>

                <x-text-input value="{{ old('notes', $beneficiary->notes) }}" type="textarea" name="notes"
                    placeholder="أدخل الملاحظات" />
            </div>

            <div>
                <h3 class="text-lg font-semibold text-slate-800 mb-4">المرفقات</h3>

                <div class="mb-4 flex items-center space-x-8">
                    <div>
                        <x-label for="personal_photo">
                            صورة شخصية
                        </x-label>

                        <x-text-input value="{{ asset('storage/' . $beneficiary->bank_statement_photo_path) }}"
                            type="file" name="personal_photo" placeholder="أدخل صورة شخصية" />
                    </div>
                    @if($beneficiary->personal_photo_path)
                        <div>
                            <h4 class="font-semibold text-slate-700">الصورة الشخصية</h4>
                            <img src="{{ asset('storage/' . $beneficiary->personal_photo_path) }}" alt="الصورة الشخصية"
                                class="mt-2 rounded-lg border border-slate-200" style="max-width: 300px;">
                        </div>
                    @endif
                </div>


                <div class="my-4 bg-slate-200 h-px w-full border-b border-slate-300"></div>


                <div class="mb-4 flex items-center space-x-8">
                    <div>
                        <x-label for="bank_statement_photo">
                            صورة كشف حساب
                        </x-label>

                        <x-text-input value="{{ asset('storage/' . $beneficiary->bank_statement_photo_path) }}"
                            type="file" name="bank_statement_photo" placeholder="أدخل صورة كشف حساب" />
                    </div>
                    @if($beneficiary->bank_statement_photo_path)
                        <div>
                            <h4 class="font-semibold text-slate-700">صورة كشف الحساب</h4>
                            <img src="{{ asset('storage/' . $beneficiary->bank_statement_photo_path) }}"
                                alt="صورة كشف الحساب" class="mt-2 rounded-lg border border-slate-200"
                                style="max-width: 300px;">
                        </div>
                    @endif

                </div>

                @if(!$beneficiary->personal_photo_path && !$beneficiary->bank_statement_photo_path)
                    <p class="text-slate-500">لا توجد صور لعرضها.</p>
                @endif
            </div>



            {{-- الأزرار --}}
            <div class="flex items-center justify-between gap-3 mt-10">
                <x-button x-bind:disabled="loading" class="disabled:opacity-60" type="submit">
                    <span x-show="!loading">تعديل</span>
                    <span x-show="loading" class="flex items-center gap-2">
                        <svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                            </circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path>
                        </svg>
                        جاري تعديل المستفيد...
                    </span>
                </x-button>

                <x-button type="reset">
                    إعادة تعيين
                </x-button>

            </div>

        </form>


    </section>
</x-layout-dashboard>