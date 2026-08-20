@extends('layouts.app')

@section('title', 'Wisata Religi - Makam Sayyid Arif Segoropuro')

@section('description', 'Wisata religi Makam Sayyid Arif Segoropuro di Desa Segoropuro, Rejoso, Pasuruan. Info ziarah, sejarah, spot wisata, lokasi, dan agenda kegiatan tersedia di portal resmi ini.')

@push('head')
    <link rel="preload" as="image" href="{{ media_url(kontak()?->gambar_hero ?: 'uploads/hero.jpg') }}?v=2">
@endpush

@section('jsonld')
    <script type="application/ld+json">
    {
        "@@context": "https://schema.org",
        "@graph": [
            {
                "@type": "WebSite",
                "@id": "{{ url('/') }}#website",
                "url": "{{ url('/') }}",
                "name": "{{ config('segoropuro.seo.site_name') }}",
                "description": "{{ $__env->yieldContent('description') }}",
                "inLanguage": "id-ID"
            },
            {
                "@type": "TouristAttraction",
                "@id": "{{ url('/') }}#attraction",
                "name": "{{ config('segoropuro.seo.site_name') }}",
                "url": "{{ url('/') }}",
                "image": "{{ media_url(kontak()?->gambar_hero ?: 'uploads/hero.jpg') }}",
                "description": "Makam Sayyid Arif Segoropuro, wisata religi dan ziarah di Desa Segoropuro, Kecamatan Rejoso, Kabupaten Pasuruan, Jawa Timur.",
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
                "publicAccess": true,
                "sameAs": []
            }
        ]
    }
    </script>
@endsection

