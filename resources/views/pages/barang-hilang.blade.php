@extends('layouts.app')

@section('title', 'Barang Hilang & Ditemukan - Makam Sayyid Arif Segoropuro')

@section('description', 'Layanan informasi barang hilang dan ditemukan di kawasan wisata religi Makam Sayyid Arif Segoropuro, Pasuruan. Hubungi pengelola bila menemukan atau kehilangan barang.')

@section('content')
    <section class="relative overflow-hidden bg-brand-950 py-16">
        <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(circle at 30% 70%, #d9a93c 0, transparent 35%), radial-gradient(circle at 70% 30%, #348362 0, transparent 40%);"></div>
        <div class="relative mx-auto max-w-7xl px-4 text-center sm:px-6 lg:px-8">
            <span class="animate-fade-up inline-flex items-center gap-2 rounded-full border border-gold-400/40 bg-gold-400/10 px-5 py-1.5 text-sm font-semibold text-gold-400">
                <i class="fa-solid fa-box-open"></i> Layanan Informasi
            </span>
            <h1 class="animate-fade-up mt-4 font-display text-4xl font-extrabold text-white sm:text-5xl" style="animation-delay: 150ms">Barang Hilang &amp; Ditemukan</h1>
            <p class="animate-fade-up mx-auto mt-4 max-w-2xl text-brand-200" style="animation-delay: 300ms">Laporan barang temuan di kawasan wisata religi Segoropuro. Jika Anda kehilangan barang, segera hubungi pengelola.</p>

            <form action="{{ route('barang-hilang.index') }}" method="GET" class="animate-fade-up mx-auto mt-8 flex max-w-xl items-center gap-2 rounded-full border border-white/20 bg-white/10 p-1.5 backdrop-blur" style="animation-delay: 450ms">
                <i class="fa-solid fa-magnifying-glass ps-4 text-brand-200"></i>
                <input type="text" name="q" value="{{ $q }}" placeholder="Cari nama barang, lokasi, atau deskripsi..." class="w-full bg-transparent px-3 py-2 text-white placeholder-brand-300 focus:outline-none">
                <button type="submit" class="shrink-0 rounded-full bg-gold-500 px-6 py-2.5 font-semibold text-brand-950 transition hover:bg-gold-400">Cari</button>
            </form>
        </div>
    </section>

    <section class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
        <div class="mb-8 flex flex-wrap items-center justify-center gap-2">
            @foreach ([['label' => 'Belum Diambil', 'value' => 'Belum Diambil'], ['label' => 'Sudah Diambil', 'value' => 'Sudah Diambil'], ['label' => 'Semua', 'value' => 'Semua']] as $pil)
                <a href="{{ route('barang-hilang.index', ['status' => $pil['value'], 'q' => $q]) }}" @class([
                    'inline-flex items-center gap-2 rounded-full px-5 py-2 text-sm font-semibold transition',
                    'bg-brand-700 text-white' => $status === $pil['value'],
                    'bg-white text-stone-600 border border-stone-300 hover:bg-brand-50' => $status !== $pil['value'],
                ])>
                    @if ($pil['value'] === 'Belum Diambil')
                        <span class="h-2 w-2 rounded-full bg-emerald-500"></span>
                    @elseif ($pil['value'] === 'Sudah Diambil')
                        <span class="h-2 w-2 rounded-full bg-stone-400"></span>
                    @else
                        <i class="fa-solid fa-list-ul text-xs"></i>
                    @endif
                    {{ $pil['label'] }}
                    @if ($pil['value'] === 'Belum Diambil')
                        <span class="rounded-full bg-white/30 px-2 text-xs">{{ $jumlahBelum }}</span>
                    @elseif ($pil['value'] === 'Sudah Diambil')
                        <span class="rounded-full bg-white/30 px-2 text-xs">{{ $jumlahSudah }}</span>
                    @endif
                </a>
            @endforeach
        </div>

        @if ($q !== '')
            <p class="mb-6 text-center text-sm text-stone-500">
                Hasil untuk <strong class="text-brand-800">"{{ $q }}"</strong>
                <a href="{{ route('barang-hilang.index', ['status' => $status]) }}" class="ms-2 text-red-500 hover:underline"><i class="fa-solid fa-xmark me-1"></i>Hapus</a>
            </p>
        @endif

        <div class="grid gap-7 sm:grid-cols-2 lg:grid-cols-3">
            @forelse ($items as $item)
                <div data-reveal style="--reveal-delay: {{ $loop->index % 3 * 100 }}ms">
                <article class="flex flex-col overflow-hidden rounded-2xl border border-stone-200 bg-white shadow-sm transition hover:-translate-y-1 hover:shadow-xl">
                    <div class="relative h-48 bg-stone-200">
                        @if ($item->foto && ! str_contains($item->foto, 'dompet.jpg') && ! str_contains($item->foto, 'default-item.jpg') && ! str_contains($item->foto, 'kacamata.jpg') && ! str_contains($item->foto, 'payung.jpg'))
                            <img src="{{ media_url($item->foto) }}" alt="{{ $item->nama_barang }}" loading="lazy" class="h-full w-full object-cover">
                        @else
                            <div class="flex h-full items-center justify-center text-stone-400">
                                <i class="fa-solid fa-box-open text-5xl"></i>
                            </div>
                        @endif
                        <span @class([
                            'absolute left-4 top-4 rounded-full px-3 py-1 text-xs font-bold',
                            'bg-emerald-500 text-white' => $item->status === 'Belum Diambil',
                            'bg-stone-500 text-white' => $item->status === 'Sudah Diambil',
                        ])>
                            {{ $item->status }}
                        </span>
                    </div>

                    <div class="flex flex-1 flex-col p-5">
                        <h2 class="font-display text-lg font-bold text-stone-900">{{ $item->nama_barang }}</h2>
                        <p class="mt-2 flex-1 text-sm leading-relaxed text-stone-500 line-clamp-3">{{ $item->deskripsi }}</p>

                        <ul class="mt-4 space-y-1.5 text-xs text-stone-500">
                            <li class="flex items-center gap-2"><i class="fa-solid fa-location-dot w-4 text-brand-700"></i>{{ $item->lokasi_ditemukan }}</li>
                            <li class="flex items-center gap-2"><i class="fa-regular fa-calendar w-4 text-brand-700"></i>{{ $item->tanggal_ditemukan?->format('d M Y') }}</li>
                            <li class="flex items-center gap-2"><i class="fa-solid fa-user-shield w-4 text-brand-700"></i>{{ $item->konten_kontak }}</li>
                        </ul>

                        <div class="mt-5">
                            @if ($item->status === 'Belum Diambil')
                                <a href="{{ wa_url('Halo, saya ingin mengklaim barang: ' . $item->nama_barang . ' (ditemukan di ' . $item->lokasi_ditemukan . '). Mohon informasi lebih lanjut.') }}" target="_blank" rel="noopener" class="btn-whatsapp w-full justify-center !px-4 !py-2.5 !text-sm">
                                    <i class="fa-brands fa-whatsapp"></i> Klaim via WhatsApp
                                </a>
                            @else
                                <button type="button" disabled class="flex w-full cursor-not-allowed items-center justify-center gap-2 rounded-full bg-stone-200 px-4 py-2.5 text-sm font-semibold text-stone-500">
                                    <i class="fa-solid fa-circle-check"></i> Barang Sudah Diambil
                                </button>
                            @endif
                        </div>
                    </div>
                </article>
                </div>
            @empty
                <div class="col-span-full rounded-2xl border border-dashed border-stone-300 bg-white p-14 text-center text-stone-400">
                    <i class="fa-solid fa-box-open mb-4 text-5xl"></i>
                    <p class="font-semibold text-stone-500">Tidak ada barang yang cocok</p>
                    <p class="mt-1 text-sm">Coba filter atau kata kunci lain.</p>
                </div>
            @endforelse
        </div>

        <div data-reveal>
            <x-pagination :paginator="$items"/>
        </div>
    </section>
@endsection