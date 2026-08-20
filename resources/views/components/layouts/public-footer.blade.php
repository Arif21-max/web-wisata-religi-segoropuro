@props([])
<footer class="mt-20 bg-brand-950 text-brand-100">
    <div class="mx-auto grid max-w-7xl gap-10 px-4 py-14 sm:px-6 md:grid-cols-3 lg:px-8">
        <div>
            <div class="mb-4 flex items-center gap-3">
                <img src="{{ asset('img/logo.png') }}" alt="Logo" class="h-12 w-12 rounded-full object-cover ring-2 ring-brand-800">
                <div>
                    <h3 class="font-display text-lg font-bold text-white">Makam Sayyid Arif</h3>
                    <p class="text-xs text-brand-300">Desa Segoropuro, Kec. Rejoso, Kab. Pasuruan</p>
                </div>
            </div>
            <p class="text-sm leading-relaxed text-brand-200">
                Portal informasi wisata religi, literasi sejarah, berita kegiatan, serta layanan informasi barang hilang kawasan peziarahan Makam Sayyid Arif Segoropuro.
            </p>
        </div>

        <div>
            <h4 class="mb-4 font-semibold text-white">Navigasi Cepat</h4>
            <ul class="space-y-2 text-sm">
                <li><a href="{{ route('home') }}" class="transition hover:text-gold-400"><i class="fa-solid fa-angles-right me-2 text-xs"></i>Beranda</a></li>
                <li><a href="{{ route('sejarah.index') }}" class="transition hover:text-gold-400"><i class="fa-solid fa-angles-right me-2 text-xs"></i>Literasi Sejarah</a></li>
                <li><a href="{{ route('spot-wisata.index') }}" class="transition hover:text-gold-400"><i class="fa-solid fa-angles-right me-2 text-xs"></i>Spot Wisata & Fasilitas</a></li>
                <li><a href="{{ route('berita.index') }}" class="transition hover:text-gold-400"><i class="fa-solid fa-angles-right me-2 text-xs"></i>Berita & Acara</a></li>
                <li><a href="{{ route('buku-tamu.index') }}" class="transition hover:text-gold-400"><i class="fa-solid fa-angles-right me-2 text-xs"></i>Buku Tamu & Doa</a></li>
                <li><a href="{{ route('barang-hilang.index') }}" class="transition hover:text-gold-400"><i class="fa-solid fa-angles-right me-2 text-xs"></i>Barang Hilang</a></li>
            </ul>
        </div>

        <div>
            <h4 class="mb-4 font-semibold text-white">Hubungi Kami</h4>
            <ul class="space-y-3 text-sm">
                <li class="flex items-start gap-3"><i class="fa-solid fa-location-dot mt-1 text-gold-400"></i><span>{{ kontak()?->alamat ?? 'Desa Segoropuro, Kecamatan Rejoso, Kabupaten Pasuruan, Jawa Timur' }}</span></li>
                @if (wa_number())
                    <li class="flex items-center gap-3"><i class="fa-solid fa-phone text-gold-400"></i><span>{{ implode(' ', str_split(ltrim(wa_number(), '0'), 3)) }}</span></li>
                @endif
                <li>
                    <a href="{{ wa_url() }}" target="_blank" rel="noopener" class="mt-2 inline-flex items-center gap-2 rounded-full bg-emerald-600 px-5 py-2 font-semibold text-white transition hover:bg-emerald-500">
                        <i class="fa-brands fa-whatsapp"></i> Chat WhatsApp
                    </a>
                </li>
            </ul>
        </div>
    </div>

    <div class="border-t border-brand-900 py-5">
        <div class="mx-auto flex max-w-7xl flex-col items-center justify-between gap-3 px-4 text-xs text-brand-300 sm:flex-row sm:px-6 lg:px-8">
            <p>&copy; {{ date('Y') }} Desa Segoropuro. Hak cipta dilindungi.</p>
            <p class="flex items-center gap-3">
                <span>Dikembangkan bersama KKN UNIWARA</span>
                <img src="{{ asset('img/logo_kkn.png') }}" alt="KKN" class="h-7 w-auto rounded" loading="lazy">
                <img src="{{ asset('img/logo_uniwara.png') }}" alt="UNIWARA" class="h-7 w-auto rounded" loading="lazy">
            </p>
        </div>
    </div>
</footer>
