@extends('layouts.app')

@section('title', 'Buku Tamu & Doa - Makam Sayyid Arif Segoropuro')

@section('description', 'Tulis pesan, doa, dan kesan peziarah untuk kawasan wisata religi Makam Sayyid Arif Segoropuro, Pasuruan.')

@section('content')
    <section class="relative overflow-hidden bg-brand-950 py-16">
        <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(circle at 80% 20%, #d9a93c 0, transparent 35%), radial-gradient(circle at 20% 80%, #348362 0, transparent 40%);"></div>
        <div class="relative mx-auto max-w-7xl px-4 text-center sm:px-6 lg:px-8">
            <span class="animate-fade-up inline-flex items-center gap-2 rounded-full border border-gold-400/40 bg-gold-400/10 px-5 py-1.5 text-sm font-semibold text-gold-400">
                <i class="fa-solid fa-book"></i> Silaturahmi
            </span>
            <h1 class="animate-fade-up mt-4 font-display text-4xl font-extrabold text-white sm:text-5xl" style="animation-delay: 150ms">Buku Tamu &amp; Doa</h1>
            <p class="animate-fade-up mx-auto mt-4 max-w-2xl text-brand-200" style="animation-delay: 300ms">Tinggalkan jejak, doa, dan harapan terbaik Anda untuk kawasan Wisata Religi Makam Sayyid Arif Segoropuro.</p>
        </div>
    </section>

    <section class="mx-auto max-w-7xl px-4 py-14 sm:px-6 lg:px-8">
        <div class="grid gap-10 lg:grid-cols-5">
            {{-- Form --}}
            <div class="lg:col-span-2">
                <div data-reveal="left" class="sticky top-28 rounded-3xl border border-stone-200 bg-white p-7 shadow-lg">
                    <h2 class="font-display text-2xl font-bold text-stone-900">Tulis Pesan &amp; Doa</h2>
                    <p class="mt-2 text-sm text-stone-500">Setiap doa yang terkirim adalah keberkahan bagi peziarah yang datang.</p>

                    @if ($errors->any())
                        <div class="mt-4 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                            <ul class="list-inside list-disc space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('buku-tamu.store') }}" method="POST" class="mt-6 space-y-4">
                        @csrf
                        <div>
                            <label for="nama" class="mb-1.5 block text-sm font-semibold text-stone-700">Nama Lengkap</label>
                            <input type="text" id="nama" name="nama" value="{{ old('nama') }}" required maxlength="100" placeholder="cth: H. Ahmad Ridwan" class="input-field">
                        </div>
                        <div>
                            <label for="asal_kota" class="mb-1.5 block text-sm font-semibold text-stone-700">Asal Kota</label>
                            <input type="text" id="asal_kota" name="asal_kota" value="{{ old('asal_kota') }}" required maxlength="100" placeholder="cth: Surabaya" class="input-field">
                        </div>
                        <div>
                            <label for="pesan_doa" class="mb-1.5 block text-sm font-semibold text-stone-700">Pesan / Doa</label>
                            <textarea id="pesan_doa" name="pesan_doa" rows="5" required minlength="10" maxlength="1000" placeholder="Alhamdulillah, tempatnya sangat tenang dan khusyuk..." class="input-field resize-none">{{ old('pesan_doa') }}</textarea>
                        </div>
                        <button type="submit" class="btn-primary w-full justify-center">
                            <i class="fa-solid fa-paper-plane"></i> Kirim Pesan &amp; Doa
                        </button>
                    </form>
                </div>
            </div>

            {{-- Daftar Ulasan --}}
            <div data-reveal="right" class="lg:col-span-3">
                <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                    <h2 class="font-display text-2xl font-bold text-stone-900">Semua Ulasan</h2>
                    <form action="{{ route('buku-tamu.index') }}" method="GET" class="flex max-w-sm items-center gap-2">
                        <input type="text" name="q" value="{{ $q }}" placeholder="Cari nama, kota, atau isi..." class="input-field">
                        <button type="submit" class="shrink-0 rounded-xl bg-brand-700 px-4 py-2.5 text-white transition hover:bg-brand-800">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </button>
                    </form>
                </div>

                @if ($q !== '')
                    <p class="mb-5 text-sm text-stone-500">
                        Hasil untuk <strong class="text-brand-800">"{{ $q }}"</strong>
                        <a href="{{ route('buku-tamu.index') }}" class="ms-2 text-red-500 hover:underline"><i class="fa-solid fa-xmark me-1"></i>Hapus</a>
                    </p>
                @endif

                <div class="grid gap-5 sm:grid-cols-2">
                    @forelse ($ulasanSemua as $item)
                        <div data-reveal style="--reveal-delay: {{ $loop->index % 2 * 120 }}ms">
                        <div class="rounded-2xl border border-stone-200 bg-white p-5 shadow-sm transition hover:shadow-md">
                            <div class="flex items-center gap-3">
                                <span class="flex h-10 w-10 items-center justify-center rounded-full bg-brand-700 text-sm font-bold text-white">{{ $item->getInisial() }}</span>
                                <div>
                                    <p class="font-semibold text-stone-900">{{ $item->nama }}</p>
                                    <p class="flex items-center gap-1 text-xs text-stone-400"><i class="fa-solid fa-location-dot"></i>{{ $item->asal_kota }}</p>
                                </div>
                            </div>
                            <p class="mt-3 text-sm leading-relaxed text-stone-600">"{{ $item->pesan_doa }}"</p>
                            <p class="mt-3 text-xs text-stone-400"><i class="fa-regular fa-clock me-1"></i>{{ $item->created_at?->format('d M Y, H:i') }}</p>
                        </div>
                        </div>
                    @empty
                        <div class="col-span-full rounded-2xl border border-dashed border-stone-300 p-12 text-center text-stone-400">
                            <i class="fa-solid fa-comment-slash mb-3 text-4xl"></i>
                            <p>Belum ada ulasan yang cocok.</p>
                        </div>
                    @endforelse
                </div>

                <div data-reveal>
                    <x-pagination :paginator="$ulasanSemua"/>
                </div>
            </div>
        </div>
    </section>
@endsection