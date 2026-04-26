<x-layout-dashboard>
    
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-semibold text-slate-900">
            تعديل الحالة {{ $donationCase->title }}
        </h1>

        <x-link href="{{ route('donation_case.index') }}">
            ←الرجوع إلى إدارة الحالات
        </x-link>
    </div>

    <section class="bg-white rounded-3xl border border-slate-100 shadow-sm p-6 md:p-7">
        <form action="{{ route('donation_case.update', $donationCase->id) }}" method="POST"
            enctype="multipart/form-data" x-data="{ loading: false }" @submit="loading = true">
            @csrf
            @method('PUT')


            
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
                        الرقم الوطني الخاص يس المستفيد
                    </x-label>

                    <x-text-input value="{{ old('ssn', $donationCase->beneficiary->ssn) }}" type="number" name="ssn"
                        :readonly="true" />
                </div>
            </div>


            <div class="mb-4 grid grid-cols-1 md:grid-cols-2 gap-3">

                
                <div>
                    <x-label for="title" :required="true">
                        عنوان للحالة
                    </x-label>

                    <x-text-input value="{{ old('title', $donationCase->title) }}" name="title"
                        placeholder="أدخل عنوان للحالة" />
                </div>

                
                <div>
                    <x-label for="type" :required="true">
                        نوع التبرع
                    </x-label>
                    <select name="type"
                        class="pr-8 w-full rounded-2xl border border-slate-200 bg-slate-50 px-3 py-2.5 text-sm text-right focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                        <option>
                            {{ old('type', $donationCase->type) }}
                        </option>
                        <option>وقف</option>
                        <option>يتيم</option>
                        <option>صدقة</option>
                        <option>علاج</option>
                    </select>
                </div>
            </div>


            
            <div class="mb-4 grid grid-cols-1 md:grid-cols-2 gap-3">

                <div>
                    <x-label for="target_amount" :required="true">
                        المبلغ المستهدف
                    </x-label>

                    <x-text-input value="{{ old('target_amount', $donationCase->target_amount) }}" type="number"
                        name="target_amount" placeholder="0.00" />
                </div>


                <div>
                    <x-label for="current_amount">
                        المبلغ المُجمع
                    </x-label>

                    <x-text-input value="{{ old('current_amount', $donationCase->current_amount) }}"
                        name="current_amount" :readonly="true" />
                </div>
            </div>


            
            <div class="mb-4">
                <x-label for="description">
                    وصف للحالة
                </x-label>

                <x-text-input type="textarea" name="description"
                    value="{{ old('description', $donationCase->description) }}"
                    placeholder="أدخل اي ملاحظه لديك بخصوص الحالة" />
            </div>



            
            <div class="mb-4">
                <div class="my-4 bg-slate-200 h-px w-full border-b border-slate-300"></div>

                <h3 class="text-lg font-semibold text-slate-800 mb-4">المرفقات</h3>

                <div class="mb-4 flex items-center space-x-8">
                    <div>
                        <x-label for="img">
                            صورة وصفية للحالة
                        </x-label>

                        <x-text-input value="{{ asset('storage/' . $donationCase->img_url) }}" type="file" name="img"
                            placeholder="أدخل صورة وصفية" />
                    </div>
                    @if($donationCase->img_url)
                        <div>
                            <h4 class="font-semibold text-slate-700">الصورة الوصفية</h4>
                            <img src="{{ asset('storage/' . $donationCase->img_url) }}" alt="الصورة الوصفية"
                                class="mt-2 rounded-lg border border-slate-200" style="max-width: 300px;">
                        </div>
                    @endif
                </div>

                <div class="my-4 bg-slate-200 h-px w-full border-b border-slate-300"></div>
            </div>


            
            <div class="mb-4">
                <x-label :required="true">وضع الحالة</x-label>

                <div class="flex items-center gap-6 text-sm">

                    <x-radio name="status" :value="'active'" :label="'مؤكدة'" :selected="$donationCase->status" />

                    <x-radio name="status" :value="'pending'" :label="'معلق'" :selected="$donationCase->status" />

                </div>
            </div>



            
            <p class="text-xs text-slate-500 mb-4">
                الحقول المميزة بعلامة (<span class="text-red-500">*</span>) مطلوبة.
            </p>

            
            <div class="flex items-center justify-between gap-3 mt-8">
                <x-button x-bind:disabled="loading" class="disabled:opacity-60" type="submit">
                    <span x-show="!loading">تعديل</span>
                    <span x-show="loading" class="flex items-center gap-2">
                        <svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                            </circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path>
                        </svg>
                        جاري تعديل الحالة...
                    </span>
                </x-button>

                <x-button type="reset">
                    إعادة تعيين
                </x-button>

            </div>

        </form>
    </section>
</x-layout-dashboard>