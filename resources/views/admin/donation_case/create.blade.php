<x-layout-dashboard>
    
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-semibold text-slate-900">
            إضافة حالة جديدة
        </h1>

        <x-link href="{{ route('donation_case.index') }}">
            ←الرجوع إلى إدارة الحالات
        </x-link>
    </div>

    <section class="bg-white rounded-3xl border border-slate-100 shadow-sm p-6 md:p-7">
        <form action="{{ route('donation_case.store') }}" method="POST" enctype="multipart/form-data"
            x-data="{ loading: false }" @submit="loading = true">
            @csrf


            {{-- المستفيدين --}}
            <x-select-beneficiary :beneficiaries="$beneficiaries" :name="'beneficiary_id'" :label="'اختر المستفيد'" />

            <div class="mb-4 grid grid-cols-1 md:grid-cols-2 gap-3">

                
                <div>
                    <x-label for="title" :required="true">
                        عنوان للحالة
                    </x-label>

                    <x-text-input name="title" placeholder="أدخل عنوان للحالة" />
                </div>

                
                <div>
                    <x-label for="type" :required="true">
                        نوع التبرع
                    </x-label>
                    <select name="type"
                        class="pr-8 w-full rounded-2xl border border-slate-200 bg-slate-50 px-3 py-2.5 text-sm text-right focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                        <option>وقف</option>
                        <option>يتيم</option>
                        <option>صدقة</option>
                        <option>علاج</option>
                    </select>
                </div>
            </div>

            
            <div class="mb-4">
                <x-label for="target_amount" :required="true">
                    المبلغ المستهدف
                </x-label>

                <x-text-input type="number" name="target_amount" placeholder="0.00" />
            </div>


            
            <div class="mb-4">
                <x-label for="description">
                    وصف للحالة
                </x-label>

                <x-text-input type="textarea" name="description" placeholder="أدخل اي ملاحظه لديك بخصوص الحالة" />
            </div>


            
            <div class="mb-4">
                <x-label for="img">
                    صورة وصفية للحالة
                </x-label>

                <x-text-input type="file" name="img" placeholder="أدخل صورة" />
            </div>


            
            <div class="mb-4">
                <x-label :required="true">وضع الحالة</x-label>

                <div class="flex items-center gap-6 text-sm">

                    <x-radio name="status" :value="'active'" :label="'مؤكدة'" />

                    <x-radio name="status" :value="'pending'" :label="'معلقة'" />

                </div>
            </div>


            
            <p class="text-xs text-slate-500 mb-4">
                الحقول المميزة بعلامة (<span class="text-red-500">*</span>) مطلوبة.
            </p>

            
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
                        جاري إضافة الحالة...
                    </span>
                </x-button>

                <x-button type="reset">
                    إعادة تعيين
                </x-button>

            </div>

        </form>
    </section>
</x-layout-dashboard>