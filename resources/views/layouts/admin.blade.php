<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin') - Segoropuro</title>

    <link rel="icon" type="image/png" href="{{ asset('img/logo.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('img/logo.png') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&family=Amiri:ital,wght@0,400;0,700;1,400&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-stone-100 font-sans" x-data="{ sidebarOpen: false }">

    <div class="flex min-h-screen">
        {{-- Sidebar --}}
        <aside class="fixed inset-y-0 left-0 z-40 w-64 -translate-x-full bg-brand-950 text-brand-100 transition-transform lg:translate-x-0"
               :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'">
            <div class="flex h-full flex-col">
                <div class="flex items-center gap-3 border-b border-brand-900 px-5 py-5">
                    <img src="{{ asset('img/logo.png') }}" alt="Logo" class="h-10 w-10 rounded-full object-cover ring-2 ring-brand-800">
                    <div class="leading-tight">
                        <p class="font-display font-bold text-white">Segoropuro</p>
                        <p class="text-[11px] text-brand-300">Panel Pengelola</p>
                    </div>
                </div>

                <nav class="flex-1 space-y-1 overflow-y-auto px-3 py-4 text-sm">
                    <x-admin.side-link href="{{ route('admin.dashboard') }}" :active="request()->routeIs('admin.dashboard')" icon="fa-solid fa-chart-pie">Dashboard</x-admin.side-link>
                    <x-admin.side-link href="{{ route('admin.artikel.index') }}" :active="request()->routeIs('admin.artikel.*')" icon="fa-solid fa-book-open">Literasi Sejarah</x-admin.side-link>
                    <x-admin.side-link href="{{ route('admin.berita.index') }}" :active="request()->routeIs('admin.berita.*')" icon="fa-solid fa-newspaper">Berita &amp; Acara</x-admin.side-link>
                    <x-admin.side-link href="{{ route('admin.spot-wisata.index') }}" :active="request()->routeIs('admin.spot-wisata.*', 'admin.spot.*')" icon="fa-solid fa-mosque">Spot Wisata &amp; Galeri</x-admin.side-link>
                    <x-admin.side-link href="{{ route('admin.buku-tamu.index') }}" :active="request()->routeIs('admin.buku-tamu.*')" icon="fa-solid fa-book">Buku Tamu</x-admin.side-link>
                    <x-admin.side-link href="{{ route('admin.barang-hilang.index') }}" :active="request()->routeIs('admin.barang-hilang.*')" icon="fa-solid fa-box-open">Barang Hilang</x-admin.side-link>
                    <x-admin.side-link href="{{ route('admin.kontak.edit') }}" :active="request()->routeIs('admin.kontak.*')" icon="fa-solid fa-phone">Kontak</x-admin.side-link>
                </nav>

                <div class="border-t border-brand-900 p-4">
                    <div class="flex items-center gap-3">
                        <span class="flex h-9 w-9 items-center justify-center rounded-full bg-brand-700 font-bold text-white">{{ strtoupper(mb_substr(auth()->user()->name ?? 'A', 0, 1)) }}</span>
                        <div class="min-w-0 flex-1 leading-tight">
                            <p class="truncate text-sm font-semibold text-white">{{ auth()->user()->name ?? 'Admin' }}</p>
                            <p class="truncate text-[11px] text-brand-300">{{ auth()->user()->username }}</p>
                        </div>
                    </div>
                    <form action="{{ route('admin.logout') }}" method="POST" class="mt-3">
                        @csrf
                        <button type="submit" class="flex w-full items-center justify-center gap-2 rounded-lg bg-red-600/80 px-3 py-2 text-sm font-semibold text-white transition hover:bg-red-600">
                            <i class="fa-solid fa-right-from-bracket"></i> Keluar
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        {{-- Overlay mobile --}}
        <div class="fixed inset-0 z-30 bg-black/50 lg:hidden" x-show="sidebarOpen" x-cloak @click="sidebarOpen = false"></div>

        {{-- Konten --}}
        <div class="flex min-h-screen w-full flex-col lg:pl-64">
            <header class="sticky top-0 z-20 flex items-center justify-between border-b border-stone-200 bg-white px-4 py-3 sm:px-6">
                <div class="flex items-center gap-3">
                    <button type="button" class="rounded-lg border border-stone-300 p-2 text-stone-600 lg:hidden" @click="sidebarOpen = !sidebarOpen" aria-label="Menu">
                        <i class="fa-solid fa-bars"></i>
                    </button>
                    <h1 class="font-display text-lg font-bold text-stone-900">@yield('title', 'Dashboard')</h1>
                </div>
                <div class="flex items-center gap-3 sm:gap-4">
                    <p dir="rtl" lang="ar" title="Bismillahirrahmanirrahim" class="font-arabic hidden select-none text-2xl leading-none text-brand-700/90 transition hover:text-brand-800 md:block">
                        بِسْمِ اللَّهِ الرَّحْمَٰنِ الرَّحِيمِ
                    </p>
                    <a href="{{ route('home') }}" target="_blank" class="flex items-center gap-2 rounded-full border border-brand-200 bg-brand-50 px-4 py-2 text-sm font-semibold text-brand-800 transition hover:bg-brand-100">
                        <i class="fa-solid fa-globe"></i><span class="hidden sm:inline">Lihat Situs</span>
                    </a>
                </div>
            </header>

            <main class="flex-1 p-4 sm:p-6">
                @if (session('success'))
                    <div class="mb-5 flex items-center gap-3 rounded-xl border border-emerald-300 bg-emerald-50 px-5 py-3 text-sm font-medium text-emerald-800" role="alert">
                        <i class="fa-solid fa-circle-check"></i>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif

                @if (session('error'))
                    <div class="mb-5 flex items-center gap-3 rounded-xl border border-red-300 bg-red-50 px-5 py-3 text-sm font-medium text-red-800" role="alert">
                        <i class="fa-solid fa-triangle-exclamation"></i>
                        <span>{{ session('error') }}</span>
                    </div>
                @endif

                @yield('content')
            </main>

            <footer class="border-t border-stone-200 bg-white px-6 py-4 text-xs text-stone-400">
                &copy; {{ date('Y') }} Pengelola Makam Sayyid Arif Segoropuro.
            </footer>
        </div>
    </div>

    @stack('scripts')
</body>
</html>