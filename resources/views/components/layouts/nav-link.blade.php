@props(['href' => '#', 'active' => false])
<a href="{{ $href }}" @class([
    'flex items-center rounded-lg px-3 py-2 text-sm font-medium transition lg:py-1.5',
    'text-brand-800 bg-brand-50' => $active,
    'text-stone-600 hover:bg-stone-100 hover:text-brand-800' => ! $active,
])>
    {{ $slot }}
</a>
