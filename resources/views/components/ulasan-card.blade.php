@props(['ulasan'])
<div class="w-80 shrink-0 rounded-2xl border border-stone-200 bg-white p-6 shadow-sm">
    <div class="flex items-center gap-3">
        <span class="flex h-11 w-11 items-center justify-center rounded-full bg-brand-700 font-bold text-white">{{ $ulasan->getInisial() }}</span>
        <div>
            <p class="font-semibold text-stone-900">{{ $ulasan->nama }}</p>
            <p class="flex items-center gap-1 text-xs text-stone-400"><i class="fa-solid fa-location-dot"></i>{{ $ulasan->asal_kota }}</p>
        </div>
    </div>
    <p class="mt-4 text-sm leading-relaxed text-stone-600 line-clamp-3">"{{ $ulasan->pesan_doa }}"</p>
    <div class="mt-3 text-xs text-gold-500"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></div>
</div>