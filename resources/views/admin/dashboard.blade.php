@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
    <div class="mb-6">
        <h2 class="text-xl font-bold text-stone-900">Selamat Datang, {{ auth()->user()->name }}!</h2>
        <p class="mt-1 text-sm text-stone-500">Ringkasan aktivitas dan statistik kawasan wisata religi Segoropuro.</p>
    </div>

    <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
        <x-admin.stat-card icon="fa-solid fa-eye" label="Total Pengunjung" :value="number_format($totalPengunjung)" color="text-brand-700 bg-brand-50"/>
        <x-admin.stat-card icon="fa-solid fa-fire" label="Pengunjung Hari Ini" :value="number_format($pengunjungHariIni)" color="text-amber-600 bg-amber-50"/>
        <x-admin.stat-card icon="fa-solid fa-book-open" label="Artikel Sejarah" :value="number_format($totalArtikel)" color="text-sky-600 bg-sky-50"/>
        <x-admin.stat-card icon="fa-solid fa-newspaper" label="Berita & Acara" :value="number_format($totalBerita)" color="text-violet-600 bg-violet-50"/>
        <x-admin.stat-card icon="fa-solid fa-mosque" label="Spot Wisata" :value="number_format($totalSpot)" color="text-emerald-600 bg-emerald-50"/>
        <x-admin.stat-card icon="fa-solid fa-box-open" label="Barang Belum Diambil" :value="number_format($barangBelum)" color="text-rose-600 bg-rose-50"/>
        <x-admin.stat-card icon="fa-solid fa-comment-dots" label="Ulasan Peziarah" :value="number_format($totalUlasan)" color="text-indigo-600 bg-indigo-50"/>
    </div>

    <div class="mt-8 grid gap-6 lg:grid-cols-3">
        <div class="rounded-2xl border border-stone-200 bg-white p-6 shadow-sm lg:col-span-2">
            <div class="mb-4 flex items-center justify-between">
                <div>
                    <h3 class="font-bold text-stone-900">Tren Pengunjung</h3>
                    <p class="text-xs text-stone-400">Jumlah kunjungan 30 hari terakhir</p>
                </div>
                <span class="inline-flex items-center gap-1.5 rounded-full bg-brand-50 px-3 py-1 text-xs font-semibold text-brand-700">
                    <i class="fa-solid fa-chart-line"></i> 30 Hari
                </span>
            </div>
            <div class="h-72">
                <canvas id="chart-pengunjung" data-json='@json($pengunjung30Hari)'></canvas>
            </div>
        </div>

        <div class="rounded-2xl border border-stone-200 bg-white p-6 shadow-sm">
            <div class="mb-4">
                <h3 class="font-bold text-stone-900">Status Barang Hilang</h3>
                <p class="text-xs text-stone-400">Ringkasan barang temuan</p>
            </div>
            <div class="flex h-72 items-center justify-center">
                <canvas id="chart-barang" data-json='@json($barangStatus)'></canvas>
            </div>
        </div>
    </div>

    <div class="mt-6 rounded-2xl border border-stone-200 bg-white p-6 shadow-sm">
        <div class="mb-4 flex items-center justify-between">
            <div>
                <h3 class="font-bold text-stone-900">Ulasan Peziarah</h3>
                <p class="text-xs text-stone-400">Buku tamu 14 hari terakhir</p>
            </div>
            <a href="{{ route('admin.buku-tamu.index') }}" class="text-sm font-semibold text-brand-700 hover:underline">Lihat <i class="fa-solid fa-arrow-right ms-1"></i></a>
        </div>
        <div class="h-60">
            <canvas id="chart-ulasan" data-json='@json($ulasan14Hari)'></canvas>
        </div>
    </div>

    <div class="mt-6 grid gap-6 lg:grid-cols-3">
        <div class="rounded-2xl border border-stone-200 bg-white p-6 shadow-sm lg:col-span-2">
            <div class="mb-4 flex items-center justify-between">
                <h3 class="font-bold text-stone-900">Aktivitas Terakhir (Artikel)</h3>
                <a href="{{ route('admin.artikel.index') }}" class="text-sm font-semibold text-brand-700 hover:underline">Kelola <i class="fa-solid fa-arrow-right ms-1"></i></a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead>
                        <tr class="border-b border-stone-200 text-xs uppercase tracking-wide text-stone-400">
                            <th class="pb-3">Judul</th>
                            <th class="pb-3">Dibuat</th>
                            <th class="pb-3 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-stone-100">
                        @forelse ($aktivitas as $item)
                            <tr>
                                <td class="py-3 font-medium text-stone-700">{{ $item->judul }}</td>
                                <td class="py-3 text-stone-500">{{ $item->created_at?->format('d M Y, H:i') }}</td>
                                <td class="py-3 text-right">
                                    <a href="{{ route('admin.artikel.edit', $item) }}" class="inline-flex items-center gap-1.5 rounded-lg bg-brand-50 px-3 py-1.5 text-xs font-semibold text-brand-700 transition hover:bg-brand-100">
                                        <i class="fa-solid fa-pen-to-square"></i> Edit
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="py-8 text-center text-stone-400">Belum ada artikel.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="space-y-4">
            <div class="rounded-2xl border border-stone-200 bg-white p-6 shadow-sm">
                <h3 class="mb-4 font-bold text-stone-900">Aksi Cepat</h3>
                <div class="grid grid-cols-2 gap-3">
                    <a href="{{ route('admin.artikel.create') }}" class="flex flex-col items-center gap-2 rounded-xl border border-stone-200 p-4 text-sm font-semibold text-stone-600 transition hover:border-brand-300 hover:bg-brand-50 hover:text-brand-800">
                        <i class="fa-solid fa-plus text-xl text-brand-700"></i>Artikel
                    </a>
                    <a href="{{ route('admin.berita.create') }}" class="flex flex-col items-center gap-2 rounded-xl border border-stone-200 p-4 text-sm font-semibold text-stone-600 transition hover:border-brand-300 hover:bg-brand-50 hover:text-brand-800">
                        <i class="fa-solid fa-plus text-xl text-brand-700"></i>Berita
                    </a>
                    <a href="{{ route('admin.spot-wisata.create') }}" class="flex flex-col items-center gap-2 rounded-xl border border-stone-200 p-4 text-sm font-semibold text-stone-600 transition hover:border-brand-300 hover:bg-brand-50 hover:text-brand-800">
                        <i class="fa-solid fa-plus text-xl text-brand-700"></i>Spot
                    </a>
                    <a href="{{ route('admin.barang-hilang.create') }}" class="flex flex-col items-center gap-2 rounded-xl border border-stone-200 p-4 text-sm font-semibold text-stone-600 transition hover:border-brand-300 hover:bg-brand-50 hover:text-brand-800">
                        <i class="fa-solid fa-plus text-xl text-brand-700"></i>Barang
                    </a>
                </div>
            </div>

            <div class="rounded-2xl border border-stone-200 bg-white p-6 shadow-sm">
                <h3 class="mb-3 font-bold text-stone-900">Informasi</h3>
                <ul class="space-y-2.5 text-sm text-stone-600">
                    <li class="flex items-center gap-2.5"><i class="fa-brands fa-whatsapp w-4 text-emerald-500"></i>{{ wa_number() ? '+' . wa_number() : 'Belum diatur' }}</li>
                    <li class="flex items-center gap-2.5"><i class="fa-solid fa-user-shield w-4 text-brand-700"></i>Login: {{ auth()->user()->username }}</li>
                    <li class="flex items-center gap-2.5"><i class="fa-solid fa-database w-4 text-sky-600"></i>{{ strtoupper(config('database.default')) }} database</li>
                </ul>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    @vite('resources/js/charts.js')
@endpush