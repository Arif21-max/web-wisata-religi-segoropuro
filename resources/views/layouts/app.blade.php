<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="theme-color" content="#1e3a2f">

    <title>@yield('title', config('segoropuro.seo.title_default'))</title>
    <meta name="description" content="@yield('description', config('segoropuro.seo.description_default'))">
    <meta name="robots" content="@yield('robots', 'index, follow, max-image-preview:large')">
    <link rel="canonical" href="@yield('canonical', url()->current())">

    <link rel="icon" type="image/png" href="{{ asset('img/logo.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('img/logo.png') }}">

    {{-- Open Graph --}}
    <meta property="og:site_name" content="{{ config('segoropuro.seo.site_name') }}">
    <meta property="og:type" content="@yield('og_type', 'website')">
    <meta property="og:locale" content="id_ID">
    <meta property="og:locale:alternate" content="en_US">
    <meta property="og:title" content="@yield('og_title', $__env->yieldContent('title', config('segoropuro.seo.title_default')))">
    <meta property="og:description" content="@yield('og_description', $__env->yieldContent('description', config('segoropuro.seo.description_default')))">
    <meta property="og:url" content="@yield('canonical', url()->current())">
    <meta property="og:image" content="@yield('og_image', asset(config('segoropuro.seo.og_image_default')))">
    <meta property="og:image:alt" content="@yield('og_image_alt', config('segoropuro.seo.site_name'))">
    <meta property="og:image:width" content="@yield('og_image_width', '1200')">
    <meta property="og:image:height" content="@yield('og_image_height', '630')">

    {{-- Twitter Card --}}
    <meta name="twitter:card" content="@yield('twitter_card', 'summary_large_image')">
    <meta name="twitter:title" content="@yield('og_title', $__env->yieldContent('title', config('segoropuro.seo.title_default')))">
    <meta name="twitter:description" content="@yield('og_description', $__env->yieldContent('description', config('segoropuro.seo.description_default')))">
    <meta name="twitter:image" content="@yield('og_image', asset(config('segoropuro.seo.og_image_default')))">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    @stack('head')

    @if (config('segoropuro.seo.gsc_verification'))
        <meta name="google-site-verification" content="{{ config('segoropuro.seo.gsc_verification') }}">
    @endif

    @if (config('segoropuro.seo.ga4_id'))
        <script async src="https://www.googletagmanager.com/gtag/js?id={{ config('segoropuro.seo.ga4_id') }}"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());
            gtag('config', '{{ config('segoropuro.seo.ga4_id') }}');
        </script>
    @endif

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @yield('jsonld')
</head>
<body class="font-sans" x-data="{ mobileOpen: false, progress: 0 }" @scroll.window="progress = window.scrollY > 40 ? Math.min(100, Math.round((window.scrollY / (document.documentElement.scrollHeight - window.innerHeight)) * 100)) : 0">

    {{-- Progress bar scroll --}}
    <div class="pointer-events-none fixed inset-x-0 top-0 z-[60] h-1 bg-transparent">
        <div class="h-full bg-gradient-to-r from-brand-600 via-gold-500 to-gold-400 shadow-sm transition-[width] duration-150 ease-out" :style="'width: ' + progress + '%'"></div>
    </div>

    <x-layouts.public-navbar/>

    <main>
        @if (session('success'))
            <div class="fixed inset-x-0 top-20 z-50 mx-auto w-fit max-w-2xl px-4">
                <div class="animate-slide-down flex items-center gap-3 rounded-xl border border-emerald-300 bg-emerald-50 px-5 py-3 text-sm font-medium text-emerald-800 shadow-lg" role="alert">
                    <i class="fa-solid fa-circle-check"></i>
                    <span>{{ session('success') }}</span>
                </div>
            </div>
        @endif

        @if (session('error'))
            <div class="fixed inset-x-0 top-20 z-50 mx-auto w-fit max-w-2xl px-4">
                <div class="animate-slide-down flex items-center gap-3 rounded-xl border border-red-300 bg-red-50 px-5 py-3 text-sm font-medium text-red-800 shadow-lg" role="alert">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                    <span>{{ session('error') }}</span>
                </div>
            </div>
        @endif

        @yield('content')
    </main>

    <x-layouts.public-footer/>

    <a href="{{ wa_url() }}" target="_blank" rel="noopener" title="Hubungi WhatsApp" class="fixed bottom-6 right-6 z-40 flex h-14 w-14 items-center justify-center rounded-full bg-emerald-500 text-2xl text-white shadow-xl shadow-emerald-900/30 transition hover:scale-110 hover:bg-emerald-600">
        <span class="animate-ping-slow pointer-events-none absolute inset-0 rounded-full bg-emerald-500/50"></span>
        <i class="fa-brands fa-whatsapp relative"></i>
    </a>

    @stack('scripts')
</body>
</html>
