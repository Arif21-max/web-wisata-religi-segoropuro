@props(['spot'])

@php
    $photos = $spot->getFotoList()->map(fn ($p) => media_url($p))->values();
    $fotoPertama = $photos->first() ?? asset('img/logo.png');
@endphp

<article
    x-data="{
        photos: @js($photos),
        current: 0,
        next() { this.current = (this.current + 1) % this.photos.length; },
        prev() { this.current = (this.current - 1 + this.photos.length) % this.photos.length; },
    }"
    class="group flex flex-col overflow-hidden rounded-2xl border border-stone-200 bg-white shadow-sm transition hover:-translate-y-1 hover:shadow-xl"
>
    <div class="relative aspect-[16/10] overflow-hidden bg-stone-900">
        <a href="{{ route('spot-wisata.show', $spot) }}" class="absolute inset-0 block" aria-label="Lihat detail {{ $spot->nama_spot }}">
            <template x-for="(photo, i) in photos" :key="i">
                <img :src="photo" :alt="'Foto ' + (i + 1)" loading="lazy"
                     class="absolute inset-0 h-full w-full object-cover transition-[opacity,transform] duration-500 group-hover:scale-[1.05]"
                     :class="i === current ? 'opacity-100' : 'opacity-0'">
            </template>

            <span class="absolute left-3 top-3 rounded-full px-3 py-1 text-xs font-semibold text-white shadow" :style="'background: ' + @js($spot->warna_bg)">
                Spot Wisata
            </span>
        </a>

        <template x-if="photos.length > 1">
            <div class="absolute inset-x-0 top-1/2 z-10 flex -translate-y-1/2 justify-between px-2">
                <button type="button" @click.stop="prev" class="rounded-full bg-black/40 p-2 text-white backdrop-blur transition hover:bg-brand-700" aria-label="Foto sebelumnya">
                    <i class="fa-solid fa-chevron-left text-sm"></i>
                </button>
                <button type="button" @click.stop="next" class="rounded-full bg-black/40 p-2 text-white backdrop-blur transition hover:bg-brand-700" aria-label="Foto berikutnya">
                    <i class="fa-solid fa-chevron-right text-sm"></i>
                </button>
            </div>
        </template>

        <div class="absolute inset-x-0 bottom-0 z-10 flex justify-center gap-1.5 pb-2" x-show="photos.length > 1">
            <template x-for="(photo, i) in photos" :key="'d' + i">
                <span class="h-1.5 rounded-full transition-all" :class="i === current ? 'w-5 bg-gold-400' : 'w-1.5 bg-white/60'"></span>
            </template>
        </div>
    </div>

    <div class="flex flex-1 flex-col p-5">
        <a href="{{ route('spot-wisata.show', $spot) }}">
            <h3 class="font-display text-lg font-bold text-stone-900 transition group-hover:text-brand-700">{{ $spot->nama_spot }}</h3>
        </a>
        <p class="mt-2 flex-1 text-sm leading-relaxed text-stone-500 line-clamp-2">{{ $spot->deskripsi_singkat }}</p>

        <div class="mt-4 flex items-center justify-between">
            <a href="{{ route('spot-wisata.show', $spot) }}" class="btn-primary !px-4 !py-2 !text-sm">
                <i class="fa-regular fa-eye"></i> Lihat Detail
            </a>
            <span class="text-xs text-stone-400" x-show="photos.length > 1" x-cloak>
                <i class="fa-solid fa-images"></i> <span x-text="photos.length"></span> foto
            </span>
        </div>
    </div>
</article>
