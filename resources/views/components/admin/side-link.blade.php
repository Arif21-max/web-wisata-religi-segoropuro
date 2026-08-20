@props(['href' => '#', 'active' => false, 'icon' => 'fa-solid fa-circle'])
<a href="{{ $href }}" @class([
    'flex items-center gap-3 rounded-xl px-4 py-2.5 font-medium transition',
    'bg-brand-700 text-white shadow' => $active,
    'text-brand-200 hover:bg-brand-900 hover:text-white' => ! $active,
])>
    <i class="{{ $icon }} w-5 text-center"></i>
    <span>{{ $slot }}</span>
</a>
