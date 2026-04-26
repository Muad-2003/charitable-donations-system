<label class="block text-xs font-medium text-slate-700 mb-1" for="{{ $for }}">
    {{ $slot }}
    @if ($required)
        <span class="text-red-500">*</span>
    @endif
</label>