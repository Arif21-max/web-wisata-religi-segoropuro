@extends('layouts.app')

@section('title', $berita->judul . ' - Berita & Acara Makam Sayyid Arif Segoropuro')

@section('description', ($berita->ringkasan ?: \Illuminate\Support\Str::limit(strip_tags($berita->konten), 160)))

@section('og_type', 'article')

@if ($berita->gambar)
    @section('og_image', media_url($berita->gambar))
@endif

@section('jsonld')
    <script type="application/ld+json">
    {
        "@@context": "https://schema.org",
        "@graph": [
            {
                "@type": "NewsArticle",
                "mainEntityOfPage": {
                    "@type": "WebPage",
                    "@id": "{{ route('berita.show', $berita) }}"
                },
                "headline": {!! json_encode($berita->judul, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT) !!},
                "description": @json($__env->yieldContent('description')),
                "image": @json($berita->gambar ? media_url($berita->gambar) : null),
                "author": {
                    "@type": "Organization",
                    "name": {!! json_encode($berita->penulis ?: config('segoropuro.seo.site_name'), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT) !!}
                },
                "publisher": {
                    "@type": "Organization",
                    "name": "{{ config('segoropuro.seo.site_name') }}",
                    "logo": {
                        "@type": "ImageObject",
                        "url": "{{ asset('img/logo.png') }}"
                    }
                },
                "datePublished": "{{ $berita->created_at?->toIso8601String() ?? now()->toIso8601String() }}",
                "dateModified": "{{ ($berita->updated_at ?? $berita->created_at)?->toIso8601String() ?? now()->toIso8601String() }}",
                "inLanguage": "id-ID"
            },
            {
                "@type": "BreadcrumbList",
                "itemListElement": [
                    { "@type": "ListItem", "position": 1, "name": "Beranda", "item": "{{ url('/') }}" },
                    { "@type": "ListItem", "position": 2, "name": "Berita & Acara", "item": "{{ route('berita.index') }}" },
                    { "@type": "ListItem", "position": 3, "name": {!! json_encode($berita->judul, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT) !!} }
                ]
            }
        ]
    }
    </script>
@endsection

@section('content')
    <section class="relative overflow-hidden bg-brand-950 py-16">
        <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(circle at 25% 25%, #d9a93c 0, transparent 35%), radial-gradient(circle at 75% 75%, #348362 0, transparent 40%);"></div>
        <div class="relative mx-auto max-w-4xl px-4 text-center sm:px-6 lg:px-8">
            <a href="{{ route('berita.index') }}" class="animate-fade-up inline-flex items-center gap-2 rounded-full border border-white/20 bg-white/10 px-4 py-1.5 text-sm font-semibold text-brand-100 transition hover:bg-white/20">
                <i class="fa-solid fa-arrow-left"></i> Kembali ke Berita &amp; Acara
            </a>
            <span class="animate-fade-up ms-2 inline-flex items-center rounded-full border border-gold-400/40 bg-gold-400/10 px-4 py-1.5 text-sm font-semibold text-gold-400" style="animation-delay: 120ms">
                {{ $berita->kategori }}
            </span>
            <h1 class="animate-fade-up mt-4 font-display text-3xl font-extrabold text-white sm:text-5xl" style="animation-delay: 240ms">{{ $berita->judul }}</h1>
        </div>
    </section>

    <section class="mx-auto max-w-4xl px-4 py-10 sm:px-6 lg:px-8">
        <article data-reveal class="overflow-hidden rounded-2xl border border-stone-200 bg-white shadow-sm">
            @if ($berita->gambar)
                <div class="relative h-72 sm:h-96">
                    <img src="{{ media_url($berita->gambar) }}" alt="{{ $berita->judul }}" class="h-full w-full object-cover" decoding="async">
                </div>
            @endif

            <div class="p-6 sm:p-10">
                <div class="flex flex-wrap items-center gap-x-6 gap-y-2 text-sm text-stone-500">
                    <span><i class="fa-solid fa-user-pen me-1.5 text-brand-700"></i>{{ $berita->penulis }}</span>
                    <span><i class="fa-regular fa-calendar me-1.5 text-brand-700"></i>Kegiatan: {{ $berita->tanggal_kegiatan?->format('d F Y') }}</span>
                </div>

                @if ($berita->ringkasan)
                    <p class="mt-6 rounded-xl bg-brand-50 px-4 py-3 text-sm font-medium text-brand-800">{{ $berita->ringkasan }}</p>
                @endif

                <div class="mt-8 space-y-4 text-[15px] leading-relaxed text-stone-700">
                    {!! $berita->konten_html !!}
                </div>

                <div class="mt-9 flex flex-wrap gap-3 border-t border-stone-200 pt-6">
                    <a href="{{ wa_url('Baca berita ' . $berita->judul . ' di Segoropuro: ' . route('berita.show', $berita)) }}" target="_blank" rel="noopener" class="btn-whatsapp !px-4 !py-2 !text-sm">
                        <i class="fa-brands fa-whatsapp"></i> Bagikan WhatsApp
                    </a>
                    <button type="button" x-data="{}" @click="navigator.clipboard.writeText(@js(route('berita.show', $berita))).then(() => alert('Tautan berita berhasil disalin!'))" class="btn-outline !px-4 !py-2 !text-sm">
                        <i class="fa-regular fa-copy"></i> Salin Tautan
                    </button>
                </div>
            </div>
        </article>

        @if ($beritaLain->isNotEmpty())
            <div class="mt-14">
                <div class="mb-6 flex items-center justify-between">
                    <h2 class="section-title !text-2xl">Berita Lainnya</h2>
                    <a href="{{ route('berita.index') }}" class="text-sm font-semibold text-brand-700 hover:underline">Lihat semua <i class="fa-solid fa-arrow-right ms-1"></i></a>
                </div>

                <div class="grid gap-6 md:grid-cols-3">
                    @foreach ($beritaLain as $lain)
                        <div data-reveal style="--reveal-delay: {{ $loop->index % 3 * 100 }}ms">
                        <a href="{{ route('berita.show', $lain) }}" class="group flex flex-col overflow-hidden rounded-2xl border border-stone-200 bg-white shadow-sm transition hover:-translate-y-1 hover:shadow-xl">
                            <div class="relative h-36 overflow-hidden">
                                @if ($lain->gambar)
                                    <img src="{{ media_url($lain->gambar) }}" alt="{{ $lain->judul }}" loading="lazy" class="h-full w-full object-cover transition duration-500 group-hover:scale-105">
                                @else
                                    <div class="flex h-full w-full items-center justify-center bg-brand-100">
                                        <i class="fa-solid fa-newspaper text-4xl text-brand-400/60"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="flex flex-1 flex-col p-4">
                                <p class="text-xs font-semibold text-gold-600">{{ $lain->kategori }}</p>
                                <h3 class="mt-1 font-display text-base font-bold leading-snug text-stone-900 line-clamp-2">{{ $lain->judul }}</h3>
                                <p class="mt-2 text-xs text-stone-400">{{ $lain->tanggal_kegiatan?->format('d M Y') }}</p>
                            </div>
                        </a>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </section>
@endsection
