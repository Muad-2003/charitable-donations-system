<div class="relative" @if($type=='password') x-data="{ show:false }" @endif>
    
    @if ('textarea' != $type)
        @if ($formRef)
            <button type="button" class="absolute top-0 right-0 flex h-full items-center pr-2"
                @click="$refs['input-{{ $name }}'].value = ''; $refs['{{ $formRef }}'].submit();">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                    class="size-4 text-slate-500">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                </svg>
            </button>
        @endif

        @if ($type == 'password')
            <input x-ref="input-{{ $name }}" :type="show ? 'text' : 'password'" placeholder="{{ $placeholder }}" name="{{ $name }}"
                value="{{ old($name, $value) }}" id="{{ $name }}" @class([
                    'w-full rounded-2xl border border-slate-200 bg-slate-50 px-3 py-2.5 text-sm text-right focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500',
                    'pr-8' => $formRef,
                    'pl-12',
                    'ring-slate-300' => !$errors->has($name),
                    'ring-red-300' => $errors->has($name)
                ]) {{ $readonly ? 'readonly' : '' }} {{ $attributes }} />


            {{-- button to show / hide password --}}
            <button type="button" @click="show = !show" :aria-label="show ? 'إخفاء كلمة المرور' : 'إظهار كلمة المرور'" title="إظهار/إخفاء كلمة المرور" class="absolute inset-y-0 left-3 flex items-center px-2 text-slate-500 hover:text-slate-700">
                <svg x-show="!show" x-cloak xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322A10.094 10.094 0 0112 6.75c4.478 0 8.268 2.943 9.964 5.572a.75.75 0 010 .356C20.268 16.307 16.478 19.25 12 19.25c-3.064 0-5.773-1.435-7.536-3.443M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                <svg x-show="show" x-cloak xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 3l18 18M9.88 9.88A3 3 0 0114.12 14.12M12 6.75c4.478 0 8.268 2.943 9.964 5.572a.75.75 0 010 .356C20.268 16.307 16.478 19.25 12 19.25c-1.042 0-2.046-.168-2.98-.48" />
                </svg>
            </button>

            
        @else
            <input x-ref="input-{{ $name }}" type="{{ $type }}" placeholder="{{ $placeholder }}" name="{{ $name }}"
                value="{{ old($name, $value) }}" id="{{ $name }}" @class([
                    'w-full rounded-2xl border border-slate-200 bg-slate-50 px-3 py-2.5 text-sm text-right focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500',
                    'pr-8' => $formRef,
                    'ring-slate-300' => !$errors->has($name),
                    'ring-red-300' => $errors->has($name)
                ]) {{ $readonly ? 'readonly' : '' }} {{ $attributes }} />
        @endif

    @else
        <textarea id="{{ $name }}" name=" {{ $name }}" placeholder="{{ $placeholder }}" @class([
            'w-full rounded-2xl border border-slate-200 bg-slate-50 px-3 py-2.5 text-sm text-right focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500',
            'pr-8' => $formRef,
            'ring-slate-300' => !$errors->has($name),
            'ring-red-300' => $errors->has($name)
        ]) {{ $readonly ? 'readonly' : '' }} {{ $attributes }} >{{ old($name, $value) }}</textarea>
    @endif
    
    
    @error($name)
        <div class="mt-1 text-xs text-red-500">
            {{ $message }}
        </div>
    @enderror
</div>