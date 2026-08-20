@props([])
<header
    x-data="{ scrolled: false }"
    @scroll.window="scrolled = window.scrollY > 12"
    :class="scrolled && 'shadow-lg shadow-stone-900/5'"
    class="sticky top-0 z-50 border-b border-stone-200/70 bg-white/85 backdrop-blur-lg transition-shadow duration-300"
>
    <nav class="mx-auto flex h-18 max-w-7xl items-center justify-between gap-4 px-4 py-3 sm:px-6 lg:px-8">
        <a href="{{ route('home') }}" class="flex items-center gap-3">
            <img src="{{ asset('img/logo.png') }}" alt="Logo Yayasan Sayyid Arif Segoropuro" class="h-11 w-11 rounded-full object-cover ring-2 ring-brand-100">
            <div class="leading-tight">
                <span class="block font-display text-lg font-bold text-brand-900">Segoropuro</span>
                <span class="hidden text-[11px] font-medium tracking-wide text-stone-500 sm:block">Wisata Religi & Ziarah</span>
            </div>
        </a>

        <div class="hidden items-center gap-1 lg:flex">
            <x-layouts.nav-link href="{{ route('home') }}" :active="request()->routeIs('home')"><i class="fa-solid fa-house me-1.5"></i>Beranda</x-layouts.nav-link>
            <x-layouts.nav-link href="{{ route('sejarah.index') }}" :active="request()->routeIs('sejarah.*')"><i class="fa-solid fa-book-open me-1.5"></i>Sejarah</x-layouts.nav-link>
            <x-layouts.nav-link href="{{ route('spot-wisata.index') }}" :active="request()->routeIs('spot-wisata.*')"><i class="fa-solid fa-mosque me-1.5"></i>Spot Wisata</x-layouts.nav-link>
            <x-layouts.nav-link href="{{ route('berita.index') }}" :active="request()->routeIs('berita.*')"><i class="fa-solid fa-newspaper me-1.5"></i>Berita</x-layouts.nav-link>
            <x-layouts.nav-link href="{{ route('buku-tamu.index') }}" :active="request()->routeIs('buku-tamu.*')"><i class="fa-solid fa-book me-1.5"></i>Buku Tamu</x-layouts.nav-link>
            <x-layouts.nav-link href="{{ route('barang-hilang.index') }}" :active="request()->routeIs('barang-hilang.*')"><i class="fa-solid fa-box-open me-1.5"></i>Barang Hilang</x-layouts.nav-link>
        </div>

        <div class="flex items-center gap-2">
            <a href="{{ wa_url() }}" target="_blank" rel="noopener" class="btn-whatsapp !px-4 !py-2 !text-sm">
                <i class="fa-brands fa-whatsapp"></i><span class="hidden sm:inline">WhatsApp</span>
            </a>
            <button type="button" class="rounded-lg border border-stone-300 p-2 text-stone-700 lg:hidden" @click="mobileOpen = !mobileOpen" aria-label="Menu">
                <i class="fa-solid fa-bars text-lg" x-show="!mobileOpen"></i>
                <i class="fa-solid fa-xmark text-lg" x-show="mobileOpen" x-cloak></i>
            </button>
        </div>
    </nav>

    <div class="border-t border-stone-200 bg-white lg:hidden" x-show="mobileOpen" x-cloak @click.outside="mobileOpen = false">
        <div class="mx-auto flex max-w-7xl flex-col px-4 py-3">
            <x-layouts.nav-link href="{{ route('home') }}" :active="request()->routeIs('home')"><i class="fa-solid fa-house me-2 w-5 text-center"></i>Beranda</x-layouts.nav-link>
            <x-layouts.nav-link href="{{ route('sejarah.index') }}" :active="request()->routeIs('sejarah.*')"><i class="fa-solid fa-book-open me-2 w-5 text-center"></i>Sejarah</x-layouts.nav-link>
            <x-layouts.nav-link href="{{ route('spot-wisata.index') }}" :active="request()->routeIs('spot-wisata.*')"><i class="fa-solid fa-mosque me-2 w-5 text-center"></i>Spot Wisata</x-layouts.nav-link>
            <x-layouts.nav-link href="{{ route('berita.index') }}" :active="request()->routeIs('berita.*')"><i class="fa-solid fa-newspaper me-2 w-5 text-center"></i>Berita</x-layouts.nav-link>
            <x-layouts.nav-link href="{{ route('buku-tamu.index') }}" :active="request()->routeIs('buku-tamu.*')"><i class="fa-solid fa-book me-2 w-5 text-center"></i>Buku Tamu</x-layouts.nav-link>
            <x-layouts.nav-link href="{{ route('barang-hilang.index') }}" :active="request()->routeIs('barang-hilang.*')"><i class="fa-solid fa-box-open me-2 w-5 text-center"></i>Barang Hilang</x-layouts.nav-link>
        </div>
    </div>
</header>
