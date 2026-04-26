<x-layout-dashboard>
    {{-- العنوان + زر رجوع --}}
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-semibold text-slate-900">
            تفاصيل الحالة {{ $donationCase->title }}
        </h1>

        <x-link href="{{ route('donation_case.index') }}">
            ←الرجوع إلى إدارة الحالات
        </x-link>
    </div>

    <section class="bg-white rounded-3xl border border-slate-100 shadow-sm p-6 md:p-7">

        <div class="mb-4 grid grid-cols-1 md:grid-cols-2 gap-3">
            <div>
                <x-label for="fullName">
                    اسم المستفيد
                </x-label>

                <x-text-input value="{{ old('fullName', $donationCase->beneficiary->fullName) }}" name="fullName"
                    :readonly="true" />
            </div>

            <div>
                <x-label for="ssn">
                    الرقم الوطني الخاص بي المستفيد
                </x-label>

                <x-text-input value="{{ old('ssn', $donationCase->beneficiary->ssn) }}" type="number" name="ssn"
                    :readonly="true" />
            </div>
        </div>

        <div class="mb-4">
            <x-label for="title">
                عنوان الحالة
            </x-label>

            <x-text-input value="{{ old('title', $donationCase->title) }}" name="title" :readonly="true" />
        </div>

        <div class="mb-4">
            <x-label for="description">
                الوصف للحالة
            </x-label>

            <x-text-input value="{{ old('description', $donationCase->description) }}" type="textarea"
                name="description" :readonly="true" />
        </div>


        <div class="mb-4 grid grid-cols-1 md:grid-cols-2 gap-3">
            <div>
                <x-label for="target_amount">
                    المبلغ المستهدف
                </x-label>

                <x-text-input value="{{ old('target_amount', $donationCase->target_amount) }}" type="number"
                    name="target_amount" :readonly="true" />
            </div>


            <div>
                <x-label for="current_amount">
                    المبلغ المُجمع
                </x-label>

                <x-text-input value="{{ old('current_amount', $donationCase->current_amount) }}" name="current_amount"
                    :readonly="true" />
            </div>
        </div>

        <div class="mb-4">
            <x-label for="status">
                الحالة
            </x-label>

            <x-text-input value="{{ old('status', $donationCase->status) }}" name="status" :readonly="true" />
        </div>

        <div class="mb-4">
            <x-label for="type">
                نوع الحالة
            </x-label>

            <x-text-input value="{{ old('type', $donationCase->type) }}" name="type" :readonly="true" />
        </div>

        <div>
            <h3 class="text-lg font-semibold text-slate-800 mb-2">المرفقات</h3>
            @if($donationCase->img_url)
                <div class="mb-4">
                    <h4 class="font-semibold text-slate-700">صورة الحالة</h4>
                    <img src="{{ asset('storage/' . $donationCase->img_url) }}" alt="صورة الحالة"
                        class="mt-2 rounded-lg border border-slate-200" style="max-width: 300px;">
                </div>
            @endif
            @if(!$donationCase->img_url)
                <p class="text-slate-500">لا توجد مرفقات لعرضها.</p>
            @endif
        </div>

        <div class="mb-4 text-xs text-slate-600">
            تم انشاء هذي الحالة منذُ {{ $donationCase->created_at->diffForHumans() }}
        </div>

        {{-- الأزرار --}}
        <div class="flex items-center justify-between gap-3 mt-8">
            <x-link-button href="{{ route('donation_case.edit', $donationCase) }}">
                تعديل الحالة
            </x-link-button>
        </div>

    </section>
</x-layout-dashboard>