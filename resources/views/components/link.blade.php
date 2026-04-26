<a   href="{{ $href }}" 
    {{-- class="text-xs text-slate-500 hover:text-slate-700" --}}
    {{ $attributes->class(['text-xs text-slate-500 hover:text-slate-700']) }}>
    {{ $slot }}
</a>