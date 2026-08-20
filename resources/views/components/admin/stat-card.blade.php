@props(['icon' => 'fa-solid fa-circle', 'label' => '', 'value' => '0', 'color' => 'text-stone-600 bg-stone-100'])
<div class="rounded-2xl border border-stone-200 bg-white p-5 shadow-sm transition hover:shadow-md">
    <div class="flex items-center justify-between">
        <div>
            <p class="text-xs font-semibold uppercase tracking-wide text-stone-400">{{ $label }}</p>
            <p class="mt-2 text-2xl font-extrabold text-stone-900">{{ $value }}</p>
        </div>
        <span class="flex h-12 w-12 items-center justify-center rounded-xl text-lg {{ $color }}">
            <i class="{{ $icon }}"></i>
        </span>
    </div>
</div>