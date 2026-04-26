<label for="{{ $name }}" class="flex items-center gap-2 cursor-pointer">
    <input class="w-4 h-4 text-emerald-600 border-slate-300 focus:ring-emerald-500"
        type="radio" name="{{ $name }}" value="{{ $value }}"  @checked($selected == $value) />
    <span class="text-slate-700">{{ $label }}</span>
</label>