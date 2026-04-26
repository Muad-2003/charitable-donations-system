{{-- <a href="{{ $href }}" class="text-center rounded-full bg-slate-900 text-white text-sm px-4 py-2 hover:bg-black">
    {{ $slot }}
</a> --}}
@props(['active' => false, 'href' => '#'])

<a href="{{ $href }}" {{ $attributes->class([
    'text-center rounded-full text-sm px-4 py-2',
    'bg-slate-900 text-white hover:bg-black' => !$active,
    'bg-emerald-700 text-white font-medium hover:bg-emerald-800' => $active,
]) }}>
    {{ $slot }}
</a>