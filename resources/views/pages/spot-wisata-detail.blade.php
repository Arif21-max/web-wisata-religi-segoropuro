@extends('layouts.app')

@section('title', $spot->nama_spot . ' - Spot Wisata Makam Sayyid Arif Segoropuro')

@section('description', ($spot->deskripsi_singkat ?: \Illuminate\Support\Str::limit($spot->deskripsi_lengkap, 160)))

@section('og_image', media_url($spot->getFotoPertama()))

@section('jsonld')
    <script type="application/ld+json">
    {
        "@@context": "https://schema.org",
        "@graph": [
            {
                "@type": "TouristAttraction",
                "@id": "{{ route('spot-wisata.show', $spot) }}#attraction",
                "name": {!! json_encode($spot->nama_spot, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT) !!},
                "url": "{{ route('spot-wisata.show', $spot) }}",
                "image": @json($spot->getFotoList()->map(fn ($p) => media_url($p))->values()->all()),
                "description": {!! json_encode($spot->deskripsi_singkat ?: $spot->deskripsi_lengkap, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT) !!},
                "isPartOf": {
                    "@type": "TouristAttraction",
                    "name": "{{ config('segoropuro.seo.site_name') }}",
                    "url": "{{ url('/') }}"
                },
                "address": {
                    "@type": "PostalAddress",
                    "streetAddress": "Desa Segoropuro, Kecamatan {{ config('segoropuro.seo.kecamatan') }}",
                    "addressLocality": "Kabupaten {{ config('segoropuro.seo.kabupaten') }}",
                    "addressRegion": "{{ config('segoropuro.seo.provinsi') }}",
                    "addressCountry": "ID"
                },
                "geo": {
                    "@type": "GeoCoordinates",
                    "latitude": {{ config('segoropuro.seo.latitude') }},
                    "longitude": {{ config('segoropuro.seo.longitude') }}
                },
                "isAccessibleForFree": true,
                "publicAccess": true
            },
            {
                "@type": "BreadcrumbList",
                "itemListElement": [
                    { "@type": "ListItem", "position": 1, "name": "Beranda", "item": "{{ url('/') }}" },
                    { "@type": "ListItem", "position": 2, "name": "Spot Wisata & Fasilitas", "item": "{{ route('spot-wisata.index') }}" },
                    { "@type": "ListItem", "position": 3, "name": {!! json_encode($spot->nama_spot, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT) !!} }
                ]
            }
        ]
    }
    </script>
@endsection

@section('content')
    @php
        $photos = $spot->getFotoList()->map(fn ($p) => media_url($p))->values();
    @endphp

    <section class="relative overflow-hidden bg-brand-950 py-16">
        <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(circle at 70% 20%, #d9a93c 0, transparent 35%), radial-gradient(circle at 20% 80%, #348362 0, transparent 40%);"></div>
        <div class="relative mx-auto max-w-4xl px-4 text-center sm:px-6 lg:px-8">
            <a href="{{ route('spot-wisata.index') }}" class="animate-fade-up inline-flex items-center gap-2 rounded-full border border-white/20 bg-white/10 px-4 py-1.5 text-sm font-semibold text-brand-100 transition hover:bg-white/20">
                <i class="fa-solid fa-arrow-left"></i> Kembali ke Spot Wisata
            </a>
            <span class="animate-fade-up ms-2 inline-flex items-center rounded-full px-4 py-1.5 text-sm font-semibold" style="background: {{ $spot->warna_bg }}33; color: {{ $spot->warna_bg }}; animation-delay: 120ms">
                <i class="fa-solid fa-mosque"></i> Spot Wisata
            </span>
            <h1 class="animate-fade-up mt-4 font-display text-3xl font-extrabold text-white sm:text-5xl" style="animation-delay: 240ms">{{ $spot->nama_spot }}</h1>
        </div>
    </section>

    <section class="mx-auto max-w-5xl px-4 py-10 sm:px-6 lg:px-8">
        <div x-data="{ current: 0, next() { this.current = (this.current + 1) % @js($photos->count()); }, prev() { this.current = (this.current - 1 + @js($photos->count())) % @js($photos->count()); } }"
             data-reveal
             class="overflow-hidden rounded-2xl border border-stone-200 bg-white shadow-sm">
            <div class="relative aspect-[16/10] bg-stone-900">
                @foreach ($photos as $i => $photo)
                    <img src="{{ $photo }}" alt="Foto {{ $i + 1 }} {{ $spot->nama_spot }}" loading="{{ $i === 0 ? 'eager' : 'lazy' }}"
                         class="absolute inset-0 h-full w-full object-cover transition-opacity duration-500"
                         :class="@js($i) === current ? 'opacity-100' : 'opacity-0'">
                @endforeach

                @if ($photos->count() > 1)
                    <button type="button" @click="prev" class="absolute left-4 top-1/2 z-10 -translate-y-1/2 rounded-full bg-black/40 p-3 text-white backdrop-blur transition hover:bg-brand-700" aria-label="Foto sebelumnya">
                        <i class="fa-solid fa-chevron-left"></i>
                    </button>
                    <button type="button" @click="next" class="absolute right-4 top-1/2 z-10 -translate-y-1/2 rounded-full bg-black/40 p-3 text-white backdrop-blur transition hover:bg-brand-700" aria-label="Foto berikutnya">
                        <i class="fa-solid fa-chevron-right"></i>
                    </button>
                @endif

                <div class="absolute inset-x-0 bottom-0 flex justify-center gap-1.5 py-3" x-show="@js($photos->count()) > 1" x-cloak>
                    @foreach ($photos as $i => $photo)
                        <span class="h-1.5 rounded-full transition-all" :class="@js($i) === current ? 'w-5 bg-gold-400' : 'w-1.5 bg-white/60'"></span>
                    @endforeach
                </div>
            </div>

            <div class="p-6 sm:p-10">
                <div class="h-1 w-16 rounded-full" style="background: {{ $spot->warna_bg }}"></div>
                <h2 class="mt-4 font-display text-2xl font-bold text-stone-900">{{ $spot->nama_spot }}</h2>

                <div class="prose-article mt-6 space-y-4 text-[15px] leading-relaxed text-stone-700">
                    {{ $spot->deskripsi_lengkap }}
                </div>

                <div class="mt-8 flex flex-wrap gap-3 border-t border-stone-200 pt-6">
                    <a href="{{ wa_url('Halo, saya ingin bertanya tentang spot ' . $spot->nama_spot . ' di Makam Sayyid Arif Segoropuro.') }}" target="_blank" rel="noopener" class="btn-whatsapp !px-4 !py-2 !text-sm">
                        <i class="fa-brands fa-whatsapp"></i> Tanya via WhatsApp
                    </a>
                    <a href="{{ route('spot-wisata.index') }}" class="btn-outline !px-4 !py-2 !text-sm">
                        <i class="fa-solid fa-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>
        </div>

        @if ($spotLainnya->isNotEmpty())
            <div class="mt-14">
                <div class="mb-6 flex items-center justify-between">
                    <h2 class="section-title !text-2xl">Spot Wisata Lainnya</h2>
                    <a href="{{ route('spot-wisata.index') }}" class="text-sm font-semibold text-brand-700 hover:underline">Lihat semua <i class="fa-solid fa-arrow-right ms-1"></i></a>
                </div>

                <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($spotLainnya as $lain)
                        <div data-reveal style="--reveal-delay: {{ $loop->index % 3 * 100 }}ms">
                            <x-spot-card :spot="$lain"/>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </section>
@endsection
