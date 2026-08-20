<?php

use App\Models\Kontak;
use Illuminate\Support\Facades\Storage;

if (! function_exists('kontak')) {
    /**
     * Data kontak terkelola dari database (fallback konfigurasi).
     */
    function kontak(): ?Kontak
    {
        return Kontak::query()->latest('id')->first();
    }
}

if (! function_exists('media_url')) {
    /**
     * URL file media (gambar upload atau aset statis).
     */
    function media_url(?string $path): string
    {
        if (! $path) {
            return '';
        }

        if (str_starts_with($path, 'http')) {
            return $path;
        }

        if (str_starts_with($path, 'assets/')) {
            return asset($path);
        }

        return Storage::url($path);
    }
}

if (! function_exists('wa_number')) {
    /**
     * Nomor WhatsApp aplikasi dari konfigurasi.
     */
    function wa_number(): string
    {
        return (string) (kontak()?->whatsapp_number ?? config('segoropuro.whatsapp_number'));
    }
}

if (! function_exists('wa_url')) {
    /**
     * Tautan WhatsApp dengan pesan default bila kosong.
     */
    function wa_url(string $text = null): string
    {
        $text = $text ?: (kontak()?->whatsapp_default_message ?: config('segoropuro.whatsapp_default_message'));
        $number = wa_number();
        if ($number === '') {
            return 'https://wa.me';
        }

        return 'https://api.whatsapp.com/send?phone=' . urlencode($number) . '&text=' . rawurlencode($text);
    }
}

if (! function_exists('sanitize_maps_embed')) {
    /**
     * Sanitasi kode embed Google Maps (iframe atau URL) menjadi iframe aman.
     * Hanya mengizinkan https://www.google.com/maps/embed?pb=... atau
     * https://maps.google.com/maps?output=embed. Selain itu dikembalikan null.
     */
    function sanitize_maps_embed(?string $html): ?string
    {
        $html = trim((string) $html);

        if ($html === '') {
            return null;
        }

        $src = null;

        if (filter_var($html, FILTER_VALIDATE_URL) !== false) {
            $src = $html;
        } else {
            $doc = new DOMDocument();
            libxml_use_internal_errors(true);
            $doc->loadHTML('<?xml encoding="UTF-8">' . $html, LIBXML_NOERROR | LIBXML_NOWARNING);
            libxml_clear_errors();

            $iframes = $doc->getElementsByTagName('iframe');

            if ($iframes->length === 0) {
                return null;
            }

            $src = $iframes->item(0)->getAttribute('src');
        }

        $src = filter_var(trim((string) $src), FILTER_VALIDATE_URL);

        if ($src === false || strtolower((string) parse_url($src, PHP_URL_SCHEME)) !== 'https') {
            return null;
        }

        $host = strtolower((string) parse_url($src, PHP_URL_HOST));
        $path = (string) parse_url($src, PHP_URL_PATH);

        $diizinkan = ($host === 'www.google.com' && $path === '/maps/embed')
            || ($host === 'maps.google.com' && $path === '/maps');

        if (! $diizinkan) {
            return null;
        }

        return '<iframe src="' . e($src) . '" width="100%" height="450" style="border:0" loading="lazy" allowfullscreen referrerpolicy="no-referrer-when-downgrade" title="Peta Lokasi Makam Sayyid Arif Segoropuro"></iframe>';
    }
}

if (! function_exists('unique_slug')) {
    /**
     * Membuat slug unik berdasarkan judul pada tabel tertentu.
     */
    function unique_slug(string $judul, string $table, ?int $ignoreId = null): string
    {
        $base = \Illuminate\Support\Str::slug($judul);
        if ($base === '') {
            $base = 'artikel-' . time();
        }

        $slug = $base;
        $counter = 1;

        while (true) {
            $query = \Illuminate\Support\Facades\DB::table($table)->where('slug', $slug);
            if ($ignoreId) {
                $query->where('id', '!=', $ignoreId);
            }
            if (! $query->exists()) {
                break;
            }
            $slug = $base . '-' . $counter++;
        }

        return $slug;
    }
}
