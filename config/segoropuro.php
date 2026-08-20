<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Pengaturan Umum Website Segoropuro
    |--------------------------------------------------------------------------
    */

    'whatsapp_number' => env('WHATSAPP_NUMBER', '628123456789'),

    'whatsapp_default_message' => env('WHATSAPP_DEFAULT_MESSAGE', 'Halo Pengelola Makam Sayyid Arif Segoropuro, saya ingin bertanya informasi ziarah.'),

    'google_maps_embed' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3952.121456753354!2d112.883!3d-7.764!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zN8KwNDUnNTAuNCJTIDExMsKwNTMnMDIuNCJF!5e0!3m2!1sid!2sid!4v1700000000000!5m2!1sid!2sid',

    /*
    |--------------------------------------------------------------------------
    | Pengaturan SEO
    |--------------------------------------------------------------------------
    */

    'seo' => [
        'site_name' => env('SEO_SITE_NAME', 'Makam Sayyid Arif Segoropuro'),

        'title_default' => env('SEO_TITLE_DEFAULT', 'Wisata Religi Makam Sayyid Arif Segoropuro'),

        'description_default' => env(
            'SEO_DESCRIPTION_DEFAULT',
            'Portal wisata religi Makam Sayyid Arif Segoropuro di Desa Segoropuro, Kecamatan Rejoso, Kabupaten Pasuruan. Informasi ziarah, sejarah, spot wisata, dan agenda kegiatan tersedia di sini.'
        ),

        // Path gambar default untuk Open Graph / Twitter Card (di luar folder upload).
        'og_image_default' => env('SEO_OG_IMAGE', 'assets/img/logo.png'),

        // Kode verifikasi Google Search Console (dari env, opsional).
        'gsc_verification' => env('GSC_VERIFICATION', ''),

        // Measurement ID Google Analytics 4 (dari env, opsional).
        'ga4_id' => env('GA4_MEASUREMENT_ID', ''),

        // Lokasi geografis untuk structured data (koordinat kawasan makam).
        'latitude' => env('SEO_LATITUDE', '-7.764'),
        'longitude' => env('SEO_LONGITUDE', '112.883'),

        'kecamatan' => env('SEO_KECAMATAN', 'Rejoso'),
        'kabupaten' => env('SEO_KABUPATEN', 'Pasuruan'),
        'provinsi' => env('SEO_PROVINSI', 'Jawa Timur'),
    ],
];
