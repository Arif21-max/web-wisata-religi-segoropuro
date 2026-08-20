@extends('layouts.app')

@section('title', 'Spot Wisata & Fasilitas - Makam Sayyid Arif Segoropuro')

@section('description', 'Spot wisata religi dan fasilitas penunjang di kawasan Makam Sayyid Arif Segoropuro, Pasuruan: makam, masjid, tempat wudhu, pendopo istirahat, dan area UMKM.')

@section('content')
    <section class="relative overflow-hidden bg-brand-950 py-16">
        <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(circle at 70% 20%, #d9a93c 0, transparent 35%), radial-gradient(circle at 20% 80%, #348362 0, transparent 40%);"></div>
        <div class="relative mx-auto max-w-7xl px-4 text-center sm:px-6 lg:px-8">
            <span class="animate-fade-up inline-flex items-center gap-2 rounded-full border border-gold-400/40 bg-gold-400/10 px-5 py-1.5 text-sm font-semibold text-gold-400">
                <i class="fa-solid fa-mosque"></i> Kawasan Peziarahan
            </span>
            <h1 class="animate-fade-up mt-4 font-display text-4xl font-extrabold text-white sm:text-5xl" style="animation-delay: 150ms">Spot Wisata &amp; Fasilitas</h1>
            <p class="animate-fade-up mx-auto mt-4 max-w-2xl text-brand-200" style="animation-delay: 300ms">Seluruh spot wisata religi dan fasilitas penunjang di kawasan Makam Sayyid Arif Segoropuro. Klik kartu untuk melihat galeri foto detail.</p>
        </div>
    </section>

    <section class="mx-auto max-w-7xl px-4 py-14 sm:px-6 lg:px-8">
        <div class="grid gap-7 sm:grid-cols-2 lg:grid-cols-3">
            @forelse ($spots as $spot)
                <div data-reveal style="--reveal-delay: {{ $loop->index % 3 * 100 }}ms">
                    <x-spot-card :spot="$spot"/>
                </div>
            @empty
                <div class="col-span-full rounded-2xl border border-dashed border-stone-300 bg-white p-14 text-center text-stone-400">
                    <i class="fa-solid fa-images mb-4 text-5xl"></i>
                    <p class="font-semibold text-stone-500">Data spot wisata belum tersedia.</p>
                </div>
            @endforelse
        </div>
    </section>
@endsection