@extends('layouts.app')

@section('title', 'Berita & Acara - Makam Sayyid Arif Segoropuro')

@section('description', 'Informasi kegiatan, agenda keagamaan, dan perkembangan terbaru kawasan wisata religi Makam Sayyid Arif Segoropuro, Pasuruan.')

@section('canonical', route('berita.index', request()->except('page')))

@if ($q !== '')
    @section('robots', 'noindex, follow')
@endif

@section('content')
    <section class="relative overflow-hidden bg-brand-950 py-16">
        <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(circle at 25% 25%, #d9a93c 0, transparent 35%), radial-gradient(circle at 75% 75%, #348362 0, transparent 40%);"></div>
        <div class="relative mx-auto max-w-7xl px-4 text-center sm:px-6 lg:px-8">
            <span class="animate-fade-up inline-flex items-center gap-2 rounded-full border border-gold-400/40 bg-gold-400/10 px-5 py-1.5 text-sm font-semibold text-gold-400">
                <i class="fa-solid fa-newspaper"></i> Kabar Terkini
            </span>
            <h1 class="animate-fade-up mt-4 font-display text-4xl font-extrabold text-white sm:text-5xl" style="animation-delay: 150ms">Berita &amp; Acara</h1>
            <p class="animate-fade-up mx-auto mt-4 max-w-2xl text-brand-200" style="animation-delay: 300ms">Informasi kegiatan, agenda keagamaan, dan perkembangan terbaru kawasan wisata religi Segoropuro.</p>

            <form action="{{ route('berita.index') }}" method="GET" class="animate-fade-up mx-auto mt-8 flex max-w-xl items-center gap-2 rounded-full border border-white/20 bg-white/10 p-1.5 backdrop-blur" style="animation-delay: 450ms">
                <i class="fa-solid fa-magnifying-glass ps-4 text-brand-200"></i>
                <input type="text" name="q" value="{{ $q }}" placeholder="Cari berita & acara..." class="w-full bg-transparent px-3 py-2 text-white placeholder-brand-300 focus:outline-none">
                <button type="submit" class="shrink-0 rounded-full bg-gold-500 px-6 py-2.5 font-semibold text-brand-950 transition hover:bg-gold-400">Cari</button>
            </form>
        </div>
    </section>

    <section class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
        <div class="mb-8 flex flex-wrap justify-center gap-2">
            <a href="{{ route('berita.index') }}" @class([
                'rounded-full px-5 py-2 text-sm font-semibold transition',
                'bg-brand-700 text-white' => $kategori === '',
                'bg-white text-stone-600 border border-stone-300 hover:bg-brand-50' => $kategori !== '',
            ])>
                Semua Berita
            </a>
            @foreach ($kategoriList as $kat)
                <a href="{{ route('berita.index', ['kategori' => $kat]) }}" @class([
                    'rounded-full px-5 py-2 text-sm font-semibold transition',
                    'bg-brand-700 text-white' => $kategori === $kat,
                    'bg-white text-stone-600 border border-stone-300 hover:bg-brand-50' => $kategori !== $kat,
                ])>
                    {{ $kat }}
                </a>
            @endforeach
        </div>

        @if ($q !== '')
            <p class="mb-6 text-center text-sm text-stone-500">
                Hasil untuk <strong class="text-brand-800">"{{ $q }}"</strong>
                <a href="{{ route('berita.index') }}" class="ms-2 text-red-500 hover:underline"><i class="fa-solid fa-xmark me-1"></i>Hapus</a>
            </p>
        @endif

        <div class="grid gap-7 md:grid-cols-2 lg:grid-cols-3">
            @forelse ($berita as $item)
                <div data-reveal style="--reveal-delay: {{ $loop->index % 3 * 100 }}ms">
                <article class="group flex flex-col overflow-hidden rounded-2xl border border-stone-200 bg-white shadow-sm transition hover:-translate-y-1 hover:shadow-xl">
                    <a href="{{ route('berita.show', $item) }}" class="relative block h-52 overflow-hidden">
                        @if ($item->gambar)
                            <img src="{{ media_url($item->gambar) }}" alt="{{ $item->judul }}" loading="lazy" class="h-full w-full object-cover transition duration-500 group-hover:scale-105">
                        @else
                            <div class="flex h-full w-full items-center justify-center bg-brand-100">
                                <i class="fa-solid fa-newspaper text-5xl text-brand-400/60"></i>
                            </div>
                        @endif
                        <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>
                        <span class="absolute left-4 top-4 rounded-full bg-gold-500 px-3 py-1 text-xs font-bold text-brand-950">{{ $item->kategori }}</span>
                        <div class="absolute bottom-4 left-4 flex items-center gap-2 rounded-full bg-white/90 px-3 py-1 text-xs font-semibold text-brand-800 backdrop-blur">
                            <i class="fa-regular fa-calendar"></i> {{ $item->tanggal_kegiatan?->format('d M Y') }}
                        </div>
                    </a>

                    <div class="flex flex-1 flex-col p-5">
                        <a href="{{ route('berita.show', $item) }}">
                            <h2 class="font-display text-lg font-bold leading-snug text-stone-900 line-clamp-2 transition group-hover:text-brand-700">{{ $item->judul }}</h2>
                        </a>
                        <p class="mt-2 flex-1 text-sm text-stone-500 line-clamp-3">{{ $item->ringkasan }}</p>
                        <div class="mt-4 flex items-center justify-between border-t border-stone-100 pt-4">
                            <span class="text-xs text-stone-400"><i class="fa-solid fa-user-pen me-1"></i>{{ $item->penulis }}</span>
                            <a href="{{ route('berita.show', $item) }}" class="btn-primary !px-4 !py-2 !text-sm">
                                <i class="fa-regular fa-eye"></i> Baca
                            </a>
                        </div>
                    </div>
                </article>
                </div>
            @empty
                <div class="col-span-full rounded-2xl border border-dashed border-stone-300 bg-white p-14 text-center text-stone-400">
                    <i class="fa-solid fa-newspaper mb-4 text-5xl"></i>
                    <p class="font-semibold text-stone-500">Berita tidak ditemukan</p>
                    <p class="mt-1 text-sm">Coba kata kunci atau kategori lain.</p>
                </div>
            @endforelse
        </div>

        <div data-reveal>
            <x-pagination :paginator="$berita"/>
        </div>
    </section>
@endsection