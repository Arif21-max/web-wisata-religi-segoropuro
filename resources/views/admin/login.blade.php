<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login Admin - Segoropuro</title>

    <link rel="icon" type="image/png" href="{{ asset('img/logo.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('img/logo.png') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="flex min-h-screen items-center justify-center bg-brand-950 font-sans">
    <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(circle at 20% 20%, #d9a93c 0, transparent 40%), radial-gradient(circle at 80% 80%, #348362 0, transparent 40%);"></div>

    <div class="relative w-full max-w-md px-4">
        <div class="rounded-3xl border border-white/10 bg-white p-8 shadow-2xl">
            <div class="mb-7 text-center">
                <img src="{{ asset('img/logo.png') }}" alt="Logo" class="mx-auto h-20 w-20 rounded-full object-cover ring-4 ring-brand-100">
                <h1 class="mt-4 font-display text-2xl font-bold text-brand-950">Panel Pengelola</h1>
                <p class="mt-1 text-sm text-stone-500">Masuk untuk mengelola konten wisata religi Segoropuro</p>
            </div>

            @if ($errors->any())
                <div class="mb-5 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                    <ul class="list-inside list-disc space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.login.attempt') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label for="username" class="mb-1.5 block text-sm font-semibold text-stone-700">Username</label>
                    <div class="relative">
                        <i class="fa-solid fa-user absolute left-4 top-1/2 -translate-y-1/2 text-stone-400"></i>
                        <input type="text" id="username" name="username" value="{{ old('username') }}" required autofocus autocomplete="username" placeholder="Masukkan username" class="input-field !ps-11">
                    </div>
                </div>
                <div>
                    <label for="password" class="mb-1.5 block text-sm font-semibold text-stone-700">Password</label>
                    <div class="relative">
                        <i class="fa-solid fa-lock absolute left-4 top-1/2 -translate-y-1/2 text-stone-400"></i>
                        <input type="password" id="password" name="password" required autocomplete="current-password" placeholder="Masukkan password" class="input-field !ps-11">
                    </div>
                </div>
                <div class="flex items-center justify-between text-sm">
                    <label class="flex items-center gap-2 text-stone-600">
                        <input type="checkbox" name="remember" value="1" class="h-4 w-4 rounded border-stone-300 text-brand-700 focus:ring-brand-500">
                        Ingat saya
                    </label>
                    <a href="{{ route('home') }}" class="font-semibold text-brand-700 hover:underline"><i class="fa-solid fa-arrow-left me-1"></i>Kembali ke situs</a>
                </div>
                <button type="submit" class="btn-primary w-full justify-center">
                    <i class="fa-solid fa-right-to-bracket"></i> Masuk
                </button>
            </form>
        </div>

        <p class="mt-6 text-center text-xs text-brand-300">&copy; {{ date('Y') }} Desa Segoropuro. Akses terbatas untuk pengelola.</p>
    </div>
</body>
</html>