@section('content')
    {{-- Hero --}}
    <section class="relative flex min-h-[88vh] items-center justify-center overflow-hidden">
        <img src="{{ media_url(kontak()?->gambar_hero ?: 'uploads/hero.jpg') }}?v=2" alt="Kawasan Wisata Religi Makam Sayyid Arif Segoropuro, Pasuruan" class="animate-slow-zoom absolute inset-0 h-full w-full object-cover" loading="eager" fetchpriority="high" decoding="async">
        <div class="absolute inset-0 bg-gradient-to-b from-brand-950/85 via-brand-950/60 to-brand-950/85"></div>

        {{-- Ornamen cahaya melayang --}}
        <div class="animate-float-orb pointer-events-none absolute -left-24 top-1/4 h-72 w-72 rounded-full bg-gold-400/20 blur-3xl"></div>
        <div class="animate-float-orb pointer-events-none absolute -right-28 bottom-1/4 h-80 w-80 rounded-full bg-brand-400/20 blur-3xl" style="animation-delay: 2.5s"></div>

        <div class="relative z-10 mx-auto max-w-4xl px-4 py-24 text-center sm:px-6">
            <span class="animate-fade-up mb-6 inline-flex items-center gap-2 rounded-full border border-gold-400/40 bg-gold-400/10 px-5 py-1.5 text-sm font-semibold tracking-wide text-gold-400 backdrop-blur">
                <i class="fa-solid fa-star-and-crescent"></i> Wisata Religi &amp; Ziarah
            </span>
            <h1 class="animate-fade-up font-display text-4xl font-extrabold leading-tight text-white hero-text-shadow sm:text-5xl lg:text-6xl" style="animation-delay: 150ms">
                Makam Sayyid Arif Segoropuro
            </h1>
            <p class="animate-fade-up mx-auto mt-6 max-w-2xl text-lg leading-relaxed text-brand-100 hero-text-shadow" style="animation-delay: 300ms">
                Menelusuri jejak sejarah dan spiritual, merajut doa dalam kekhusyukan di Desa Segoropuro, Pasuruan.
            </p>
            <div class="animate-fade-up mt-9 flex flex-wrap items-center justify-center gap-4" style="animation-delay: 450ms">
                <a href="{{ route('sejarah.index') }}" class="btn-primary !bg-gold-500 hover:!bg-gold-600">
                    <i class="fa-solid fa-book-open"></i> Baca Sejarah
                </a>
                <a href="{{ wa_url() }}" target="_blank" rel="noopener" class="btn-whatsapp">
                    <i class="fa-brands fa-whatsapp"></i> Hubungi WhatsApp
                </a>
            </div>
        </div>

        <a href="#sejarah-singkat" class="absolute bottom-8 left-1/2 z-10 -translate-x-1/2 text-3xl text-white/80 transition hover:text-white" aria-label="Gulir ke bawah">
            <span class="animate-fade-up block" style="animation-delay: 700ms">
                <i class="fa-solid fa-circle-chevron-down block animate-bounce"></i>
            </span>
        </a>
    </section>

    {{-- Sejarah Singkat --}}
    <section id="sejarah-singkat" class="mx-auto max-w-7xl scroll-mt-24 px-4 py-20 sm:px-6 lg:px-8">
        <div class="grid items-center gap-12 lg:grid-cols-2">
            <div data-reveal="left">
                <span class="inline-flex items-center gap-2 rounded-full bg-brand-50 px-4 py-1.5 text-xs font-bold uppercase tracking-wider text-brand-700">
                    <i class="fa-solid fa-landmark-dome"></i> Literasi Tokoh Religi
                </span>
                <h2 class="section-title mt-4">Sejarah Singkat Sayyid Arif Segoropuro</h2>
                <p class="mt-5 leading-relaxed text-stone-600">
                    Sayyid Arif adalah salah satu tokoh penyebar agama Islam terkemuka yang memiliki jejak perjuangan spiritual mendalam di wilayah Desa Segoropuro, Kecamatan Rejoso, Kabupaten Pasuruan. Beliau mengabdikan hidupnya untuk membimbing masyarakat dalam kedamaian dan ketakwaan.
                </p>
                <p class="mt-3 leading-relaxed text-stone-600">
                    Jejak peninggalan dan nilai-nilai luhur perjuangan beliau hingga saat ini terus dijaga dan dihormati oleh generasi penerus serta peziarah dari berbagai daerah di Nusantara.
                </p>
                <div class="mt-7 flex flex-wrap gap-3">
                    <a href="{{ route('sejarah.index') }}" class="btn-primary">
                        <i class="fa-solid fa-book-open-reader"></i> Baca Sejarah Selengkapnya
                    </a>
                    @if ($artikelTerbaru->isNotEmpty())
                        <a href="{{ route('sejarah.show', $artikelTerbaru->first()) }}" class="btn-outline">
                            <i class="fa-regular fa-bookmark"></i> Baca Artikel Terbaru
                        </a>
                    @endif
                </div>
            </div>
            <div data-reveal="right" class="relative">
                <div class="absolute -inset-4 -z-10 rounded-3xl bg-gradient-to-br from-brand-100 to-gold-400/30"></div>
                <img src="{{ media_url(kontak()?->gambar_sejarah ?: 'uploads/sejarah.jpg') }}" alt="Sejarah Sayyid Arif Segoropuro" class="h-[420px] w-full rounded-3xl object-cover shadow-2xl">
            </div>
        </div>
    </section>

    {{-- Spot Wisata --}}
    <section class="bg-white py-20">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="text-center" data-reveal>
                <span class="inline-flex items-center gap-2 rounded-full bg-brand-50 px-4 py-1.5 text-xs font-bold uppercase tracking-wider text-brand-700">
                    <i class="fa-solid fa-mosque"></i> Kawasan Peziarahan
                </span>
                <h2 class="section-title mt-4">Spot Wisata &amp; Fasilitas</h2>
                <p class="mx-auto mt-3 max-w-2xl text-stone-500">
                    Klik kartu untuk melihat detail foto dan informasi setiap spot di kawasan Makam Sayyid Arif Segoropuro.
                </p>
            </div>

            <div class="mt-10 grid gap-7 sm:grid-cols-2 lg:grid-cols-3">
                @forelse ($spots as $spot)
                    <div data-reveal style="--reveal-delay: {{ $loop->index % 3 * 100 }}ms">
                        <x-spot-card :spot="$spot"/>
                    </div>
                @empty
                    <div class="col-span-full rounded-2xl border border-dashed border-stone-300 p-12 text-center text-stone-400">
                        <i class="fa-solid fa-images mb-3 text-4xl"></i>
                        <p>Data spot wisata belum tersedia.</p>
                    </div>
                @endforelse
            </div>

            <div class="mt-10 text-center">
                <a href="{{ route('spot-wisata.index') }}" class="btn-outline">
                    <i class="fa-solid fa-layer-group"></i> Lihat Semua Spot
                </a>
            </div>
        </div>
    </section>

    {{-- Ulasan Peziarah --}}
    <section class="overflow-hidden py-20">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="text-center" data-reveal>
                <span class="inline-flex items-center gap-2 rounded-full bg-gold-400/15 px-4 py-1.5 text-xs font-bold uppercase tracking-wider text-gold-600">
                    <i class="fa-solid fa-quote-left"></i> Testimoni
                </span>
                <h2 class="section-title mt-4">Ulasan Peziarah</h2>
            </div>
        </div>

        <div class="relative mt-10" data-reveal>
            <div class="pointer-events-none absolute inset-y-0 left-0 z-10 w-24 bg-gradient-to-r from-stone-50 to-transparent"></div>
            <div class="pointer-events-none absolute inset-y-0 right-0 z-10 w-24 bg-gradient-to-l from-stone-50 to-transparent"></div>

            <div class="animate-marquee flex w-max gap-6 pe-6">
                @forelse ($ulasan as $item)
                    <x-ulasan-card :ulasan="$item"/>
                @empty
                    <div class="w-80 rounded-2xl border border-dashed border-stone-300 p-6 text-stone-400">Belum ada ulasan.</div>
                @endforelse
                @if ($ulasan->isNotEmpty())
                    {{-- Duplikasi untuk loop mulus --}}
                    @foreach ($ulasan as $item)
                        <x-ulasan-card :ulasan="$item"/>
                    @endforeach
                @endif
            </div>
        </div>

        <div class="mt-8 text-center">
            <a href="{{ route('buku-tamu.index') }}" class="btn-primary">
                <i class="fa-solid fa-pen-to-square"></i> Tulis Pesan &amp; Doa
            </a>
        </div>
    </section>

    {{-- Lokasi & Transportasi --}}
    <section class="bg-white py-20">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="grid items-stretch gap-10 lg:grid-cols-2">
                <div data-reveal="left" class="overflow-hidden rounded-3xl border border-stone-200 shadow-lg">
                    @if (sanitize_maps_embed(kontak()?->google_maps_embed))
                        {!! sanitize_maps_embed(kontak()?->google_maps_embed) !!}
                    @endif
                </div>
                <div data-reveal="right" class="flex flex-col justify-center">
                    <span class="inline-flex items-center gap-2 rounded-full bg-brand-50 px-4 py-1.5 text-xs font-bold uppercase tracking-wider text-brand-700">
                        <i class="fa-solid fa-map-location-dot"></i> Panduan Akses
                    </span>
                    <h2 class="section-title mt-4">Lokasi &amp; Akses Transportasi</h2>
                    <p class="mt-4 leading-relaxed text-stone-600">
                        Makam Sayyid Arif Segoropuro berlokasi di <strong>{{ kontak()?->alamat ?? 'Desa Segoropuro, Kecamatan Rejoso, Kabupaten Pasuruan, Jawa Timur' }}</strong>. Kawasan mudah diakses dari jalan provinsi Pasuruan–Rejoso.
                    </p>
                    <ul class="mt-6 space-y-4">
                        <li class="flex items-start gap-4" data-reveal style="--reveal-delay: 0ms">
                            <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-brand-50 text-brand-700"><i class="fa-solid fa-car"></i></span>
                            <div>
                                <h3 class="font-semibold text-stone-900">Kendaraan Pribadi &amp; Rombongan Bus</h3>
                                <p class="text-sm text-stone-500">Area parkir luas tersedia khusus di depan kompleks untuk kendaraan roda dua maupun bus rombongan ziarah.</p>
                            </div>
                        </li>
                        <li class="flex items-start gap-4" data-reveal style="--reveal-delay: 120ms">
                            <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-gold-400/20 text-gold-600"><i class="fa-solid fa-train-subway"></i></span>
                            <div>
                                <h3 class="font-semibold text-stone-900">Transportasi Umum</h3>
                                <p class="text-sm text-stone-500">Akses dari terminal Pasuruan dengan angkutan jurusan Rejoso/Segoropuro, turun di depan gapura desa.</p>
                            </div>
                        </li>
                        <li class="flex items-start gap-4" data-reveal style="--reveal-delay: 240ms">
                            <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600"><i class="fa-solid fa-utensils"></i></span>
                            <div>
                                <h3 class="font-semibold text-stone-900">Fasilitas Pendukung</h3>
                                <p class="text-sm text-stone-500">Masjid, tempat wudhu, pendopo istirahat, serta area souvenir &amp; UMKM warga desa.</p>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
@endsection